<?php

use App\Http\Controllers\CourseController;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');

Route::group(['auth:sanctum', 'verified'], function () {
    Route::get('/course/{id}', [CourseController::class, 'show'])->name('courses.show');
    Route::post('/toggleProgress', [CourseController::class, 'toggleProgress'])->name('courses.toggle');
    Route::post('/courses', 'App\Http\Controllers\CourseController@store');


    Route::get('/dashboard', function () {
        return Inertia\Inertia::render('Dashboard');
    })->name('dashboard');
});
