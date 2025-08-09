<?php

namespace App\Http\Controllers\Agence;

use App\Http\Controllers\Controller;
use App\Models\Agence;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Récupérer l'utilisateur connecté (pas le premier de la table)
        $user = Auth::user(); // Utilisateur actuellement connecté
        
        // Vérification que l'utilisateur est connecté
        if (!$user) {
            return redirect()->route('login')->with('error', 'Veuillez vous connecter');
        }
        
        // 2. Récupérer l'agence liée à cet utilisateur via la relation
        $agence = $user->agence;
        
        $nomAgence = $agence ? $agence->nomAgence : 'Agence non trouvée';
        $logo1 = $agence ? $agence->logo : null;
        
        // 3. Concaténer les initiales
        $initiales = '';
        if ($user->nom && $user->prenom) {
            $premiereLettreNom = substr($user->nom, 0, 1);
            $premiereLettrePrenom = substr($user->prenom, 0, 1);
            $initiales = strtoupper($premiereLettreNom . $premiereLettrePrenom);
        }
        
        return view('dashboard', compact('user', 'agence', 'nomAgence', 'initiales', 'logo1'));
    }
   
    
}