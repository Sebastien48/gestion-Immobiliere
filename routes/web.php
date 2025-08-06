<?php



use App\Http\Controllers\Agence\DashboardController;
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
Route::post('/register', [RegisterController::class, 'register'])->name('register.post');

// Routes for login and logout
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post ');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::prefix('/agence-immbolière')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('home');
});


// Admin routes
/*
Route::prefix('/agence-immbolière')->group(function () {
    Route::get('/dashboard',[DashboardController::class, 'index'])->name('home');
});
//
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

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');