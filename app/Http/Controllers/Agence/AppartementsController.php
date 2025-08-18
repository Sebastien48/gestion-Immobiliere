<?php

namespace App\Http\Controllers\Agence;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appartement;
use App\Models\Appartements;
use App\Models\Batiment;
use App\Models\Batiments;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AppartementsController extends Controller
{
    public function index()
{
    $user = Auth::user();
    if (!$user) return redirect()->route('login');

    $agence = $user->agence;
    $batiments = Batiments::where('code_agence', $agence->numero)->get();
    $appartements = Appartements::whereIn('code_batiment', $batiments->pluck('code_batiment'))->paginate(10);

    return view('appartements.index', compact('appartements', 'agence', 'batiments'));
}

public function store(Request $request)
{
    $validatedData = $request->validate([
        'numero' => 'required|string|max:255',
        'superficie' => 'required|numeric',
        'loyer_mensuel' => 'required|numeric',
        'statut' => 'nullable|string|max:50',
        'code_batiment' => 'required|exists:batiments,code_batiment'
    ]);
    $code_appartement = strtoupper(Str::random(3)) . rand(10, 99);

    Appartements::create([
        'code_appartement' => $code_appartement,
        'numero' => $validatedData['numero'],
        'superficie' => $validatedData['superficie'],
        'loyer_mensuel' => $validatedData['loyer_mensuel'],
        'statut' => $validatedData['statut'] ?? 'libre',
        'code_batiment' => $validatedData['code_batiment'],
    ]);
    return redirect()->route('appartements.index')->with('success', 'Appartement créé avec succès');

}
//  afficher les appartements

public function show($code_appartement)
{
    $user = Auth::user();
    $agence = $user->agence;
    $appartement = Appartements::where('code_appartement', $code_appartement)->firstOrFail();

    return view('appartements.show', compact('appartement', 'agence'));
}
}


