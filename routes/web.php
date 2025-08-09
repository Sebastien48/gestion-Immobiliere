<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

// Routes pour les bâtiments
Route::get('/batiments', function () {
    return view('batiments.index');
})->name('batiments.index');

Route::get('/batiments/{id}', function ($id) {
    return view('batiments.show', ['id' => $id]);
})->name('batiments.show');

// Routes pour les appartements
Route::get('/appartements', function () {
    return view('appartements.index');
})->name('appartements.index');

Route::get('/appartements/{id}', function ($id) {
    // Simulation d'un appartement (à remplacer par notre vraie logique)
    $apartment = (object)[
        'id' => $id,
        'number' => 'B1-05',
        'building' => (object)[
            'name' => 'Résidence Yasmina'
        ],
        'surface' => '45',
        'monthly_rent' => '750000',
        'status' => 'libre'
    ];
    
    return view('appartements.show', ['apartment' => $apartment]);
})->name('appartements.show');

// Route optionnelle pour filtrer par bâtiment
Route::get('/batiments/{buildingId}/appartements', function ($buildingId) {
    return view('appartements.index', ['buildingId' => $buildingId]);
})->name('batiments.appartements');


// Routes pour les locataires
Route::get('/locataires', function () {
    return view('locataires.index');
});

Route::get('/locataires/{id}', function ($id) {
    return view('locataires.show', ['id' => $id]);
});