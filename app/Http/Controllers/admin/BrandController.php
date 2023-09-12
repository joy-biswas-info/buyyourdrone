<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Validator;
use View;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::latest('id');
        $brands = $brands->paginate(10);
        return View('admin.brand.index', [
            'data' => $brands
        ]);

    }
    public function create(Request $request)
    {
        return View('admin.brand.create');
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'slug' => 'required|unique:brands,slug',
        ]);
        if ($validator->passes()) {
            $brands = new Brand([
                'name' => $request->name,
                'slug' => $request->slug,
                'status' => $request->status,
            ]);
            $brands->save();
            return back()->with('success', 'Brand created successfully');
        } else {
            return back()->withErrors($validator)->withInput()->with('error', 'Brand not created');
        }

    }
    public function edit($id, Request $request)
    {
        $brand = Brand::find($id);
        if (empty($brand)) {
            return back()->with('error', 'No record found');
        }
        return View('admin.brand.edit', [
            'data' => $brand
        ]);
    }
    public function update($id, Request $request)
    {
        $brand = Brand::find($id);
        if (empty($brand)) {
            return back()->withErrors('error', 'No record found ');
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'slug' => 'required|unique:brands,slug,' . $brand->id . ',id',
        ]);
        if ($validator->passes()) {
            $brand->name = $request->name;
            $brand->slug = $request->slug;
            $brand->status = $request->status;
            $brand->save();
            return back()->with('success', 'Brand update successfully');
        } else {
            return back()->withErrors($validator)->withInput()->with('error', 'Brand not updated');
        }
    }
    public function distroy($id, Request $request)
    {
        $brand = Brand::find($id);
        if (empty($brand)) {
            return back()->withErrors('error', 'No record found');
        } else {
            $brand->delete();
            return back()->with('success', 'Brand deleted successfully');
        }
    }

}