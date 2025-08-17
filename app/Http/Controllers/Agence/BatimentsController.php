<?php

namespace App\Http\Controllers\Agence;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Batiment;
use App\Models\Appartement;
use App\Models\Agence;
use App\Models\Appartements;
use App\Models\Batiments;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class BatimentsController extends Controller
{
    // Liste paginée des bâtiments pour l'agence courante
    public function index()
    {
        $user = Auth::user();
        $agence = $user->agence;
        $numeroAgence = $agence ? $agence->numero : '';
        // Bâtiments de l'agence paginés
        $batiments = Batiments::where('code_agence', $numeroAgence)->paginate(10);

        return view('batiments.index', compact('batiments', 'agence', 'numeroAgence'));
    }

    // Affiche les détails d'un bâtiment + la liste des appartements pour ce bâtiment
    public function show($code_batiment)
    {
        $user = Auth::user();
        $agence = $user->agence;
        $numeroAgence = $agence ? $agence->numero : '';
        $batiment = Batiments::where('code_batiment', $code_batiment)->firstOrFail();
        $appartements = Appartements::where('code_batiment', $batiment->code_batiment)->get();

        return view('batiments.show', compact('batiment', 'appartements', 'agence', 'numeroAgence'));
    }

    // Crée un bâtiment pour l'agence
    public function store(Request $request)
    {
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

    // MAJ d'un bâtiment
    public function update(Request $request, string $code_batiment)
    {
        $batiment = Batiments::where('code_batiment', $code_batiment)->first();
        if (!$batiment) {
            return response()->json(['error' => 'Bâtiment non trouvé'], 404);
        }

        $validatedData = $request->validate([
            'nom'                   => 'required|string|max:255',
            'proprietaire'          => 'required|string|max:255',
            'adresse'               => 'required|string|max:255',
            'nombre_Appartements'   => 'required|integer|min:1',
            'status'                => 'nullable|string|max:50',
            'description'           => 'nullable|string|max:1000',
            'code_agence'           => 'required|string|exists:agences,numero',
        ]);

        $batiment->update($validatedData);

        return redirect()
            ->route('batiments.index')
            ->with('success', 'Bâtiment modifié avec succès.');
    }


    // le controller de la recherche de batiments

   public function liveSearch(Request $request)
{
    $query = $request->get('search');
   

    $batiments = Batiments::query()
        ->when($query, function ($q) use ($query) {
            $q->where('nom', 'LIKE', "%{$query}%")
              ->orWhere('adresse', 'LIKE', "%{$query}%")
              ->orWhere('proprietaire', 'LIKE', "%{$query}%");
        })
        
      
        ->limit(5)
        ->get();

    return response()->json($batiments);
}

    // Suppression d'un bâtiment
    public function destroy($code_batiment)
    {
        $batiment = Batiments::where('code_batiment', $code_batiment)->firstOrFail();
        Appartements::where('code_batiment', $code_batiment)->delete();
        $batiment->delete();
        return redirect()->route('batiments.index')->with('success', 'Bâtiment supprimé avec succès.');
    }
}