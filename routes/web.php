<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Backend\Admin\AdminController;
use App\Http\Controllers\Backend\User\UserController;

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

Route::get('/', [HomeController::class, 'index'])->name('home');

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
});

Route::middleware(['auth', 'user'])->group(function () {
    Route::get('user/dashboard',[UserController::class, 'user'])->name('user.dashboard');
});


