<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Agence;

class Loginfr extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Valider les entrées de l'utilisateur
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string|min:4|max:255',
        ]);

        // Tenter de connecter l'utilisateur
        if (Auth::attempt($credentials)) {
            // Récupérer l'utilisateur authentifié
            $user = Auth::user();

            // Rediriger en fonction du rôle de l'utilisateur
            if ($user->role === 'administrateur') {
                return redirect()->intended('admin/dashboard')->with('success', 'Connexion réussie en tant qu\'administrateur !');
            } else {
               
                 return redirect()->route('home')->with('success', 'Connexion réussie en tant qu\'utilisateur !');
            }
        }

        return back()->withErrors(['email' => 'Les informations d\'identification ne correspondent pas.']);
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login')->with('success', 'Déconnexion réussie !');
    }
}
