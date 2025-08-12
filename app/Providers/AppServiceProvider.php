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
        // conserver le nom de l'agence , le logo de l'agence  et  les initialisateurs  de l'utilisateurs  connecté
        View::composer('layout', function ($view) {
        $user = Auth::user();
        $agence = Agence::where('user_id', Auth::id())->first();
        // Obtenir les initiales : première lettre du nom et première lettre du prénom
        $initiales = strtoupper(substr($user->name, 0, 1) . substr($user->prenom, 0, 1));
        // Importer le logo de l'agence via le modèle Agence
        $logo = $agence->logo ?? asset('images/default-logo.png');
        // Passer les données à la vue
        $view->with([
            'agenceName'   => $agence->name ?? 'Agence',
            'agenceLogo'   => $logo,
            'userInitials' => $initiales,
        ]);
    });
            
        
    }
}
