<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ErreurController extends Controller
{
    //
    public function show404()
    {
        // Logique pour afficher la page d'erreur 404
        return view('erreur'); // Assurez-vous que 'erreur' est le nom de votre vue d'erreur
    }
}
