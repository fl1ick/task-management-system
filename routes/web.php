<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BoardsController;
use App\Http\Controllers\TasksController;
use App\Http\Controllers\ContactController;

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

Route::get('/', function () {
    $boards = \App\Models\Boards::all();
    return view('welcome', compact('boards'));
});

Auth::routes();

// Route untuk mengirim data kontak
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');

// Group middleware untuk admin dengan prefix "admin"
Route::group(['middleware' => 'isAdmin', 'prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard.index');
    Route::resource('permissions', \App\Http\Controllers\Admin\PermissionController::class);
    Route::resource('roles', \App\Http\Controllers\Admin\RoleController::class);
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);

    // Profil admin
    Route::get('profile', [\App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::put('profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
});

// Group middleware untuk pengguna yang sudah login
Route::middleware(['auth'])->group(function () {
    Route::resource('boards', BoardsController::class);
    Route::get('/tasks/{board}', [TasksController::class, 'index'])->name('tasks.index');
    Route::post('/tasks/{task}/update-status', [TasksController::class, 'updateStatus']);
});
