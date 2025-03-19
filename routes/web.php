<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BoardsController;
use App\Http\Controllers\TasksController;
<<<<<<< HEAD
use App\Http\Controllers\ContactController; // Tambahkan ini jika Anda menggunakan ContactController
=======
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ContactController;
>>>>>>> aa77acd26f26d2e6d970a3ad5d25f8beb4371ad5

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

Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Route untuk mengirim data kontak (contact.submit)
Route::post('/contact/submit', [ContactController::class, 'submit'])->name('contact.submit'); // Gunakan ContactController dan method submit

Route::group(['middleware' => 'isAdmin', 'prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard.index');
    Route::resource('permissions', \App\Http\Controllers\Admin\PermissionController::class);
    Route::resource('roles', \App\Http\Controllers\Admin\RoleController::class);
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
    Route::get('profile', [\App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::put('profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
});

Route::middleware(['auth'])->group(function () {
    Route::resource('boards', BoardsController::class);
    Route::get('/tasks/{board}', [TasksController::class, 'index'])->name('tasks.index');
    Route::post('/tasks/{task}/update-status', [TasksController::class, 'updateStatus']);
});