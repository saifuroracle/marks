<?php

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\AuthController;


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::post('/loginPost',  [AuthController::class, 'loginPost'])->name('loginPost');
Route::get('/home', [HomeController::class, 'index'])->name('home');



Route::group(['middleware' => ['auth']], function() {

    // manage permission routes
    Route::get('/manage-permissions', [PermissionController::class, 'managepermissions'])->name('managepermissions');
    Route::post('/createpermissionsave', [PermissionController::class, 'createpermissionsave'])->name('createpermissionsave');
    Route::post('/editpermissionsave', [PermissionController::class, 'editpermissionsave'])->name('editpermissionsave');
    Route::post('/deletepermission', [PermissionController::class, 'deletepermission'])->name('deletepermission');

    // manage role routes
    Route::get('/manage-roles', [RoleController::class, 'manageroles'])->name('manageroles');
    Route::post('/createrolesave', [RoleController::class, 'createrolesave'])->name('createrolesave');
    Route::post('/editrolesave', [RoleController::class, 'editrolesave'])->name('editrolesave');
    Route::post('/deleterole', [RoleController::class, 'deleterole'])->name('deleterole');

    // manage user routes
    Route::get('/manage-users', [UserController::class, 'manageusers'])->name('manageusers');
    Route::post('/createusersave', [UserController::class, 'createusersave'])->name('createusersave');
    Route::post('/editusersave', [UserController::class, 'editusersave'])->name('editusersave');

});

