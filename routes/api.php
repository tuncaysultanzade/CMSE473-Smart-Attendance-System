<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;


Route::middleware(['web', 'auth:sanctum'])->post(
    '/teacher/qrmark',
    [AttendanceController::class, 'markwithQr']
)->name('api.teacher.qrmark');

//Route::get('/test', function () {
//    return response()->json([
 //       'message' => 'API is working correctly!',
  //      'status'  => 'success',
  //  ]);
//});