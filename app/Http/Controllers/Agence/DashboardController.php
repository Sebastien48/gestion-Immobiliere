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
      /*
        $appartementStats = $agence ? $this->getAppartementStats($agence) : [
            'total_libres' => 0,
            'total_occupes' => 0
        ];*/
        $appartementsList = $agence ? $this->getAppartementsParStatut($agence) : collect([]);
        $appartementsLibres = $appartementsList->where('statut', 'libre')->count();
$appartementsOccupes = $appartementsList->where('statut', 'occupé')->count();
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
}
