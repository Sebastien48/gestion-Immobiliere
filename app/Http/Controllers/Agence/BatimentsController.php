<?php

namespace App\Http\Controllers\Agence;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Batiments; 
use Illuminate\Support\Str;
use App\Models\Agence;
use App\Models\User;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Auth;
// Assurez-vous d'importer le modèle Batiment si nécessaire

class BatimentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user(); // Utilisateur actuellement connecté

        // Vérification que l'utilisateur est connecté
        if (!$user) {
            return redirect()->route('login')->with('error', 'Veuillez vous connecter');
        }

        // Récupérer l'agence de l'utilisateur
        $agence = $user->agence;

        // Pagination filtrée par agence
        $batiments = Batiments::where('code_agence', $agence ? $agence->numero : null)->paginate(10);

        //commeent implémanter la recherche 

        //récuperer le numéro de l'agence à mettre par defaut dans  le placeholder de l'agence dans le formulaire de btiments
        $numeroAgence = $agence ? $agence->numero : '';

        return view('batiments.index', compact('batiments', 'agence', 'numeroAgence'));
    }

    /**
     * Show the form for creating a new resource.
     */
   

    /**
     * Store a newly created resource in storage.
     */
    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
    {
        // Validation - code_agence est maintenant requis
        $validatedData = $request->validate([
            'nom'                   => 'required|string|max:255',
            'proprietaire'          => 'required|string|max:255',
            'adresse'               => 'required|string|max:255',
            'nombre_Appartements'   => 'required|integer|min:1',
            'status'                => 'nullable|string|max:50',
            'description'           => 'nullable|string|max:1000',
            'code_agence'           => 'required|string|exists:agences,numero',
        ], [
            'code_agence.required'  => 'Le numéro de l\'agence est obligatoire.',
            'code_agence.exists'    => 'Le code d\'agence transmis n\'existe pas.',
        ]);

        // Génère un code alphanumérique court (5 caractères)
        $code_batiment = strtoupper(substr(bin2hex(random_bytes(3)), 0, 5));

        try {
            $batiment = Batiments::create([
                'code_batiment'         => $code_batiment,
                'nom'                   => $validatedData['nom'],
                'proprietaire'          => $validatedData['proprietaire'],
                'adresse'               => $validatedData['adresse'],
                'nombre_Appartements'   => $validatedData['nombre_Appartements'],
                'description'           => $validatedData['description'] ?? '',
                'code_agence'           => $validatedData['code_agence'],
                'user_id'               => Auth::id(),
                'status'                => $validatedData['status'] ?? 'actif',
            ]);
            return redirect()
                ->route('batiments.index')
                ->with([
                    'success'     => 'Bâtiment créé avec succès.',
                    'code_agence' => $batiment->code_agence
                ]);
        } catch (\Exception $e) {
            Log::error('Erreur lors de la création du bâtiment : ' . $e->getMessage());
            return back()->withInput()->withErrors([
                'error' => 'Erreur lors de la création du bâtiment : ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $code_batiment)

    {
        //affciher les détails du bâtiment
        $batiment = Batiments::where('code_batiment', $code_batiment)->first();

        if (!$batiment) {
            return redirect()->route('batiments.index')->with('error', 'Bâtiment non trouvé.');
        }

        return view('batiments.show', compact('batiment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
       

    }

    /**
     * Update the specified resource in storage.
     */
   public function update(Request $request, string $code_batiments)
{
    // 1. Trouver le bâtiment à modifier
    $batiment = Batiments::where('code_batiment', $code_batiments)->first();
    if (!$batiment) {
        return response()->json(['error' => 'Bâtiment non trouvé'], 404);
        // Ou => return redirect()->route('batiments.index')->with('error', 'Bâtiment non trouvé.');
    }

    // 2. Valider les données
    $validatedData = $request->validate([
        'nom'                   => 'required|string|max:255',
        'proprietaire'          => 'required|string|max:255',
        'adresse'               => 'required|string|max:255',
        'nombre_Appartements'   => 'required|integer|min:1',
        'status'                => 'nullable|string|max:50',
        'description'           => 'nullable|string|max:1000',
        'code_agence'           => 'required|string|exists:agences,numero',
    ]);

    // 3. Mettre à jour
    $batiment->update($validatedData);

    // 4. Retourner une réponse
    return redirect()
        ->route('batiments.index')
        ->with('success', 'Bâtiment modifié avec succès.');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
