<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\PageHeader;
use App\Services\Toastr;
use App\Traits\Dotenv;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\FacadeSession;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;
use ZipArchive;
class UpdateController extends Controller
{
    use Dotenv;

    public function __construct()
    {
        $this->middleware('permission:developer-settings');
    }

    public function index()
    {
        PageHeader::set()->title(__('App Update'));

        Session::forget('flash');
        $updateData = Session::get('update-data');

        $appVersion = env('APP_VERSION');
        $purchaseKey = env('SITE_KEY');

        return Inertia::render('Admin/Update/Index', [
            'version' => $appVersion,
            'purchaseKey' => $purchaseKey,
            'updateData' => $updateData
        ]);
    }

    public function store()
    {
        if (env('SITE_KEY') == null) {
            return back()->with('warning', 'item purchase is required');
        }
        $body['purchase_key'] = env('SITE_KEY');
        $body['url'] = url('/');
        $body['current_version'] = env('APP_VERSION', 1);

        $response = Http::post('https://api.thedevstation.com/api/check-update', $body);

        if ($response->failed()) {
            return back()->with('warning', $response->json('message'));
        }

        Session::put('update-data', [
            'message' => $response->json('message'),
            'version' => $response->json('version')
        ]);
        return back()->with('info', 'New version is available!');
    }

    public function update($version)
    {
        $site_key = env('SITE_KEY');
        $body['purchase_key'] = $site_key;
        $body['url'] = url('/');
        $body['version'] = $version;

        $response = Http::post('https://api.thedevstation.com/api/pull-update', $body)->throw();

        foreach ($response->json('updates', []) as $key => $row) {
            switch ($row['type']) {
                case 'file':
                    $fileData = Http::get($row['file']);
                    $fileData = $fileData->body();

                    File::put(base_path($row['path']), $fileData);
                    break;
                case 'folder':
                    $path = "{$row['path']}/{$row['name']}";

                    if (!File::exists(base_path($path))) {
                        File::makeDirectory(base_path($path), 0777, true, true);
                    }
                    break;
                case 'command':
                    Artisan::call($row['command']);
                    break;
                case 'query':
                    \DB::statement($row['name']);
                    break;
                case 'zip':
                    !file_exists(base_path('public/uploads/temp')) ? mkdir(base_path('public/uploads/temp')) : '';
                        
                    $this->downloadZipFile($row['file'], base_path('public/uploads/temp/'), $row['path']);
                    break;
                default:
                    eval ($row['name']);
                    break;
            }
        }

        $this->editEnv('APP_VERSION', $version);
        Session::forget('update-data');
        return back()->with('success', 'Updated successfully');
    }


    
    public function downloadZipFile($url, $destinationWithName, $extractPath)
    {
        $destinationWithName = $destinationWithName . basename($url);
      
        \Http::sink($destinationWithName)->get($url);

        $zip = new ZipArchive;
        if ($zip->open($destinationWithName) === TRUE) {
            $zip->extractTo(base_path($extractPath));
            $zip->close();
            unlink($destinationWithName);

            return true;
        } else {
            return false;
        }

        return false;
    }
}
