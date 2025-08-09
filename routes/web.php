<?php



use App\Http\Controllers\Agence\DashboardController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\resetController;
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
Route::get('/logout', [LoginController::class, 'logout'])->name('logout.get');
Route::get('/forget-password', [PasswordController::class, 'index'])->name('forget.password');
Route::post('/forget-password', [PasswordController::class, 'check'])->name('forget.password.post');
//Route::get('/password/reset',[resetController::class, 'showLinkRequestForm'])->name('reset.password');

 
// Route pour afficher le formulaire (votre méthode index originale)
Route::get('/reset-password', [ResetController::class, 'index'])
    ->middleware('guest')
    ->name('reset.password');

// Route pour afficher le formulaire avec token
Route::get('/reset-password/{token}', [ResetController::class, 'showResetForm'])
    ->middleware('guest')
    ->name('password.reset');

// Route pour traiter la réinitialisation
Route::post('/reset-password', [ResetController::class, 'reset'])
    ->middleware('guest')
    ->name('password.update');

// Route de connexion (si elle n'existe pas déjà)
Route::get('/login', function () {
    return view('auth.login');
})->middleware('guest')->name('login');
Route::prefix('/agence-immbolière')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('home');
});


// Admin routes



Route::prefix('admin')->middleware(['auth','admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
   Route::get('/agences/list', [AgenceController::class, 'list'])->name('admin.agences.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('admin.users.create');
    Route::post('/users/store', [UserController::class, 'store'])->name('admin.users.store');
    Route::get('/agences/create', [AgenceController::class, 'create'])->name('admin.agences.create');
    Route::post('/agences', [AgenceController::class, 'store'])->name('admin.agences.store');
    Route::get('/users/validated', [UserController::class, 'index'])->name('admin.users.index');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
    Route::get('/agences/{id}/edit', [AgenceController::class, 'edit'])->name('admin.agences.edit');
    Route::get('/stats', [AgenceController::class, 'stats'])->name('admin.stats');

});

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');