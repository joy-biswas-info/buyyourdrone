<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Validator;

class SubCategoryController extends Controller
{
    public function index(Request $request)
    {
        // Start with the base query for subcategories
        $query = SubCategory::with('category');

        // Filtering by keyword
        if (!empty($request->get('keyword'))) {
            $query->where('name', 'like', '%' . $request->get('keyword') . '%');
        }

        // Sorting logic
        $sort = $request->input('sort', 'id');
        $direction = $request->input('direction', 'asc');

        // Apply sorting to the query
        $query->orderBy($sort, $direction);

        // Paginate the results
        $subCategories = $query->paginate(10);

        return view('admin.subcategory.index', [
            'data' => $subCategories,
            'sort' => $sort,
            'direction' => $direction,
        ]);
    }
    public function create()
    {
        $categories = Category::orderBy('name', 'ASC')->get();
        return View('admin.subcategory.create', [
            'data' => $categories
        ]);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), ([
            'name' => 'string|required',
            'slug' => 'string|required|unique:sub_categories',
            'category_id' => 'numeric|required|min:1',
            'status' => 'required'
        ]));
        if ($validator->passes()) {
            $subcategory = new SubCategory([
                'name' => $request->name,
                'slug' => $request->slug,
                'category_id' => $request->category_id,
                'status' => $request->status,
            ]);
            // dd($subcategory);
            $subcategory->save();
            return back()->with('success', 'Category created successfully');
        } else {
            return back()->withErrors($validator)->withInput();
        }
        ;

    }
    public function edit($subCategoryId, Request $request)
    {
        $subcategory = SubCategory::find($subCategoryId);
        if (empty($subcategory)) {
            return back()->with('error', 'No subcategory found');
        }
        $categories = Category::orderBy('name', 'ASC')->get();
        // dd($categories);
        return View('admin.subcategory.edit', [
            'data' => $subcategory,
            'categories' => $categories
        ]);

    }
    public function update($subCategoryId, Request $request)
    {
        $subCategory = subCategory::find($subCategoryId);
        if (empty($subCategory)) {
            return redirect(route("categories.index"))->with('error', 'Category Not Found');
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'slug' => 'required|unique:sub_categories,slug,' . $subCategory->id . ',id',
            'status' => 'required',
        ]);


        if ($validator->passes()) {
            $subCategory->name = $request->name;
            $subCategory->slug = $request->slug;
            $subCategory->status = $request->status;
            $subCategory->category_id = $request->category_id;
            $subCategory->save();
            return back()->with('success', 'Sub category updated');
        } else {
            return back()->withErrors('error', 'category not updated');

        }


    }
    public function distroy(
        $id, Request $request
    ) {
        $subCategory = SubCategory::find($id);
        if (empty($subCategory)) {
            return back()->with('error', 'Sub category not found');
        } else {
            $subCategory->delete();
            return back()->with('success', 'Subcategory deleted successfully');
        }
    }
}