<?php



use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;

use App\Http\Controllers\AdminController;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\AgenceController;


Route::get('/', function () {
    return view('index');
});

// Routes for client-side registration
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Routes for login and logout
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Admin routes
/*
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/users/create', [UserController::class, 'create'])->name('admin.users.create');
    Route::post('/users', [UserController::class, 'store'])->name('admin.users.store');
    Route::get('/agences/create', [AgenceController::class, 'create'])->name('admin.agences.create');
    Route::post('/agences', [AgenceController::class, 'store'])->name('admin.agences.store');
 
});
*/

Route::prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
   Route::get('/agences/list', [AgenceController::class, 'list'])->name('admin.agences.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('admin.users.create');
    Route::post('/users/store', [UserController::class, 'store'])->name('admin.users.store');
    Route::get('/agences/create', [AgenceController::class, 'create'])->name('admin.agences.create');
    Route::post('/agences', [AgenceController::class, 'store'])->name('admin.agences.store');
    
});
