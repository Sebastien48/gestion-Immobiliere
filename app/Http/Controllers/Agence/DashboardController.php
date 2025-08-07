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
        
        // 2. Récupérer l'agence liée à cet utilisateur
        // En supposant que l'utilisateur a un champ 'agence_code' ou 'nomAgence'
        $agence = null;
        $nomAgence = 'Agence non trouvée';
        $logo1 = null;
        
        // Option 1: Si l'utilisateur a un champ 'code_agence' qui correspond au 'numero' de l'agence
        if ($user->code_agence) {
            $agence = Agence::where('numero', $user->code_agence)->first();
        }
        
        // Option 2: Si l'utilisateur a un champ 'nomAgence' directement
        if (!$agence && $user->nomAgence) {
            $agence = Agence::where('nomAgence', $user->nomAgence)->first();
        }
        
        // Option 3: Si vous avez une relation définie dans le modèle User
        // $agence = $user->agence; // Si relation définie
        
        // Récupérer les informations de l'agence
        if ($agence) {
            $nomAgence = $agence->nomAgence;
            $logo1 = $agence->logo ?? null;
        }
        
        // 3. Concaténer les initiales
        $initiales = '';
        if ($user->nom && $user->prenom) {
            $premiereLettreNom = substr($user->nom, 0, 1);
            $premiereLettrePrenom = substr($user->prenom, 0, 1);
            $initiales = strtoupper($premiereLettreNom . $premiereLettrePrenom);
        }
        
        // Debug pour voir les valeurs (à supprimer en production)
        // dd([
        //     'user' => $user,
        //     'agence' => $agence,
        //     'nomAgence' => $nomAgence,
        //     'initiales' => $initiales,
        //     'logo1' => $logo1
        // ]);
        
        return view('dashboard', compact('user', 'agence', 'nomAgence', 'initiales', 'logo1'));
    }
   
    
}