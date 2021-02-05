<?php

use App\Http\Controllers\ItemController;
use App\Http\Controllers\MenuAccessController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\MultimediaController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderDetailController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PermissionRoleController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RemissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RoleUserController;
use App\Http\Controllers\SecurityController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');

Route::middleware(['auth:sanctum', 'verified'])->group(function(){

    Route::resources([
        'item' => ItemController::class,
        'menu' => MenuController::class,
        'multimedia' => MultimediaController::class,
        'order' => OrderController::class,
        'orderDetail' => OrderDetailController::class,
        'permission' => PermissionController::class,
        'permissionRole' => PermissionRoleController::class,
        'product' => ProductController::class,
        'remission' => RemissionController::class,
        'role' => RoleController::class,
        'roleUser' => RoleUserController::class,
        'user' => UserController::class
    ]);
    //Route::get('permission/{id}',[PermissionController::class, 'show'])->name('permission.show');
    Route::post('permission/update',[PermissionController::class, 'update'])->name('permission.update');
    Route::get('security/getAccessMenu',[MenuAccessController::class, 'getAccessMenu']);
    Route::get('security/{role}/assignPermission',[SecurityController::class, 'assignPermission'])->name('security.assignPermission');

});
