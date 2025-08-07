<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use  App\Models\Agence;
use App\Models\User;
class AdminController extends Controller
{
    //
    public function index()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Veuillez vous connecter');
        }
        // afficher les initialies du côté de l'admin 
        $initiales = '';
        if ($user->nom && $user->prenom) {
            $premiereLettreNom = substr($user->nom, 0, 1);
            $premiereLettrePrenom = substr($user->prenom, 0, 1);
            $initiales = strtoupper($premiereLettreNom . $premiereLettrePrenom);
        }
        return view('admin.index',compact('user','initiales')); // Assuming you have an index view for the admin dashboard
    }
   
}
