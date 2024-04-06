<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RegistrarController;
use App\Http\Controllers\ProfessorController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\CollegeController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ScheduleController;
use App\Models\User;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('registrar')->group( function (){
    Route::post('/insert', [RegistrarController::class, 'insert']);
    Route::post('/update', [RegistrarController::class, 'update']);
    Route::post('/delete', [RegistrarController::class, 'delete']);
});

Route::prefix('professor')->group( function (){
    Route::post('/insert', [ProfessorController::class, 'insert']);
    Route::post('/update', [ProfessorController::class, 'update']);
    Route::post('/delete', [ProfessorController::class, 'delete']);
});

Route::prefix('student')->group( function (){
    Route::post('/insert', [StudentController::class, 'insert']);
    Route::post('/update', [StudentController::class, 'update']);
    Route::post('/delete', [StudentController::class, 'delete']);
});

Route::prefix('subject')->group( function (){
    Route::post('/insert', [SubjectController::class, 'insert']);
    Route::post('/update', [SubjectController::class, 'update']);
    Route::post('/delete', [SubjectController::class, 'delete']);
});

Route::prefix('college')->group( function (){
    Route::post('/insert', [CollegeController::class, 'insert']);
    Route::post('/update', [CollegeController::class, 'update']);
    Route::post('/delete', [CollegeController::class, 'delete']);
});

Route::prefix('department')->group( function (){
    Route::post('/insert', [DepartmentController::class, 'insert']);
    Route::post('/update', [DepartmentController::class, 'update']);
    Route::post('/delete', [DepartmentController::class, 'delete']);
});

Route::prefix('schedule')->group( function (){
    Route::post('/insert', [ScheduleController::class, 'insert']);
    Route::post('/update', [ScheduleController::class, 'update']);
    Route::post('/delete', [ScheduleController::class, 'delete']);
});
