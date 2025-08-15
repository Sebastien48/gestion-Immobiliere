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
        return view('admin.users.create');
    }

    public function index()
    {
        $perPage = 10;
        $page = request()->input('page', 1);
        $filter = request()->input('filter', 'all');
        
        $query = User::with('agence')->orderBy('created_at', 'desc');
        
        if ($filter === 'active') {
            $query->where('status', 'active');
        } elseif ($filter === 'suspended') {
            $query->where('status', 'suspended');
        }
        
        $total = $query->count();
        
        $users = $query->skip(($page - 1) * $perPage)
                     ->take($perPage)
                     ->get();
        
        $semaine = Carbon::now()->subDays(7);
        $userssemaine = User::where('created_at', '>=', $semaine)->count();
        
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
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'telephone' => 'required|string|max:15',
            'agence_id' => 'nullable|exists:agences,id',
            'role' => 'required|in:administrateur,utilisateur',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $agence = null;
        if (!empty($validated['agence_id'])) {
            $agence = Agence::find($validated['agence_id']);
        }

        User::create([
            'code' => Str::random(5),
            'nom' => $validated['nom'],
            'prenom' => $validated['prenom'],
            'telephone' => $validated['telephone'],
            'role' => $validated['role'],
            'numero' => $agence ? $agence->numero : null,
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);

        return response()->json(['success' => true, 'message' => 'Utilisateur créé avec succès.']);
    }

    public function edit($code)
    {
        $user = User::with('agence')->find($code);
        
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Utilisateur non trouvé'], 404);
        }
        
        return response()->json([
            'success' => true,
            'user' => [
                'id' => $user->code,
                'code' => $user->code,
                'nom' => $user->nom,
                'prenom' => $user->prenom,
                'telephone' => $user->telephone,
                'agence' => $user->agence ? $user->agence->id : null,
                'role' => $user->role,
                'email' => $user->email
            ]
        ]);
    }

    public function update(Request $request, $code)
    {
        $user = User::find($code);
        
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Utilisateur non trouvé'], 404);
        }

        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'telephone' => 'required|string|max:15',
            'agence_id' => 'nullable|exists:agences,id',
            'role' => 'required|in:administrateur,utilisateur',
            'email' => 'required|string|email|max:255|unique:users,email,' . $code,
        ]);

        $agence = null;
        if (!empty($validated['agence_id'])) {
            $agence = Agence::find($validated['agence_id']);
        }

        $user->update([
            'nom' => $validated['nom'],
            'prenom' => $validated['prenom'],
            'telephone' => $validated['telephone'],
            'role' => $validated['role'],
            'numero' => $agence ? $agence->numero : null,
            'email' => $validated['email'],
        ]);

        return response()->json(['success' => true, 'message' => 'Utilisateur mis à jour avec succès']);
    }

    public function destroy($code)
    {
        $user = User::find($code);
        
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Utilisateur non trouvé'], 404);
        }
        
        $user->delete();
        
        return response()->json(['success' => true, 'message' => 'Utilisateur supprimé avec succès']);
    }
}