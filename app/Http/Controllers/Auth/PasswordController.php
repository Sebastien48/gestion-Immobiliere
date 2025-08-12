<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
class PasswordController extends Controller
{
    //
    public function index()
    { return view('auth.password');}

    public function check(){
        //on récupère les données du formulaire

        $email = request()->input('email');
        $telephone =request()->input('telephone');

        //on compare ces données aux données de la table users
        $user = User::where('email', $email)->first();
        //si on trouve un utilisateur
        if($user !== null){
            //on le renvoie vers la page de réinitialiation de son de mot de passe
            return redirect()->route('reset.password')->with('success', 'Veuillez renseigner votr');
            }else{
                //sinon on affiche un message d'erreur
                return redirect()->back()->with('error', 'Aucun utilisateur trouvé');
            }

    }
}
