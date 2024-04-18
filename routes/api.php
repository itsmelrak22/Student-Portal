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
use App\Http\Controllers\StudentScheduleController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\CourseController;
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

Route::get('/getRegistrarData', [RegistrarController::class, 'index']);
Route::get('/getProfessorData', [ProfessorController::class, 'index']);
Route::get('/students', [StudentController::class, 'index']);
Route::get('/subjects', [SubjectController::class, 'index']);
Route::get('/colleges', [CollegeController::class, 'index']);
Route::get('/departments', [DepartmentController::class, 'index']);
Route::get('/events', [EventController::class, 'index']);

Route::prefix('schedules')->group( function (){
    Route::get('/', [ScheduleController::class, 'index']);
    Route::get('/{id}/students', [ScheduleController::class, 'schedule_students']);
});

Route::prefix('course')->group( function (){
    Route::get('/', [CourseController::class, 'index']);
    Route::post('/store', [CourseController::class, 'store']);
    Route::post('/update/{course}', [CourseController::class, 'update']);
    Route::post('/delete/{course}', [CourseController::class, 'delete']);
});


Route::prefix('users')->group( function (){
    Route::get('/{role}', [UserController::class, 'index']);
    Route::get('/account', [UserController::class, 'account']);
    Route::post('/account/store', [UserController::class, 'account_store']);
    Route::post('/account/update/{user}', [UserController::class, 'account_update']);
    Route::post('/account/delete/{user}', [UserController::class, 'account_delete']);

    Route::get('/professor/{id}', [UserController::class, 'professor_schedule']);
    Route::get('/students/{id}/schedules', [UserController::class, 'student_schedule']);
    // Route::get('/adviser/{id}', [UserController::class, 'advisee']);

});

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

Route::prefix('student_schedule')->group( function (){
    Route::post('/insert', [StudentScheduleController::class, 'insert']);
});

Route::prefix('events')->group( function (){
    Route::post('/insert', [EventController::class, 'insert']);
    Route::post('/update', [EventController::class, 'update']);
    Route::post('/delete', [EventController::class, 'delete']);
});
