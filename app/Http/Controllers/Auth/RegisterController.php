<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Agence;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // Valider les entrées de l'utilisateur
        $validatedData = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'telephone' => 'required|string|max:15',
            'nomAgence' => 'required|string|max:255',
            'role' => 'required|in:admin,user',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Vérifier si l'agence existe ou l'eamil existe
        $agence = Agence::where('nomAgence', $validatedData['nomAgence'])->first();

        $usermail = User::where('email', $validatedData['email'])->first();

        if (!$agence) {
            return back()->withInput()->withErrors(['nomAgence' => 'Erreur: Le nom de l\'agence n\'existe pas !!']);
        }
        if(!$usermail) {
            return back()->withInput()->withErrors(['email' => 'Erreur: L\'email est déjà utilisé !!']);
        }
  // Créer un agent avec le numéro de l'agence
        $user = User::create([
            'code' => Str::uuid(),
            'nom' => $validatedData['nom'],
            'prenom' => $validatedData['prenom'],
            'telephone' => $validatedData['telephone'],
            'nomAgence' => $validatedData['nomAgence'],
            'role' => $validatedData['role'],
            'numero' => $agence->numero, // Insérer le numéro de l'agence
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
        ]);

        // Optionnellement, connecter l'utilisateur après l'inscription
        auth()->login($user);

        // rediger sur le menu principal
        return redirect()->route('home')->with('success', 'Inscription réussie !');

        
    }
}