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
        // Récupérer toutes les agences pour les afficher
        $agences = Agence::select('nomAgence')->get();
        
        // Debug: Afficher les agences disponibles
        \Log::info('Agences disponibles:', $agences->toArray());
        
        return view('auth.register', compact('agences'));
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
    // Validation des données avec messages personnalisés
    $validatedData = $request->validate([
        'nom' => 'required|string|max:255',
        'prenom' => 'required|string|max:255',
        'telephone' => 'required|string|max:20',
        'nomAgence' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:4|confirmed',
    ], [
        'nom.required' => 'Le nom est obligatoire.',
        'prenom.required' => 'Le prénom est obligatoire.',
        'telephone.required' => 'Le téléphone est obligatoire.',
        'nomAgence.required' => 'Le nom de l\'agence est obligatoire.',
        'email.required' => 'L\'email est obligatoire.',
        'email.email' => 'L\'email doit être valide.',
        'email.unique' => 'Cet email est déjà utilisé.',
        'password.required' => 'Le mot de passe est obligatoire.',
        'password.min' => 'Le mot de passe doit contenir au moins 4 caractères.',
        'password.confirmed' => 'Les mots de passe ne correspondent pas.',
    ]);

    // Vérification de l'agence
    $agence = Agence::where('nomAgence', $validatedData['nomAgence'])->first();

    if (!$agence) {
        return back()->withInput()->withErrors([
            'nomAgence' => 'Erreur : L\'agence "' . $validatedData['nomAgence'] . '" n\'existe pas dans notre base de données. Veuillez vérifier le nom de l\'agence.',
        ]);
    }

    // Debug: Vérifier les données de l'agence
    \Log::info('Agence trouvée:', [
        'numero' => $agence->numero,
        'nomAgence' => $agence->nomAgence,
    ]);

    // Génération du code unique
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

    // Création de l'utilisateur
    try {
        // Debug: Afficher les données avant création
       /* \Log::info('Données utilisateur à créer:', [
            'code' => $code,
            'nom' => $validatedData['nom'],
            'prenom' => $validatedData['prenom'],
            'telephone' => $validatedData['telephone'],
            'numero' => $agence->numero,
            'email' => $validatedData['email'],
            'role' => 'utilisateur',
        ]);*/

        $user = User::create([
            'code' => $code,
            'nom' => $validatedData['nom'],
            'prenom' => $validatedData['prenom'],
            'telephone' => $validatedData['telephone'],
            'numero' => $agence->numero,
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
            'role' => 'utilisateur',
        ]);

        // Connexion automatique
        auth()->login($user);

        // Redirection avec message de succès
        return redirect()->route('home')->with('success', 'Inscription réussie ! Bienvenue ' . $user->prenom . ' ' . $user->nom);

    } catch (\Exception $e) {
        // Log de l'erreur pour le debug
        \Log::error('Erreur lors de l\'inscription: ' . $e->getMessage());
        \Log::error('Stack trace: ' . $e->getTraceAsString());
        
        return back()->withInput()->withErrors([
            'database' => 'Erreur lors de la création du compte: ' . $e->getMessage(),
        ]);
    }
}
        // Valider les entrées de l'utilisateur
      
}