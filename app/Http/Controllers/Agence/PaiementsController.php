<?php

namespace App\Http\Controllers\Agence;

use App\Http\Controllers\Controller;
use App\Models\Paiements;
use App\Models\Locations;
use App\Models\Batiments;
use App\Models\Appartements;
use App\Models\Locataires;
use App\Models\Quittance;
use App\Models\Quittances;
use App\Models\User;
use App\Notifications\ActionAgenceNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PaiementsController extends Controller
{
    public function index()
    {
        $agenceCode = Auth::user()->numero;
        $batiments = Batiments::where('code_agence', $agenceCode)->get();
        // Sélection uniquement des locataires avec location(s) chez l'agence courante
        $locataires = Locataires::where('code_agence', $agenceCode)
            ->whereHas('locations')
            ->get();
        $appartements = Appartements::whereIn('code_batiment', $batiments->pluck('code_batiment'))->get();
        $locations = Locations::where('code_agence', $agenceCode)->get();

        $paiements = Paiements::where('code_agence', $agenceCode)
            ->with(['locataire', 'batiment', 'appartement', 'location'])
            ->latest()->paginate(10);

        return view('paiements.index', compact(
            'batiments',
            'locataires',
            'appartements',
            'locations',
            'paiements'
        ));
    }

    public function store(Request $request)
    {
        $agenceCode = Auth::user()->numero;

        // Validation : le champ locataire est OBLIGATOIRE et doit exister (clé primaire correcte)
        $rules = [
            'tenant_value'    => 'required|string|exists:locataires,code_locataires',
            'reference'       => 'nullable|string|max:255|unique:paiements,reference',
            'amount'          => 'required|numeric|min:0.01',
            'month'           => 'required|string|max:50',
            'payment_method'  => 'required|string|in:cash,check,transfer,mobile',
            'statut'    =>  'required|string|in:payer,avance,impayer',
        ];
        $messages = [
            'tenant_value.required' => 'Le locataire est obligatoire.',
            'tenant_value.exists'   => 'Locataire inconnu ou non disponible.',
            'reference.unique'      => 'La référence de paiement existe déjà.',
            'amount.required'       => 'Le montant est requis.',
            'amount.numeric'        => 'Le montant doit être un nombre.',
            'amount.min'            => 'Le montant doit être positif.',
            'month.required'        => 'Le mois à payer est requis.',
            'payment_method.in'     => 'Mode de paiement non accepté.',
            'payment_method.required' => 'Le mode de paiement est requis.',
        ];

        $validated = $request->validate($rules, $messages);

        // Récupération du locataire
        $locataireId = $validated['tenant_value'];
        $locataire = Locataires::where('code_locataires', $locataireId)
            ->where('code_agence', $agenceCode)
            ->first();

        if (!$locataire) {
            return back()->withErrors(['locataire' => "Locataire inexistant ou hors agence."])->withInput();
        }

        // Dernière location active (modifié selon clé étrangère) :
        $location = Locations::where('code_locataire', $locataireId)
            ->where('code_agence', $agenceCode)
            ->latest()
            ->first();

        if (!$location) {
            return back()->withErrors(['location' => "Aucune location active trouvée pour ce locataire."])->withInput();
        }

        $code_paiement = strtoupper(substr(bin2hex(random_bytes(4)), 0, 8)); // Code un peu plus robuste

        try {
            Paiements::create([
                'paiement_id'      => $code_paiement,
                'reference'        => $validated['reference'] ?? null,
                'montant'          => $validated['amount'],
                'mois'             => $validated['month'],
                'mode_paiement'    => $validated['payment_method'],
                'code_agence'      => $agenceCode,
                'code_batiment'    => $location->code_batiment,
                'code_appartement' => $location->code_appartement,
                'code_locataire'   => $locataireId,
                'code_location'    => $location->code_location,
                'statut' =>$validated['statut'],
            ]);
            $this -> payer($request);
            return redirect()->route('paiements.index')
                ->with('success', 'Paiement enregistré avec succès')
                ->with('paiement_id', $code_paiement);
        } catch (\Exception $e) {
            Log::error('Erreur paiement: '.$e->getMessage());
            return back()->withErrors(['unexpected' => "Impossible d'enregistrer le paiement."])
                ->withInput();
        }
    }

public function payer(Request $request)
{
    $currentUser = Auth::user(); // Utilisateur connecté
    $agenceCode = $currentUser->numero;

    // Liste des utilisateurs de l'agence (à notifier)
    $usersToNotify = User::where('numero', $agenceCode)->get();

    foreach ($usersToNotify as $notifiable) {
        $notifiable->notify(
            new ActionAgenceNotification(
                "Nouveau paiement enregistré",
                trim($currentUser->nom . ' ' . $currentUser->prenom)
            )
        );
    }

    return back()->with('success', 'Paiement enregistré et notifications envoyées');

    
}




}