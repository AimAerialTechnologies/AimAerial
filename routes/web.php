<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\DataController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DroneController;
use App\Http\Controllers\QrCodeController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\TierController;
use App\Http\Controllers\PositionController;



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
    // return view('welcome');
    return view('welcome');
})->name('welcome');

// Route::get('/store', function () {
//     // return view('welcome');
//     return view('drone.index');
// })->name('store');
//

// Route::get('/drone', function () {
//   $response['status'] = "error";
//   $response['message'] = "test";
//
//   return redirect()->route('dashboard')->with($response['status'],$response['message']);
//     return view('drone.index');
// })->name('drones');

Route::get('/qrcode', [QrCodeController::class, 'index'])->name('qrcode');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'RoleVerify',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Route::get('/drone-list', function(){
    //     return view('dashboard.admin.drones.index');
    // })->name('drone-list');

    // Route::resource('users', UserController::class);
    Route::middleware(['permission:user-list'])->group(function () {
      Route::get('users', [UserController::class, 'index'])->name('users.index');
      Route::get('users/{user}', [UserController::class, 'show'])->name('users.show');
      Route::post('users-store', [UserController::class, 'store'])->name('users.store');
      Route::post('users-destroy', [UserController::class, 'destroy'])->name('users.destroy');
      Route::post('users-edit', [UserController::class, 'edit'])->name('users.edit');
    });

    Route::get('feedback', [UserController::class, 'feedback'])->name('users.feedback');
    Route::get('contact', [UserController::class, 'contact'])->name('users.contact');


    // Route::resource('drones', DroneController::class);
    Route::get('drones', [DroneController::class, 'index'])->name('drones.index');
    Route::get('drones/{drone}', [DroneController::class, 'show'])->name('drones.show');
    Route::post('drones-store', [DroneController::class, 'store'])->name('drones.store');
    Route::post('drones-edit', [DroneController::class, 'edit'])->name('drones.edit');
    Route::post('drones-destroy', [DroneController::class, 'destroy'])->name('drones.destroy');
    // Route::get('drone', [DroneController::class, 'user'])->name('drones.user');

    Route::middleware(['permission:company-list'])->group(function () {
    Route::get('company', [CompanyController::class, 'index'])->name('company.index');
    Route::get('company/{company}', [CompanyController::class, 'show'])->name('company.show');
    Route::post('company-store', [CompanyController::class, 'store'])->name('company.store');
    Route::post('company-edit', [CompanyController::class, 'edit'])->name('company.edit');
    Route::post('company-destroy', [CompanyController::class, 'destroy'])->name('company.destroy');
    });

    // Regulator
    Route::get('companies', [CompanyController::class, 'user'])->name('company.user');
    Route::post('companies-edit', [CompanyController::class, 'edit'])->name('company.user.edit');
    // Route::get('/tiers', function(){
    //     return view('dashboard.admin.tiers.index');
    // })->name('tiers');

    Route::get('tiers', [TierController::class, 'index'])->name('tiers.index');
    Route::get('tiers/{tier}', [TierController::class, 'show'])->name('tiers.show');
    Route::post('tiers/updateRolePermission', [TierController::class, 'updateRolePermission'])->name('tiers.updateRolePermission');
    Route::post('tiers/updateRole', [TierController::class, 'updateRole'])->name('tiers.updateRole');

    Route::get('position', [PositionController::class, 'index'])->name('position.index');
    Route::get('position/show/{position}', [PositionController::class, 'show'])->name('position.show');
    Route::post('position/store', [PositionController::class, 'store'])->name('position.store');
    Route::post('position/update', [PositionController::class, 'update'])->name('position.update');
    Route::post('position/destroy', [PositionController::class, 'destroy'])->name('position.destroy');
    Route::post('position/updateDataAccess', [PositionController::class, 'updateDataAccess'])->name('position.updateDataAccess');
    Route::post('position/updateDataMenu', [PositionController::class, 'updateDataMenu'])->name('position.updateDataMenu');

    Route::get('data-manage', [DataController::class, 'index'])->name('data.index');
    Route::get('data/{data}', [DataController::class, 'show'])->name('data.show');


});
Route::get('d/{id}', [DroneController::class, 'gdrone'])->name('drones.get');
Route::get('qr/{id}', [DroneController::class, 'qrCode'])->name('drones.qr');
