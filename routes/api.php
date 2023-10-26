<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\MarkController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([ 'middleware' => 'api','prefix'=>'auth'], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::post('/logout', [AuthController::class, 'logout']);

});

Route::post('/user',[UserController::class,'create_users']);
Route::put('/user/{id}',[UserController::class,'update_users']);
Route::delete('/user/{id}',[UserController::class,'delete_users']);
Route::get('/listuser',[UserController::class,'list_users']);


Route::post('/dept',[DepartmentController::class,'create_department']);
Route::put('/dept/{id}',[DepartmentController::class,'update_department']);
Route::delete('/deldept/{id}',[DepartmentController::class,'delete_department']);
Route::get('/getdept',[DepartmentController::class,'list_department']);
Route::get('/deptsub/{id}',[DepartmentController::class,'list_department_subjects']);



Route::post('/sub',[SubjectController::class,'create_subject']);
Route::put('/updatesub/{id}',[SubjectController::class,'update_subject']);
Route::delete('/delsub/{id}',[SubjectController::class,'delete_subject']);
Route::get('/listsub',[SubjectController::class,'list_subject']);


Route::post('/mark',[MarkController::class,'enter_marks']);
Route::put('/mark/{id}',[MarkController::class,'update_marks']);

