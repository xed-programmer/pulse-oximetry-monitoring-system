<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\User\DeviceController;
use App\Http\Controllers\User\PatientController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', [HomeController::class, 'index'])->name('home');

Auth::routes();

Route::group(['middleware'=>'auth'], function(){
    
    Route::group(['prefix'=>'admin', 'as'=>'admin.'], function(){
        Route::get('/', [AdminController::class, 'index'])->name('index');
    });

    Route::group(['prefix'=>'user', 'as'=>'user.'], function(){
        Route::get('/', [UserController::class, 'index'])->name('index');

        // Device 
        Route::group(['prefix'=>'device', 'as'=>'device.'], function(){
            Route::get('/', [DeviceController::class, 'index'])->name('index');
            Route::post('/', [DeviceController::class, 'store'])->name('store');
            // Route::get('/{device}', [DeviceController::class, 'edit'])->name('edit');
            Route::put('/', [DeviceController::class, 'update'])->name('update');
            Route::delete('/', [DeviceController::class, 'destroy'])->name('delete');
        });
    
        // Patient
        Route::group(['prefix'=>'patient', 'as'=>'patient.'], function(){
            Route::get('/', [PatientController::class, 'index'])->name('index');
            Route::post('/', [PatientController::class, 'store'])->name('store');
            Route::get('/show', [PatientController::class, 'show'])->name('show');
            Route::put('/', [PatientController::class, 'update'])->name('update');
            Route::delete('/', [PatientController::class, 'destroy'])->name('delete');
        });
    });
});