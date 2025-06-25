<?php

namespace App\Http\Controllers\Admin;

use App\Models\Option;
use Illuminate\Http\Request;
use App\Actions\OptionUpdate;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class OptionController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:page-settings');
    }


    public function update(Request $request, $key, OptionUpdate $optionUpdate)
    {
        $option = Option::firstOrNew(['key' => $key]);

        if ($key === 'tax') {
            $option->value = $request->tax;
            $option->save();
        } else {
            $optionUpdate->update($key);
        }

        return back();
    }
}
