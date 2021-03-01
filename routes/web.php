<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\ClientStorageController;
use App\Http\Controllers\ConsignmentController;
use App\Http\Controllers\ConsignmentStorageController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\MultimediaController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderDetailController;
use App\Http\Controllers\OrderDetailStorageController;
use App\Http\Controllers\OrderStorageController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PermissionRoleController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductStorageController;
use App\Http\Controllers\RemissionController;
use App\Http\Controllers\RemissionStorageController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RoleUserController;
use App\Http\Controllers\SecurityController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserStorageController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\VehicleStorageController;
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

Route::middleware(['auth:sanctum', 'verified'])->group(function () {

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
        'user' => UserController::class,
        'client' => ClientController::class,
        'vehicle' => VehicleController::class,
        'consignment' => ConsignmentController::class
    ]);
    Route::get('pdf.reportclient', [ClientController::class, 'imprimir']);
    Route::get('security/getAccessMenu', [MenuAccessController::class, 'getAccessMenu']);
    Route::get('security/{role}/assignPermission', [SecurityController::class, 'assignPermission'])->name('security.assignPermission');

    Route::put('updateStatus/{id}/user', [UserController::class, 'updateStatus'])->name('updateStatus.user');
    Route::get('editstatus/{vehicle}/vehicle', [VehicleController::class, 'editStatus'])->name('editStatus.vehicle');
    Route::put('updateStatus/{vehicle}/vehicle', [VehicleController::class, 'updateStatus'])->name('updateStatus.vehicle');

    // TODO API: mover estas rutas al archivo api route cuando se configure este metodo

    Route::put('updateStatus/{id}/product',
        [ProductController::class, 'updateStatus']
    );

    Route::get('getPaginateAllProducts/products',
        [ProductStorageController::class, 'getPaginateAllProducts']
    );

    Route::get('getPaginateAllRemissions/remission',
        [RemissionStorageController::class, 'getPaginateAllRemissions']
    );

    Route::get('getMultimediaFilesByProduct/{id}/products',
        [ProductStorageController::class, 'getMultimediaFilesByProduct']
    );

    Route::get('getMultimediaFilesByClient/{id}/client',
        [ClientStorageController::class, 'getMultimediaFilesByClient']
    );

    Route::get('getMultimediaFilesByVehicle/{id}/vehicle',
        [VehicleStorageController::class, 'getMultimediaFilesByVehicle']
    );

    Route::get('getMultimediaFilesByConsignment/{id}/consignment',
        [ConsignmentStorageController::class, 'getMultimediaFilesByConsignment']
    );

    Route::get('getPaginateAllUsers/users',
        [UserStorageController::class, 'getPaginateAllUsers']
    );
    Route::get('getAllOrders/order',
        [OrderStorageController::class, 'getAllOrders']
    );
    Route::get('getOrderByConsecutiveOrClient/order',
        [OrderStorageController::class, 'getOrderByConsecutiveOrClient']
    );
    Route::get('getOrdersByUserId/order',
        [OrderStorageController::class, 'getOrdersByUserId']
    );
    Route::get('getOrderDetailsByOrderId/orderDetail',
        [OrderDetailStorageController::class, 'getOrderDetailsByOrderId']
    );
    Route::get('getAllConsignments/consignments',
        [ConsignmentStorageController::class, 'getAllConsignments']
    );
    
    Route::get('getConsignment/consignments',
        [ConsignmentStorageController::class, 'getConsignment']
    );
    Route::get('getMultimediaConsignmentsByOrder',
        [ConsignmentStorageController::class, 'getMultimediaConsignmentsByOrder']
    );
    Route::get('getClients/client',
        [ClientStorageController::class, 'getClients']
    );
    Route::get('getClientWithOrders/client',
        [ClientStorageController::class, 'getClientWithOrders']
    );
    Route::get('getClientsPaginate/client',
        [ClientStorageController::class, 'getClientsPaginate']
    );
    Route::get('getPaginateAllVehicles/vehicles',
        [VehicleStorageController::class, 'getVehiclesPaginate']
    );

    Route::put('cancel/{id}/order',
        [OrderController::class, 'cancel']
    );
    Route::put('updateStatusOrder/{id}/order',
        [OrderController::class, 'updateStatusOrder']
    );
    Route::get('sendEmailUpdate/{id}/order',
        [OrderController::class, 'sendEmailUpdate']
    );

    Route::get('download/{id}/multimedia',
        [MultimediaController::class, 'download']
    );

    // End TODO API
});
