<?php

use App\Http\Controllers\API\ApiDataController;
use App\Http\Controllers\API\PulseController;
use App\Http\Controllers\User\DeviceController;
use App\Http\Controllers\User\PatientController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('pulse-data', [PulseController::class, 'index'])->name('pulse.data');
Route::get('pulse-data', [PulseController::class, 'index'])->name('pulse.data');
Route::post('patient-pulse', [PulseController::class, 'getPatientPulse'])->name('patient.pulse');
Route::post('latest-patient-pulse', [PulseController::class, 'getLatestPatientPulse'])->name('latest.patient.pulse');
Route::post('device-data', [ApiDataController::class, 'getDevices'])->name('device.data');
Route::post('patient-data', [ApiDataController::class, 'getPatients'])->name('patient.data');
Route::post('user-patient-data/{user}', [ApiDataController::class, 'getUserPatients'])->name('user.patient.data');
Route::post('user-patient-pulse/{id}', [PulseController::class, 'getUserPatientPulse'])->name('user.patient.pulse');
Route::post('user-data', [ApiDataController::class, 'getUsers'])->name('user.data');

Route::get('user/device/edit', [DeviceController::class, 'edit'])->name('user.device.edit');
Route::get('user/patient/edit', [PatientController::class, 'edit'])->name('user.patient.edit');
Route::get('user/User/edit', [UserController::class, 'edit'])->name('user.user.edit');