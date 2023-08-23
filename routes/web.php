<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LeaveCategoryController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\LeaveRequestController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Middlewares\RoleMiddleware;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {
    // Leave Application Routes
    Route::get('/leave/request', [LeaveController::class, 'create'])->name('leave.create');
    Route::post('/leave', [LeaveController::class, 'store'])->name('leave.store');
    Route::resource('leave-categories', LeaveCategoryController::class);
    Route::get('leave-list', [LeaveController::class, 'index'])->name('leave-requests.index');

    // Manager Routes
    Route::middleware(['auth', RoleMiddleware::class . ':manager'])->group(function () {
        Route::get('/leave/requests', [LeaveController::class, 'index'])->name('leave.requests');
        Route::post('/leave/approve/{id}', [LeaveController::class, 'approve'])->name('leave.approve');
        Route::post('/leave/reject/{id}', [LeaveController::class, 'reject'])->name('leave.reject');
//        Route::resource('leave-categories', LeaveCategoryController::class);
    });
});
