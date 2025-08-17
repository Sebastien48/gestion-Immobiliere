<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\ErreurController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\ResetController;
use App\Http\Controllers\Agence\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AgenceController;
use App\Http\Controllers\Agence\AppartementsController;
use App\Http\Controllers\Agence\BatimentsController;
use App\Http\Controllers\Agence\LocatairesController;
use App\Http\Controllers\Agence\QuittancesController;

// Accueil
Route::get('/', [IndexController::class, 'index'])->name('index');

// Fallback pour 404 personnalisé
//Route::fallback([ErreurController::class, 'show404'])->name('error.404');

// Authentification & inscription
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.post');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout.get');

// Mot de passe oublié & réinitialisation
Route::get('/forget-password', [PasswordController::class, 'index'])->name('forget.password');
Route::post('/forget-password', [PasswordController::class, 'check'])->name('forget.password.post');

Route::get('/reset-password', [ResetController::class, 'index'])->middleware('guest')->name('reset.password');
Route::get('/reset-password/{token}', [ResetController::class, 'showResetForm'])->middleware('guest')->name('password.reset');
Route::post('/reset-password', [ResetController::class, 'reset'])->middleware('guest')->name('password.update');

// Utilisateur agence - Dashboard (auth obligatoire)
Route::prefix('agence-immobiliere')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('home');
    Route::get('/batiments',[BatimentsController::class, 'index'])->name('batiments.index');
    Route::post('/batiments/store', [BatimentsController::class, 'store'])->name('batiments.post');
    Route::get('batiments/live-search', [BatimentsController::class, 'liveSearch'])->name('batiments.liveSearch');
   // Route::get('/batiments/create', [BatimentsController::class, 'create'])->name('batiments.create');
    Route::get('/batiments/{code_batiment}', [BatimentsController::class, 'show'])->name('batiments.show');
    Route::put('/batiments/update/{code_batiment}', [BatimentsController::class, 'update'])->name('batiments.update');
   Route::delete('batiments/{code_batiment}', [BatimentsController::class, 'destroy'])->name('batiments.destroy');
    Route::get('batiments/live-search', [BatimentsController::class, 'liveSearch'])->name('batiments.liveSearch');

// route appartement 
Route::get('/appartements', [AppartementsController::class,'index'])->name('appartements.index');
Route::post('/appartement/store',[AppartementsController::class,'store'])->name('appartements.store');
Route::get('/appartements/{code_appartement}',[AppartementsController::class,'show']) ->name('appartements.show');

 // route pour locataires

 Route::get('/locataires',action:[LocatairesController::class,'index'])->name('locataires.index');
    Route::post('/locataires',action:[LocatairesController::class,'store'])->name('locataires.store');


// définis la route pours les quittances
Route::get('/quittances',action:[QuittancesController::class,'index'])->name('quittances.index');


});

// Admin routes (auth & admin middlewares)
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/agences/list', [AgenceController::class, 'list'])->name('admin.agences.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('admin.users.create');
    Route::post('/users/store', [UserController::class, 'store'])->name('admin.users.store');
    Route::get('/agences/create', [AgenceController::class, 'create'])->name('admin.agences.create');
    Route::post('/agences', [AgenceController::class, 'store'])->name('admin.agences.store');
    Route::get('/users/validated', [UserController::class, 'index'])->name('admin.users.index');
    Route::get('/users', [UserController::class, 'index'])->name('admin.users.list');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('admin.users.update');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('admin.users.destroy');
    Route::get('/agences/{id}/edit', [AgenceController::class, 'edit'])->name('admin.agences.edit');
    Route::put('/agences/{id}', [AgenceController::class, 'update'])->name('admin.agences.update');
    Route::delete('/agences/{id}', [AgenceController::class, 'destroy'])->name('admin.agences.destroy');
    Route::get('/stats', [AgenceController::class, 'stats'])->name('admin.stats');
});
