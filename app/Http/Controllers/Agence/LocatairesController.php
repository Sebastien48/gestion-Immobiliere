<?php

namespace App\Http\Controllers\Agence;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Locataires;
use Illuminate\Support\Facades\Log;
use App\Models\Batiments;
use Illuminate\Support\Facades\Auth;
use App\Models\Appartements;

class LocatairesController extends Controller
{
    /**
     * Affiche la liste des locataires et bâtiments liés à l'utilisateur connecté.
     */
    public function index()
    {
        $user = Auth::user();

        //l'utilisateur dans l'agence 
        $agenceCode = $user->numero;

        // Lister les locataires appartenant à l'agence de l'utilisateur
        $locataires = Locataires::where('code_agence', $agenceCode)->get();

        // Les bâtiments appartenant à la même agence
        $batiments = Batiments::where('code_agence', $agenceCode)->get();
        $locataire= Locataires::all();

        return view('locataires.index', compact('locataires', 'batiments', 'user','locataire'));
    }

    /**
     * Enregistre un nouveau locataire lié à l'utilisateur connecté.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'last_name'       => 'required|string|max:255',
            'first_name'      => 'required|string|max:255',
            'email'           => 'required|string|email|max:255|unique:locataires,email',
            'address'         => 'required|string|max:255',
            'phone'           => 'required|string|max:15',
            'nationality'     => 'required|string|max:100',
            'birth_date'      => 'required|date',
            'profession'      => 'required|string|max:255',
            'identity_number' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user = Auth::user();

        $code_locataire = strtoupper(substr(bin2hex(random_bytes(3)), 0, 6));

        $photo_identite_path = null;
        if ($request->hasFile('identity_number')) {
            $photo_identite_path = $request->file('identity_number')->store('pieces_identite', 'public');
        }

        try {
            $locataire = Locataires::create([
                'code_locataires'  => $code_locataire,
                'nom'              => $validatedData['last_name'],
                'prenom'           => $validatedData['first_name'],
                'adresse'          => $validatedData['address'],
                'date_naissance'   => $validatedData['birth_date'],
                'profession'       => $validatedData['profession'],
                'photo_identite'   => $photo_identite_path,
                'email'            => $validatedData['email'],
                'nationalité'      => $validatedData['nationality'],
                'telephone'        => $validatedData['phone'],
                    'code_agence' => $user->numero,

            ]);

            return redirect()
                ->route('locataires.index')
                ->with([
                    'success' => 'Locataire créé avec succès.',
                    'code_locataire' => $locataire->code_locataires,
                ]);
        } catch (\Exception $e) {
            Log::error('Erreur lors de la création du locataire : ' . $e->getMessage());
            return back()
                ->withInput()
                ->withErrors([
                    'error' => 'Erreur lors de la création du locataire : ' . $e->getMessage()
                ]);
        }
    }
    //afficher les informations du locataires 
    public function show($code_locataire)
{
    $user = Auth::user();
    $agence = $user->agence;

    // Vérification que le locataire appartient bien à l'agence de l'utilisateur
    $locataire = Locataires::where('code_locataires', $code_locataire)
        ->where('code_agence', $agence->numero)
        ->firstOrFail();

    // On pourra ajouter la récupération des documents, paiements, logement, etc. si besoin

    return view('locataires.show', compact('locataire'));
}

}