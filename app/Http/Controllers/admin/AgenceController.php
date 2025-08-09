<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Agence;
use Carbon\Carbon;
 use App\Models\User; // Import the Agence model

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
    for ($i = 12; $i >= 0; $i--) {
        $month = Carbon::now()->subMonths($i)->format('Y-m');
        $months[] = Carbon::now()->subMonths($i)->format('M Y');
        $counts[] = User::whereYear('created_at', Carbon::now()->subMonths($i)->year)
                        ->whereMonth('created_at', Carbon::now()->subMonths($i)->month)
                        ->count();
    }

    // Répartition par rôle
    $roles = User::selectRaw('role, COUNT(*) as count')->groupBy('role')->pluck('count', 'role');

    return response()->json([
        'months' => $months,
        'inscriptions' => $counts,
        'roles' => $roles
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

    // Stockage des fichiers
    $logoPath = $request->file('logo')->store('agences/logos', 'public');
    $documentPath = $request->file('document')->store('agences/documents', 'public');

    // Création de l'agence
    Agence::create([
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

    return response()->json([
        'success' => true,
        'message' => 'Agence créée avec succès!'
    ]);
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
