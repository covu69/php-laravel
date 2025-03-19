<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClientController;
use App\Http\Middleware\CheckAuthenticated;
use App\Http\Middleware\CheckEnrollment;
use Illuminate\Support\Facades\Route;

Route::get('/', [ClientController::class, 'index'])->name('user.course.index');


Route::get('/admin/login', [AdminController::class, 'adminLogin'])->name('admin.login');
Route::post('/admin/check/login', [AdminController::class, 'checkLogin'])->name('check.admin.login');
Route::post('/admin/logout', [AdminController::class, 'adminLogout'])->name('admin.logout');
Route::prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    //user
    Route::get('/user/list', [AdminController::class, 'indexUser'])->name('admin.user.list');
    Route::get('/user/add', [AdminController::class, 'addUser'])->name('admin.user.add');
    Route::post('/user/save/add', [AdminController::class, 'savaUser'])->name('admin.user.save');
    Route::get('/user/edit/{id}', [AdminController::class, 'editUser'])->name('admin.user.edit');
    Route::put('/user/update/{id}', [AdminController::class, 'updateUser'])->name('admin.user.update');
    Route::delete('/user/deleted/{id}', [AdminController::class, 'destroyUser'])->name('admin.user.destroy');

    // course
    Route::get('/course/list', [AdminController::class, 'indexCourse'])->name('admin.course.list');
    Route::get('/course/add', [AdminController::class, 'createCoures'])->name('admin.course.add');
    Route::post('/course/save/add', [AdminController::class, 'storeCoures'])->name('admin.course.save');
    Route::get('/course/edit/{id}', [AdminController::class, 'editCourse'])->name('admin.course.edit');
    Route::put('/course/update/{id}', [AdminController::class, 'updateCourse'])->name('admin.course.update');
    Route::delete('/course/deleted/{id}', [AdminController::class, 'destroyCourse'])->name('admin.course.destroy');
});


Route::prefix('courses')->middleware(CheckAuthenticated::class)->group(function () {

    Route::get('/{id}', [ClientController::class, 'show'])->name('user.course.show');
    Route::post('/{id}/checkout', [ClientController::class, 'checkout'])->name('user.course.checkout');

    // Chỉ những ai đã đăng ký mới có thể xem bài giảng
    Route::get('/{id}/lessons', [ClientController::class, 'lessons'])
        ->middleware(CheckEnrollment::class)
        ->name('user.course.lessons');
});

Route::get('/login', [ClientController::class, 'loginClient'])->name('client.login');
Route::post('/check/login', [ClientController::class, 'checkLogin'])->name('client.check.login');
Route::post('/client/logout', [ClientController::class, 'clientLogout'])->name('client.logout');