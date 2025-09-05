<?php

namespace App\Http\Controllers\Agence;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Agence;
use App\Models\Batiments;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Appartements;
use App\Models\Paiements;
use App\Models\Quittances;
use Barryvdh\DomPDF\Facade\Pdf;

class QuittancesController extends Controller
{
    /**
     * Affiche la liste des quittances et le détail d'une quittance si l'ID est présent,
     * le tout filtré par l'agence de l'utilisateur connecté.
     * @param  string|null  $id_quittance
     */
    public function index($id_quittance = null)
    {
        // Récupérer le code agence via l'utilisateur connecté
        $user = Auth::user();
        $codeAgence = $user->numero; // adapter selon le champ de la relation User-Agence

        // Lister toutes les quittances liées à cette agence (via paiement -> code_agence)
        $quittances = Quittances::whereHas('paiement', function($q) use ($codeAgence) {
                $q->where('code_agence', $codeAgence);
            })
            ->with(['paiement.batiment', 'paiement.locataire'])
            ->get();

        $quittance = null;
        if ($id_quittance) {
            $quittance = Quittances::where('id_quittance', $id_quittance)
                ->whereHas('paiement', function($q) use ($codeAgence) {
                    $q->where('code_agence', $codeAgence);
                })
                ->with(['paiement.batiment', 'paiement.locataire'])
                ->first();
        }

        return view('quittances.index', compact('quittances', 'quittance'));
    }

    /**
     * Télécharger la quittance en PDF (vérifie aussi l'agence !)
     */
    public function download($id_quittance)
    {
        $user = Auth::user();
        $codeAgence = $user->numero;

        $quittance = Quittances::where('id_quittance', $id_quittance)
            ->whereHas('paiement', function($q) use ($codeAgence) {
                $q->where('code_agence', $codeAgence);
            })
            ->with(['paiement.batiment', 'paiement.locataire'])
            ->firstOrFail();

        $pdf = Pdf::loadView('quittances.pdf', compact('quittance', 'codeAgence'));
        return $pdf->download("quittance-{$quittance->id_quittance}.pdf");
    }

    /**
     * Génération rapide d'une quittance pour le dernier paiement payé de l'agence connectée
     */
    public function creerQuittanceSimple(Request $request)
    {
        $user = Auth::user();
        $codeAgence = $user->numero;

        // Dernier paiement payé pour cette agence
        $paiement = Paiements::where('statut', 'payer')
            ->where('code_agence', $codeAgence)
            ->latest()
            ->first();

        if (!$paiement) {
            return back()->with('error', 'Aucun paiement validé trouvé pour cette agence.');
        }

        // Vérifier si déjà quittance pour ce paiement
        $existe = Quittances::where('code_paiement', $paiement->paiement_id)->first();
        if ($existe) {
            return redirect()->route('quittances.detail', $existe->id_quittance)
                ->with('success', 'Une quittance existe déjà pour ce paiement.');
        }

        $idQuittance = 'QTC-' . now()->format('Ymd') . '-PAI' . $paiement->paiement_id;

        $quittance = Quittances::create([
            'id_quittance'    => $idQuittance,
            'code_paiement'   => $paiement->paiement_id,
            'date_creation'   => now(),
        ]);

        return redirect()->route('quittances.detail', $quittance->id_quittance)
            ->with('success', 'Quittance générée avec succès pour cette agence.');
    }
}