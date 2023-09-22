<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\Backend\Admin\AdminController;
use App\Http\Controllers\Backend\User\UserController;
use App\Http\Controllers\Backend\VideoCategoryController;
use App\Http\Controllers\Backend\VideoController;

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


Auth::routes();

Route::get('/', [FrontendController::class, 'index'])->name('home');
Route::get('single-video/{id}', [FrontendController::class, 'single'])->name('home.single');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('admin/dashboard',[AdminController::class, 'admin'])->name('admin.dashboard');

    // User Management Routes
    Route::group(['as' => 'user.', 'prefix' => 'user'], function () {
        Route::get('index', [AdminController::class, 'index'])->name('index');
        Route::get('create', [AdminController::class, 'create'])->name('create');
        Route::post('store', [AdminController::class, 'store'])->name('store');
        Route::get('show/{id}', [AdminController::class, 'show'])->name('show');
        Route::get('edit/{id}', [AdminController::class, 'edit'])->name('edit');
        Route::post('update/{id}', [AdminController::class, 'update'])->name('update');
        Route::get('delete/{id}', [AdminController::class, 'delete'])->name('delete');
    });
    Route::group(['as' => 'video.', 'prefix' => 'video'], function () {
        // Category Routes
        Route::get('category/index', [VideoCategoryController::class, 'index'])->name('cat.index');
        Route::get('category/create', [VideoCategoryController::class, 'create'])->name('cat.create');
        Route::post('category/store', [VideoCategoryController::class, 'store'])->name('cat.store');
        Route::get('category/show/{id}', [VideoCategoryController::class, 'show'])->name('cat.show');
        Route::get('category/edit/{id}', [VideoCategoryController::class, 'edit'])->name('cat.edit');
        Route::post('category/update/{id}', [VideoCategoryController::class, 'update'])->name('cat.update');
        Route::get('category/delete/{id}', [VideoCategoryController::class, 'delete'])->name('cat.delete');
        Route::get('category/status/{id}', [VideoCategoryController::class, 'status'])->name('cat.status');
        // Video Routes
        Route::get('data/index', [VideoController::class, 'index'])->name('index');
        Route::get('data/create', [VideoController::class, 'create'])->name('create');
        Route::post('data/store', [VideoController::class, 'store'])->name('store');
        Route::get('data/show/{id}', [VideoController::class, 'show'])->name('show');
        Route::get('data/edit/{id}', [VideoController::class, 'edit'])->name('edit');
        Route::post('data/update/{id}', [VideoController::class, 'update'])->name('update');
        Route::get('data/delete/{id}', [VideoController::class, 'delete'])->name('delete');
        Route::get('data/status/{id}', [VideoController::class, 'status'])->name('status');
    });
});

Route::middleware(['auth', 'user'])->group(function () {
    Route::get('user/dashboard',[UserController::class, 'user'])->name('user.dashboard');
});


