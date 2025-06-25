<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Category;
use App\Models\BrandIdentity;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBrandIdentityRequest;
use App\Http\Requests\UpdateBrandIdentityRequest;

class BrandIdentityController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:brand-identities');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $buttons = [
            [
                'name' => '<i class="fa fa-plus"></i>&nbsp' . __('Add New'),
                'url' => '#',
                'target' => '#addNewItemDrawer',
            ]
        ];
        $categories = Category::whereType('brand')->get();
        $identities = BrandIdentity::with('category')->latest()->paginate();
        $total = BrandIdentity::count();
        $active = BrandIdentity::where('status', 'active')->count();
        $inActive = BrandIdentity::where('status', 'inactive')->count();

        return Inertia::render('Admin/BrandIdentity/Index', [
            'identities' => $identities,
            'categories' => $categories,
            'total' => $total,
            'active' => $active,
            'inActive' => $inActive,
            'buttons' => $buttons,
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBrandIdentityRequest $request)
    {
        BrandIdentity::create($request->validated());
        return back()->with('success', 'Saved successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBrandIdentityRequest $request, BrandIdentity $brandIdentity)
    {
        $brandIdentity->update($request->validated());
        return back()->with('info', 'Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BrandIdentity $brandIdentity)
    {
        $brandIdentity->delete();
        return back()->with('danger', 'Deleted successfully');
    }
}
