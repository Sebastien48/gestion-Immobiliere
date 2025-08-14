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
use App\Http\Controllers\Agence\BatimentsController;


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
Route::prefix('agence-immbolière')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('home');
    Route::get('/batiments',[BatimentsController::class, 'index'])->name('batiments.index');
    Route::post('/batiments/store', [BatimentsController::class, 'store'])->name('batiments.post');
    
   // Route::get('/batiments/create', [BatimentsController::class, 'create'])->name('batiments.create');
    Route::get('/batiments/{code_batiment}', [BatimentsController::class, 'show'])->name('batiments.show');
    Route::put('/batiments/update/{code_batiment}', [BatimentsController::class, 'update'])->name('batiments.update');
    /*
    Route::get('/batiments/{id}/edit', [BatimentsController::class, 'edit'])->name('batiments.edit');
    Route::put('/batiments/{id}', [BatimentsController::class, 'update'])->name('batiments.update');
    Route::delete('/batiments/{id}', [BatimentsController::class, 'destroy'])->name('batiments.destroy');
    
 
    Route::get('/batiments/{id}', function ($id) {
    return view('batiments.show', ['id' => $id]);
})->name('batiments.show');

Route::get('/appartements', function () {
    return view('appartements.index');
})->name('appartements.index');
Route::get('/appartements/{id}', function ($id) {
    $apartment = (object)[
        'id' => $id,
        'number' => 'B1-05',
        'building' => (object)['name' => 'Résidence Yasmina'],
        'surface' => '45',
        'monthly_rent' => '750000',
        'status' => 'libre'
    ];
    return view('appartements.show', ['apartment' => $apartment]);
})->name('appartements.show');
Route::get('/batiments/{buildingId}/appartements', function ($buildingId) {
    return view('appartements.index', ['buildingId' => $buildingId]);
})->name('batiments.appartements');

// Locataires
Route::get('/locataires', function () {
    return view('locataires.index');
})->name('locataires.index');
Route::get('/locataires/{id}', function ($id) {
    return view('locataires.show', ['id' => $id]);
})->name('locataires.show');
*/
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
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
    Route::get('/agences/{id}/edit', [AgenceController::class, 'edit'])->name('admin.agences.edit');
    Route::get('/stats', [AgenceController::class, 'stats'])->name('admin.stats');
});

