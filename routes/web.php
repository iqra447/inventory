<?php
use App\Http\Controllers\DepartmentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MakeController;
use App\Http\Controllers\ProductTypeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ProductItemController;
use App\Http\Controllers\ProductSupplierController;
use App\Http\Controllers\AssignController;
use App\Http\Controllers\ProductSerialNumberController;


Route::resource('users', UserController::class);
Route::resource('departments', DepartmentController::class);
Route::resource('suppliers', SupplierController::class);
Route::resource('stores', StoreController::class);
Route::resource('categories', CategoryController::class);
Route::resource('makes', MakeController::class);
Route::resource('product-types', ProductTypeController::class);
Route::resource('inventory', InventoryController::class);
Route::resource('product-items', ProductItemController::class);
Route::resource('product-suppliers', ProductSupplierController::class);
Route::resource('assignments', AssignController::class);
Route::resource('product-serial-numbers', ProductSerialNumberController::class);


Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::middleware(['web'])->group(function () {
    Route::resource('products', ProductController::class);
});
    

require __DIR__.'/auth.php';
