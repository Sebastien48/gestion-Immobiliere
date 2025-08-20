<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Batiments;
use App\Models\Agence;
use App\Models\Appartements;
use App\Models\Locataires;

class GlobalSearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('q');
        $results = [];

        if ($query) {
            // Recherche dans la table utilisateurs (User)
            $utilisateurs = User::where('nom', 'LIKE', "%{$query}%")
                ->orWhere('prenom', 'LIKE', "%{$query}%")
                ->orWhere('email', 'LIKE', "%{$query}%")
                ->get();

            // Recherche dans les locataires (Locataires)
            $locataires = Locataires::where('nom', 'LIKE', "%{$query}%")
                ->orWhere('prenom', 'LIKE', "%{$query}%")
                ->orWhere('code_locataires', 'LIKE', "%{$query}%")
                ->get();

            // Recherche dans les bâtiments
            $batiments = Batiments::where('nom', 'LIKE', "%{$query}%")
                ->orWhere('code_batiment', 'LIKE', "%{$query}%")
                ->get();

            // Recherche dans les appartements
            $appartements = Appartements::where('code_appartement', 'LIKE', "%{$query}%")
                ->orWhere('loyer_mensuel', 'LIKE', "%{$query}%")
                ->get();

            $results['utilisateurs'] = $utilisateurs;
            $results['locataires'] = $locataires;
            $results['batiments'] = $batiments;
            $results['appartements'] = $appartements;
        }

        // Si AJAX → JSON
        if ($request->ajax()) {
            return response()->json($results);
        }

        // Sinon → Vue classique
        return view('search.result', [
            'query' => $query,
            'results' => $results
        ]);
    }
}