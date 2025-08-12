<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IndexController extends Controller
{
    //
    public function index()
    {
        // Logique pour la page d'accueil
        return view('index'); // Assurez-vous que 'welcome' est le nom de votre vue d'accueil
    }
}
