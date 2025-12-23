<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ParentsController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ReportController::class, 'index'])->name('dashboard');
Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
Route::get('/reports/fetch', [ReportController::class, 'show'])->name('reports.data');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware(['userMiddleware:admin'])->group(function () {
        Route::resource('students', StudentController::class);
        Route::resource('parents', ParentsController::class);
    });

    Route::middleware(['userMiddleware:guru,admin'])->group(function () {
        Route::resource('teachers', TeacherController::class);
        Route::resource('classrooms', ClassroomController::class);
    });
});

require __DIR__.'/auth.php';
