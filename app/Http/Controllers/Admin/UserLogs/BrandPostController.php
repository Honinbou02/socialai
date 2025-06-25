<?php

namespace App\Http\Controllers\Admin\UserLogs;

use App\Models\Brand;
use App\Models\BrandPost;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\PageHeader;

class BrandPostController extends Controller
{
    public function index()
    {
        PageHeader::set()->title("User Brand Posts");

        $posts = BrandPost::query()->with(['user'])->latest()->paginate();

        return inertia('Admin/UserLog/BrandPost/Index', [
            'posts' => $posts,
            'countTotal' => BrandPost::query()->count(),
            'countUnpublished' => BrandPost::query()->where('status', 'draft')->count(),
            'countPublished' => BrandPost::query()->where('status', 'published')->count(),
        ]);
    }

    public function destroy(BrandPost $brandPost)
    {
        $brandPost->delete();
        return back()->with('success', 'Deleted Successfully');
    }
}
