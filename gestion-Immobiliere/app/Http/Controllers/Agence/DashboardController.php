<?php

namespace App\Http\Controllers\Agence;

use App\Http\Controllers\Controller;
use App\Models\Agence;
use App\Models\Batiments;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Appartements;  
use App\Models\Paiements;
use App\Models\Quittances;

class DashboardController extends Controller
{// definition des différents
    public function index()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Veuillez vous connecter');
        }
        $agence = $user->agence;

        // On crée un objet de statistiques par agence liée à l'utilisateur (plus maintenable et scalable)
        $nomAgence = $agence ? $agence->nomAgence : 'Agence non trouvée';
        $logo1 = $agence ? $agence->logo : null;
        $initiales = $this->getInitiales($user);
        $buildingsCount = $agence ? $this->getBuildingsCount($agence) : 0;

        //calculer le paiement  par mois et le total de paiments

        $paiementStats = $agence ? $this->getpaimentCount($agence) : ['total' => 0, 'par_mois' => []];
        
      
        $appartementsList = $agence ? $this->getAppartementsParStatut($agence) : collect([]);
        $appartementsLibres = $appartementsList->where('statut', 'libre')->count();
        $appartementsOccupes = $appartementsList->where('statut', 'occupe')->count();
        return view('dashboard', [
            'user' => $user,
            'agence' => $agence,
            'nomAgence' => $nomAgence,
            'initiales' => $initiales,
            'logo1' => $logo1,
            'buildingsCount' => $buildingsCount,
            
             'appartementsList' => $appartementsList,
    'appartementsLibres' => $appartementsLibres,
    'appartementsOccupes' => $appartementsOccupes,
            'paiementStats' => $paiementStats,
        ]);
    }

    // Méthode privée pour les initiales
    private function getInitiales($user)
    {
        return strtoupper(
            substr($user->nom ?? '', 0, 1).
            substr($user->prenom ?? '', 0, 1)
        );
    }

    // Méthode privée pour compter les bâtiments
    private function getBuildingsCount($agence)
    {
        return Batiments::where('code_agence', $agence->numero)->count();
    }

  
    // Méthode privée pour compter les appartements libres et occupés
    private function getAppartementsParStatut($agence)
     
    {
         return DB::table('agences as a')
            ->join('batiments as b', 'b.code_agence', '=', 'a.numero')
            ->join('appartements as ap', 'ap.code_batiment', '=', 'b.code_batiment')
            ->where('a.numero', $agence->numero)
            ->select(
                'ap.code_appartement',
                'ap.superficie',
                'ap.loyer_mensuel',
                'ap.statut',
                'b.nom as nom_batiment',
                'b.code_batiment'
            )
            ->orderBy('ap.statut')
            ->get();
    }

     public function getpaimentCount($agence)
    {
        // Sécurité : s'assurer qu'il y a bien une agence
        if(!$agence) {
            return [
                'total'   => 0,
                'par_mois'=> [],
            ];
        }

        // Paiements groupés par mois (année-mois) et total
        // On suppose que champ 'montant' et 'mois' dans la table 'paiements'
      $paiements = DB::table('paiements')
    ->selectRaw("mois AS periode, SUM(montant) AS montant_par_mois")
    ->where('code_agence', $agence->numero)
    ->groupBy('mois')
    ->orderByRaw('MIN(created_at) DESC') // doit avoir une colonne de tri réaliste 
    ->get();

        // Tableau période (YYYY-MM) => montant
        $parMois = $paiements->pluck('montant_par_mois', 'periode')->toArray();

        // Total général pour cette agence
        $total = array_sum($parMois);

        return [
            'total'    => $total,
            'par_mois' => $parMois,
        ];
    }
}
