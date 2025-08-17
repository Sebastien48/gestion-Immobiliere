<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Models\Agence;
use Carbon\Carbon;// pour utiliser dynamiquement le graphique 
 use App\Models\User; 
 use App\Models\Batiments;
 use App\Models\Appartements;// Import the Agence model
use App\Models\Locataires;

class AgenceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index(Request $request)
{
    
}

    /**
     * Show the form for creating a new resource.
     */
public function list(Request $request)
{
    $perPage = 10;
    $page = $request->input('page', 1);
    $query = Agence::with('users')->orderBy('created_at', 'desc');
    $total = $query->count();
    $agences = $query->skip(($page - 1) * $perPage)
                     ->take($perPage)
                     ->get();

    return response()->json([
        'success' => true,
        'total' => $total,
        'start' => ($page - 1) * $perPage + 1,
        'end' => min($page * $perPage, $total),
        'agences' => $agences,
        'to' => min($page * $perPage, $total),
        'from' => ($page - 1) * $perPage + 1,
        'current_page' => $page,
        'last_page' => ceil($total / $perPage),
    ]);
}

 public function stats(Request $request)
 {
    $months = [];
    $counts = [];
    for ($i = 6; $i >= 0; $i--) {
        $month = Carbon::now()->subMonths($i)->format('Y-m');
        $months[] = Carbon::now()->subMonths($i)->format('M Y');
        $counts[] = User::whereYear('created_at', Carbon::now()->subMonths($i)->year)
                        ->whereMonth('created_at', Carbon::now()->subMonths($i)->month)
                        ->count();
    }

    // Répartition par rôle
    $roles = User::selectRaw('role, COUNT(*) as count')->groupBy('role')->pluck('count', 'role');

    // Comptage des bâtiments, appartements et locataires
    $batimentsCount = Batiments::count();
    $appartementsCount = Appartements::count();
   // $locatairesCount = Locataires::count();

    // Données pour le graphique de performances immobilières
    $performanceData = [
        'batiments' => $batimentsCount,
        'appartements' => $appartementsCount,
       // 'locataires' => $locatairesCount,
       // 'locations' => $locatairesCount // Supposons que le nombre de locations = nombre de locataires
    ];

    return response()->json([
        'months' => $months,
        'inscriptions' => $counts,
        'roles' => $roles,
        'performance' => $performanceData,
        'batiments_total' => $batimentsCount,
        'appartements_total' => $appartementsCount,
       // 'locataires_total' => $locatairesCount
    ]);
 }

    public function create()
    {
        //
        return view('agences.create'); // Assuming you have a view for creating an agence
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validation des données
            $validated = $request->validate([
                'numero' => 'required|string|max:50|unique:agences,numero',
                'nomAgence' => 'required|string|max:255',
                'fondateur' => 'required|string|max:255',
                'emailAgence' => 'required|email|unique:agences,emailAgence',
                'adresse' => 'required|string',
                'telephoneAgence' => 'required|string|max:20',
                'logo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                'document' => 'required|image|mimes:jpeg,png,jpg|max:2048'
            ]);

            // Double vérification (optionnelle ici à cause de `unique:` dans la validation)
            if (Agence::where('emailAgence', $validated['emailAgence'])->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'L\'email est déjà utilisé par une autre agence.'
                ], 400);
            }

            if (Agence::where('numero', $validated['numero'])->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Le numéro d\'agence est déjà utilisé.'
                ], 400);
            }

            // Vérification des fichiers uploadés
            if (!$request->hasFile('logo') || !$request->file('logo')->isValid()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Le fichier logo est invalide ou manquant.'
                ], 400);
            }

            if (!$request->hasFile('document') || !$request->file('document')->isValid()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Le fichier document est invalide ou manquant.'
                ], 400);
            }

            // Stockage des fichiers avec gestion d'erreurs
            $logoPath = null;
            $documentPath = null;

            try {
                $logoPath = $request->file('logo')->store('agences/logos', 'public');
                if (!$logoPath) {
                    throw new \Exception('Échec du stockage du logo');
                }
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur lors du stockage du logo: ' . $e->getMessage()
                ], 500);
            }

            try {
                $documentPath = $request->file('document')->store('agences/documents', 'public');
                if (!$documentPath) {
                    throw new \Exception('Échec du stockage du document');
                }
            } catch (\Exception $e) {
                // Supprimer le logo déjà stocké en cas d'erreur
                if ($logoPath && Storage::disk('public')->exists($logoPath)) {
                    Storage::disk('public')->delete($logoPath);
                }
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur lors du stockage du document: ' . $e->getMessage()
                ], 500);
            }

            // Création de l'agence avec gestion d'erreurs de base de données
            try {
                $agence = Agence::create([
                    'numero' => $validated['numero'],
                    'nomAgence' => $validated['nomAgence'],
                    'fondateur' => $validated['fondateur'],
                    'emailAgence' => $validated['emailAgence'],
                    'adresse' => $validated['adresse'],
                    'telephoneAgence' => $validated['telephoneAgence'],
                    'logo' => $logoPath,
                    'document' => $documentPath,
                    'status' => 'pending'
                ]);

                if (!$agence) {
                    throw new \Exception('Échec de la création de l\'agence en base de données');
                }

            } catch (\Illuminate\Database\QueryException $e) {
                // Supprimer les fichiers stockés en cas d'erreur de base de données
                if ($logoPath && Storage::disk('public')->exists($logoPath)) {
                    Storage::disk('public')->delete($logoPath);
                }
                if ($documentPath && Storage::disk('public')->exists($documentPath)) {
                    Storage::disk('public')->delete($documentPath);
                }

                // Identifier le type d'erreur de base de données
                $errorCode = $e->getCode();
                $errorMessage = $e->getMessage();

                if (str_contains($errorMessage, 'Duplicate entry')) {
                    if (str_contains($errorMessage, 'emailAgence')) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Erreur de base de données: L\'email est déjà utilisé par une autre agence.'
                        ], 400);
                    } elseif (str_contains($errorMessage, 'numero')) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Erreur de base de données: Le numéro d\'agence est déjà utilisé.'
                        ], 400);
                    } else {
                        return response()->json([
                            'success' => false,
                            'message' => 'Erreur de base de données: Données dupliquées détectées.'
                        ], 400);
                    }
                } elseif (str_contains($errorMessage, 'Connection refused') || str_contains($errorMessage, 'server has gone away')) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Erreur de connexion à la base de données. Veuillez réessayer.'
                    ], 500);
                } elseif (str_contains($errorMessage, 'Data too long')) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Erreur de base de données: Certaines données sont trop longues.'
                    ], 400);
                } elseif (str_contains($errorMessage, 'doesn\'t have a default value')) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Erreur de base de données: Champ obligatoire manquant.'
                    ], 400);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Erreur de base de données: ' . $errorMessage
                    ], 500);
                }

            } catch (\Exception $e) {
                // Supprimer les fichiers stockés en cas d'erreur générale
                if ($logoPath && Storage::disk('public')->exists($logoPath)) {
                    Storage::disk('public')->delete($logoPath);
                }
                if ($documentPath && Storage::disk('public')->exists($documentPath)) {
                    Storage::disk('public')->delete($documentPath);
                }

                return response()->json([
                    'success' => false,
                    'message' => 'Erreur lors de la création de l\'agence: ' . $e->getMessage()
                ], 500);
            }

            return response()->json([
                'success' => true,
                'message' => 'Agence créée avec succès!',
                'agence_id' => $agence->id
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation: ' . implode(', ', $e->validator->errors()->all())
            ], 422);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur inattendue: ' . $e->getMessage()
            ], 500);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
    * Show the form for editing the specified resource.
    */
    public function edit(string $id)
    {
    $agence = Agence::find($id);
    
    if (!$agence) {
    return response()->json(['success' => false, 'message' => 'Agence non trouvée'], 404);
    }
    
    return response()->json($agence);
    }
    
    /**
    * Update the specified resource in storage.
    */
    public function update(Request $request, string $numero)
    {
    $agence = Agence::find($numero);
    
    if (!$agence) {
    return response()->json(['success' => false, 'message' => 'Agence non trouvée'], 404);
    }
    
    $validated = $request->validate([
    'numero' => 'required|string|max:50|unique:agences,numero,' . $numero,
    'nomAgence' => 'required|string|max:255',
    'fondateur' => 'required|string|max:255',
    'emailAgence' => 'required|email|unique:agences,emailAgence,' . $numero,
    'adresse' => 'required|string',
    'telephoneAgence' => 'required|string|max:20',
    'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    'document' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
    ]);
    
    // Mise à jour des fichiers si fournis
    if ($request->hasFile('logo')) {
    $logoPath = $request->file('logo')->store('agences/logos', 'public');
    $validated['logo'] = $logoPath;
    }
    
    if ($request->hasFile('document')) {
    $documentPath = $request->file('document')->store('agences/documents', 'public');
    $validated['document'] = $documentPath;
    }
    
    $agence->update($validated);
    
    return response()->json([
    'success' => true,
    'message' => 'Agence mise à jour avec succès!'
    ]);
    }
    
    /**
    * Remove the specified resource from storage.
    */
    public function destroy(string $id)
    {
    $agence = Agence::find($id);
    
    if (!$agence) {
    return response()->json(['success' => false, 'message' => 'Agence non trouvée'], 404);
    }
    
    $agence->delete();
    
    return response()->json(['success' => true, 'message' => 'Agence supprimée avec succès']);
    }
}