<?php

use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\BrandController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\SubCategoryController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\TempImageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/shop', [ShopController::class, 'index'])->name('shop');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    // Categories Routes 
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories/create', [CategoryController::class, 'store'])->name('categories.create');
    Route::put('/categories/{category}/update', [CategoryController::class, 'update'])->name('category.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'distroy'])->name('category.delete');
    Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::post('/upload-temp-image', [TempImageController::class, 'index'])->name('temp-images.create');

    // ! Sub Categories 
    Route::get('/subcategories', [SubCategoryController::class, 'index'])->name('sub.category.index');
    Route::get('/subcategories/create', [SubCategoryController::class, 'create'])->name('sub.category.create');
    Route::post('/subcategories/create', [SubCategoryController::class, 'store'])->name('sub.category.store');
    Route::get('/subcategories/{subcategory}/edit', [SubCategoryController::class, 'edit'])->name('sub.category.edit');
    Route::put('/subcategories/{subcategory}/update', [SubCategoryController::class, 'update'])->name('sub.category.update');
    Route::delete('/subcategories/{subcategory}', [SubCategoryController::class, 'distroy'])->name('sub.category.delete');


    // !Brands 
    Route::get('/brands', [BrandController::class, 'index'])->name('brand.index');
    Route::get('/brands/create', [BrandController::class, 'create'])->name('brand.create');
    Route::post('/brands/create', [BrandController::class, 'store'])->name('brand.store');
    Route::get('/brands/{brand}/edit', [BrandController::class, 'edit'])->name('brand.edit');
    Route::put('/brands/{brand}/update', [BrandController::class, 'update'])->name('brand.update');
    Route::delete('/brands/{delete}', [BrandController::class, 'create'])->name('brand.delete');

});


require __DIR__ . '/auth.php';