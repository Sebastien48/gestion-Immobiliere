<?php

namespace App\Http\Controllers\Agence;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function index()
{
    return view('dashboard'); // sans dossier, car la vue est à resources/views/dashboard.blade.php
}
}
