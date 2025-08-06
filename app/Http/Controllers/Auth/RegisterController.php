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
/*
    public function register(Request $request)
{
    // Étape 1 : Récupérer toutes les données pour debug (supprime cette ligne une fois le test terminé)
   // dd($request->all());

    // Étape 2 : Valider les données du formulaire
    $validatedData = $request->validate([
        'nom' => 'required|string|max:255',
        'prenom' => 'required|string|max:255',
        'telephone' => 'required|string|max:20',
        'nomAgence' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email',
        'password' => 'required|string|min:4',
        'password_confirmation' => 'required|string|min:4',
    ]);

    // Étape 3 : Vérifier si les mots de passe sont identiques
    if ($validatedData['password'] !== $validatedData['password_confirmation']) {
        return back()->withInput()->withErrors([
            'password' => 'Les mots de passe ne correspondent pas.',
        ]);
    }

    // Étape 4 : Vérifier si l’agence existe
    $agence = Agence::where('nomAgence', $validatedData['nomAgence'])->first();

    if (!$agence) {
        return back()->withInput()->withErrors([
            'nomAgence' => 'Erreur : Le nom de l\'agence n\'existe pas !',
        ]);
    }

    // Étape 5 : Créer l’utilisateur
    $user = User::create([
        'code' => strtoupper(Str::random(5)),
        'nom' => $validatedData['nom'],
        'prenom' => $validatedData['prenom'],
        'telephone' => $validatedData['telephone'],
        'nomAgence' => $validatedData['nomAgence'],
        'numero' => $agence->numero,
        'email' => $validatedData['email'],
        'password' => bcrypt($validatedData['password']),
        'role' => 'utilisateur',
    ]);

    // Étape 6 : Connexion automatique
    auth()->login($user);

    // Étape 7 : Redirection
    return redirect()->route('home')->with('success', 'Inscription réussie !');
}
    */

    public function register(Request $request)
{
    // Validation des données
    $validatedData = $request->validate([
        'nom' => 'required|string|max:255',
        'prenom' => 'required|string|max:255',
        'telephone' => 'required|string|max:20',
        'nomAgence' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:4|confirmed',
    ]);

    // Étape 3 : Vérification de l'agence
    $agence = Agence::where('nomAgence', $validatedData['nomAgence'])->first();

    if (!$agence) {
        return back()->withInput()->withErrors([
            'nomAgence' => 'Erreur : Le nom de l\'agence n\'existe pas !',
        ]);
    }

    // Étape 4 : Génération du code unique
    $code = '';
    $maxAttempts = 10;
    $attempt = 0;
    
    do {
        $code = strtoupper(Str::random(5));
        $attempt++;
    } while (User::where('code', $code)->exists() && $attempt < $maxAttempts);

    if ($attempt >= $maxAttempts) {
        return back()->withInput()->withErrors([
            'code' => 'Erreur lors de la génération du code unique. Veuillez réessayer.',
        ]);
    }

    // Étape 5 : Création de l'utilisateur
    try {
        $user = User::create([
            'code' => $code,
            'nom' => $validatedData['nom'],
            'prenom' => $validatedData['prenom'],
            'telephone' => $validatedData['telephone'],
            'nomAgence' => $validatedData['nomAgence'],
            'numero' => $agence->numero,
            'email' => $validatedData['email'],
             'password'=>bcrypt($validatedData['password']),
            'role' => 'utilisateur',
        ]);
    } catch (\Exception $e) {
        return back()->withInput()->withErrors([
            'database' => 'Erreur lors de la création du compte: ' . $e->getMessage(),
        ]);
    }

    // Étape 6 : Connexion automatique
     auth()->login($user);

    // Étape 7 : Redirection
    return redirect()->route('home')->with('success', 'Inscription réussie !');
}
        // Valider les entrées de l'utilisateur
      
}