<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SpaController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\RegistrarController;
use App\Http\Controllers\ProfessorController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\CollegeController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ScheduleController;
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

require __DIR__.'/auth.php';


Route::middleware(['auth'])->group(function() {
    /*  
    |
    | Some Routes needed to be before the route with "{any?}" parameter.
    | So that it will be found first, after entering the route.
    | if route is found before the "{any?}" it will be initiate and the interpreter wont continue to next line of code.
    */

    Route::get('/auth-user', [AuthenticatedSessionController::class, 'show']);

    // Route::get('/getRegistrarData', [RegistrarController::class, 'index']);
    // Route::get('/getProfessorData', [ProfessorController::class, 'index']);
    // Route::get('/getStudentData', [StudentController::class, 'index']);
    // Route::get('/getSubjectData', [SubjectController::class, 'index']);
    // Route::get('colleges', [CollegeController::class, 'index']);
    // Route::get('/getDepartmentData', [DepartmentController::class, 'index']);
    // Route::get('/getScheduleData', [ScheduleController::class, 'index']);
    
    Route::get('/{any?}', [SpaController::class, 'index'])->where('any', '.*');
});
