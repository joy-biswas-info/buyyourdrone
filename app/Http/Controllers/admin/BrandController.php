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
        $brands = Brand::latest()->get();
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
            ]);
            $brands->save();
            return back()->with('success', 'Brand created successfully');
        } else {
            return back()->withErrors($validator)->withInput()->with('error', 'Brand not created');
        }

    }
    public function edit()
    {

    }
    public function update()
    {

    }
    public function distroy()
    {

    }

}