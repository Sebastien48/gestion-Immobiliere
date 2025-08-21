<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

use App\Models\Agence;
use App\Models\User;

use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
   

public function boot(): void
{
    View::composer('layout', function ($view) {
      
        //si l'utilisateur est connecté ,on doit afficher le nom de l'agence  sinon on met agence par defaut 
        
       $user = Auth::user(); // Utilisateur actuellement connecté
        
        // Vérification que l'utilisateur est connecté
        if (!$user) {
            return redirect()->route('login')->with('error', 'Veuillez vous connecter');
        }
        
        // 2. Récupérer l'agence liée à cet utilisateur via la relation
        $agence = $user->agence;
        
        $nomAgence = $agence ? $agence->nomAgence : 'Agence non trouvée';
        $logo1 = $agence ? $agence->logo : null;

        // Si pas d'agence, on crée une instance vide


        $initiales = strtoupper(
            substr($user->nom ?? '', 0, 1). substr($user->prenom ?? '', 0, 1)
        );
   

        $view->with([
            'agence' => $agence,
            'logo1' => $logo1,          // pour garder compatibilité avec ton blade
            'initiales' => $initiales, // idem
        ]);
    });

    
}

            
        
    }

