<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
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
            'password' => 'required|string|min:6',
        ]);

        // Tenter de connecter l'utilisateur
        if (auth()->attempt($credentials)) {
            // Récupérer l'utilisateur authentifié
            $user = auth()->user();

            // Rediriger en fonction du rôle de l'utilisateur
            if ($user->role === 'admin') {
                return redirect()->intended('admin/dashboard')->with('success', 'Connexion réussie en tant qu\'administrateur !');
            } else {
                return redirect()->intended('home')->with('success', 'Connexion réussie en tant qu\'utilisateur !');
            }
        }

        return back()->withErrors(['email' => 'Les informations d\'identification ne correspondent pas.']);
    }

    public function logout()
    {
        auth()->logout();
        return redirect('/')->with('success', 'Déconnexion réussie !');
    }
}
