<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Agence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{
    /**
     * Affiche le formulaire d'inscription.
     * Récupère toutes les agences pour affichage dans la vue.
     */
    public function showRegistrationForm()
    {
        $agences = Agence::select('nomAgence')->get();

        // Log les agences récupérées (debug)
        Log::info('Agences disponibles:', $agences->toArray());

        return view('auth.register', compact('agences'));
    }

    /**
     * Enregistre un nouvel utilisateur après validations.
     * Gère code unique, vérification agence, logging, et exceptions.
     */
    public function register(Request $request)
    {
        // Validation des données avec messages personnalisés
        $validatedData = $request->validate([
            'nom'        => 'required|string|max:255',
            'prenom'     => 'required|string|max:255',
            'telephone'  => 'required|string|max:20',
            'nomAgence'  => 'required|string|max:255',
            'email'      => 'required|string|email|max:255|unique:users',
            'password'   => 'required|string|min:4|confirmed',
        ], [
            'nom.required'         => 'Le nom est obligatoire.',
            'prenom.required'      => 'Le prénom est obligatoire.',
            'telephone.required'   => 'Le téléphone est obligatoire.',
            'nomAgence.required'   => 'Le nom de l\'agence est obligatoire.',
            'email.required'       => 'L\'email est obligatoire.',
            'email.email'          => 'L\'email doit être valide.',
            'email.unique'         => 'Cet email est déjà utilisé.',
            'password.required'    => 'Le mot de passe est obligatoire.',
            'password.min'         => 'Le mot de passe doit contenir au moins 4 caractères.',
            'password.confirmed'   => 'Les mots de passe ne correspondent pas.',
        ]);

        // Vérifie que l'agence existe
        $agence = Agence::where('nomAgence', $validatedData['nomAgence'])->first();

        if (!$agence) {
            return back()->withInput()->withErrors([
                'nomAgence' => 'Erreur : L\'agence "' . $validatedData['nomAgence'] . '" n\'existe pas dans notre base de données. Veuillez vérifier le nom de l\'agence.',
            ]);
        }

        // Log agence trouvée
        Log::info('Agence trouvée:', [
            'numero'    => $agence->numero,
            'nomAgence' => $agence->nomAgence,
        ]);

        // Génère un code unique pour l'utilisateur (tentatives max 10)
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

        // Création de l'utilisateur avec gestion d'exception
        try {
            $user = User::create([
                'code'      => $code,
                'nom'       => $validatedData['nom'],
                'prenom'    => $validatedData['prenom'],
                'telephone' => $validatedData['telephone'],
                'numero'    => $agence->numero,
                'email'     => $validatedData['email'],
                'password'  => bcrypt($validatedData['password']),
                'role'      => 'utilisateur',
            ]);

            // Connexion automatique
            Auth::login($user);

            // Redirection réussie
            return redirect()->route('home')->with('success', 'Inscription réussie ! Bienvenue ' . $user->prenom . ' ' . $user->nom);

        } catch (\Exception $e) {
            // Log l'erreur (debug)
            Log::error('Erreur lors de l\'inscription: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());

            return back()->withInput()->withErrors([
                'database' => 'Erreur lors de la création du compte: ' . $e->getMessage(),
            ]);
        }
    }
}