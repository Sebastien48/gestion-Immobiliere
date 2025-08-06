<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Agence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function create()
    {
        return view('admin.users.create'); // Assurez-vous d'avoir une vue pour créer un utilisateur
    }

   public function store(Request $request)
{
    if ($request->expectsJson()) {
        $validated = $request->validate([
            'code' => 'required|string|max:255|unique:users,code',
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'telephone' => 'required|string|max:15',
            'nomAgence' => 'nullable|string',
            'role' => 'required|in:administrateur,utilisateur',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:6|confirmed', // attention au champ confirm
        ]);

        $agence = Agence::where('nomAgence', $validated['nomAgence'])->first();

        if (!$agence) {
            return response()->json(['success' => false, 'message' => "Le nom de l'agence n'existe pas."], 422);
        }

        User::create([
            'code' => $validated['code'],
            'nom' => $validated['nom'],
            'prenom' => $validated['prenom'],
            'telephone' => $validated['telephone'],
            'nomAgence' => $validated['nomAgence'],
            'role' => $validated['role'],
            'numero' => $agence->numero,
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        return response()->json(['success' => true, 'message' => 'Utilisateur créé avec succès.']);
    }

    return redirect()->back()->with('error', 'Requête invalide.');
}

       // Si ce n’est pas une requête AJAX, on peut rediriger
   

}
    