<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Agence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class UserController extends Controller
{
    public function create()
    {
        return view('admin.users.create'); // Assurez-vous d'avoir une vue pour créer un utilisateur
    }
    public function index()
    {
        $perPage = 10; // Nombre d'utilisateurs par page
        $page = request()->input('page', 1); // Page actuelle, par défaut 1
        
        // Récupérer les utilisateurs avec pagination et relation agence
        $query = User::with('agence')->orderBy('created_at', 'desc');
        $total = $query->count();
        
        $users = $query->skip(($page - 1) * $perPage)
                     ->take($perPage)
                     ->get();
        
        //calculer le nombre d'utilisateurs inscrit cette semaine
        $semaine = Carbon::now()->subDays(7);
        $userssemaine = User::where('created_at', '>=', $semaine)->count();
        
        //calculer le nombre d'utilisateurs inscrit ce mois
        $mois = Carbon::now()->subMonth();
        $usersmois = User::where('created_at', '>=', $mois)->count();
        
        return response()->json([
            'success' => true,
            'total' => $total,
            'start' => ($page - 1) * $perPage + 1,
            'end' => min($page * $perPage, $total),
            'users' => $users,
            'from' => ($page - 1) * $perPage + 1,
            'to' => min($page * $perPage, $total),
            'current_page' => $page,
            'last_page' => ceil($total / $perPage),
            'userssemaine' => $userssemaine,
            'usersmois' => $usersmois
        ]);
    }

   public function store(Request $request)
{
    if ($request->expectsJson()) {
        $validated = $request->validate([
            
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
            'code' => Str::random(5), // Génération d'un code aléatoire
            'nom' => $validated['nom'],
            'prenom' => $validated['prenom'],
            'telephone' => $validated['telephone'],
            'role' => $validated['role'],
            'numero' => $agence->numero,
            'email' => $validated['email'],
            'password'=>bcrypt($validated['password']),
        ]);

        return response()->json(['success' => true, 'message' => 'Utilisateur créé avec succès.']);
    }

    return redirect()->back()->with('error', 'Requête invalide.');
}

    public function edit($id)
    {
        $user = User::with('agence')->find($id);
        
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Utilisateur non trouvé'], 404);
        }
        
        return response()->json([
            'success' => true,
            'user' => [
                'id' => $user->id,
                'code' => $user->code,
                'nom' => $user->nom,
                'prenom' => $user->prenom,
                'telephone' => $user->telephone,
                'agence' => $user->agence ? $user->agence->nomAgence : null,
                'role' => $user->role,
                'email' => $user->email
            ]
        ]);
    }

       // Si ce n’est pas une requête AJAX, on peut rediriger
   

}
    