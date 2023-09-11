<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\TempImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rules\Unique;
use Validator;
use Image;

class CategoryController extends Controller
{
    //! category List 
    public function index(Request $request)
    {
        $categories = Category::latest();
        if (!empty($request->get('keyword'))) {
            $categories = $categories->where('name', 'like', '%' . $request->get('keyword') . '%');
        }
        $categories = $categories->paginate(10);
        return View('admin.category.list', [
            'categories' => $categories
        ]);
    }
    // !Show Create Category
    public function create()
    {
        return View('admin.category.create');
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'slug' => 'required|unique:categories',
            'status' => 'required',
        ]);

        if ($validator->passes()) {
            $category = new Category([
                'name' => $request->name,
                'slug' => $request->slug,
                'status' => $request->status,
            ]);
            if ($request->image_id) {
                $tempImage = TempImage::find($request->image_id);
                $extArray = explode('.', $tempImage->name);
                $ext = last($extArray);
                $newImageName = $request->image_id . '.' . $ext;
                $sPath = public_path() . '/temp/' . $tempImage->name;
                $dPath = public_path() . '/uploads/category/thumb/' . $newImageName;
                $img = Image::make($sPath);
                // $img->resize(400, 600);
                $img->fit(450, 600, function ($constraint) {
                    $constraint->upsize();
                });
                $img->save($dPath);
                // File::copy($sPath, $dPath);
                $category = new Category([
                    'name' => $request->name,
                    'slug' => $request->slug,
                    'status' => $request->status,
                    'image' => $newImageName
                ]);
                // $category->save();
            }
            $category->save();

            return back()->with('success', 'Category created successfully');
        } else {
            return back()->withErrors($validator)->withInput();
        }
    }
    public function edit($categoryId, Request $request)
    {
        // dd($categoryId);
        $category = Category::find($categoryId);
        if (empty($category)) {
            return redirect(route("categories.index"))->with('error', 'Category Not Found');
        }
        return View('admin.category.edit', [
            'category' => $category,
        ]);
    }
    public function update($categoryId, Request $request)
    {
        $category = Category::find($categoryId);
        if (empty($category)) {
            return redirect(route("categories.index"))->with('error', 'Category Not Found');
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'slug' => 'required',
            'status' => 'required',
        ]);


        if ($validator->passes()) {
            $category->name = $request->name;
            $category->slug = $request->slug;
            $category->status = $request->status;

            //! Get Old Image 
            $oldImage = $category->image;

            if ($request->image_id) {
                $tempImage = TempImage::find($request->image_id);
                $extArray = explode('.', $tempImage->name);
                $ext = last($extArray);
                $newImageName = $category->id . '_' . time() . '.' . $ext;
                $sPath = public_path() . '/temp/' . $tempImage->name;
                $dPath = public_path() . '/uploads/category/thumb/' . $newImageName;
                $img = Image::make($sPath);
                // $img->resize(400, 600);
                $img->fit(450, 600, function ($constraint) {
                    $constraint->upsize();
                });
                $img->save($dPath);
                $category->image = $newImageName;
            }

            File::delete(public_path() . '/uploads/category/thumb/' . $oldImage);
            $category->save();
            return back()->with('success', 'Category updated successfully');
        } else {
            return back()->withErrors('error', 'category not updated');
        }
    }
    public function distroy($categoryId, Request $request)
    {
        $category = Category::find($categoryId);
        if (empty($category)) {
            return response()->json([
                'status' => false,
                'message' => 'Category Not found'
            ]);
        }
        //! Get Old Image 
        $oldImage = $category->image;
        File::delete(public_path() . '/uploads/category/thumb/' . $oldImage);
        $category->delete();
        return response()->json([
            'status' => true,
            'message' => 'Category deleted successfully'
        ]);
    }
}