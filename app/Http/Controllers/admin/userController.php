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
         // Nombre d'utilisateurs par page
        // Récupérer les utilisateurs avec pagination
        $query = User::orderBy('created_at', 'desc');
        $users = $query->paginate(10); // Pagination de 10 utilisateurs par page
        $users =$query->skip(($page - 1) * $perPage)
                     ->take($perPage)
                     ->get();
          $total =$query->count();
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

        /* User::create([
            'code' => Str::random(5), // Génération d'un code aléatoire
            'nom' => $validated['nom'],
            'prenom' => $validated['prenom'],
            'telephone' => $validated['telephone'],
            'nomAgence' => $validated['nomAgence'],
            'role' => $validated['role'],
            'numero' => $agence->numero,
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);*/
        User::create([
            'code' => Str::random(5), // Génération d'un code aléatoire
            'nom' => $validated['nom'],
            'prenom' => $validated['prenom'],
            'telephone' => $validated['telephone'],
            'nomAgence' => $validated['nomAgence'],
            'role' => $validated['role'],
            'numero' => $agence->numero,
            'email' => $validated['email'],
            'password'=>bcrypt($validated['password']),
        ]);

        return response()->json(['success' => true, 'message' => 'Utilisateur créé avec succès.']);
    }

    return redirect()->back()->with('error', 'Requête invalide.');
}

       // Si ce n’est pas une requête AJAX, on peut rediriger
   

}
    