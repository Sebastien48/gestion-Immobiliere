<?php

namespace App\Http\Controllers\Agence;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\MassAssignmentException;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

// Importation des modèles nécessaires
use App\Models\Locations;
use App\Models\Batiments;
use App\Models\Appartements;
use App\Models\Locataires;

class LocationsController extends Controller
{
    /**
     * Liste paginée des locations de l'agence connectée, avec relations pré-chargées.
     */
    public function index(Request $request)
{
    $user = Auth::user();
    $agenceCode = $user->numero;

    // Récupération de tous les bâtiments de l'agence connectée
    $batiments = Batiments::where('code_agence', $agenceCode)->get();

    // Récupération de tous les locataires de l'agence connectée
    $locataires = Locataires::where('code_agence', $agenceCode)->get();

    // Chargement des locations avec relations (pour le tableau des locations)
    $locations = Locations::where('code_agence', $agenceCode)
        ->with(['locataire', 'batiment', 'appartement'])
        ->paginate(10);

    // Envoi à la vue de toutes les datas nécessaires
    return view('locations.index', compact('locations', 'batiments', 'locataires'));
}
    /**
     * Afficher le formulaire de création d'une nouvelle location.
     */
    public function create()
    {
        $user = Auth::user();
        $agenceCode = $user->numero;
        // On récupère les données nécessaires pour le formulaire
        $locataires = Locataires::where('code_agence', $agenceCode)->get();
        $batiments  = Batiments::where('code_agence', $agenceCode)->get();
        $appartements = Appartements::whereIn('code_batiment', $batiments->pluck('code_batiment'))->get();

        return view('locations.create', compact('locataires', 'batiments', 'appartements'));
    }

    /**
     * Traite la création d'une nouvelle location.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'tenant_value'      => 'required|string|max:255',
            'building_value'    => 'required|string|max:255',
            'apartment_value'   => 'required|string|max:255',
            'statut'            => 'required|string|max:50',
            'start_date'        => 'required|date',
            'duration'          => 'required|numeric|min:1',
            'monthly_rent'      => 'required|numeric',
            'deposit'           => 'required|numeric',
            'contract_document' => 'required|file|mimes:jpeg,png,jpg,pdf|max:2048',
        ]);

        $filePath = null;

        try {
            $user = Auth::user();
            $codeAgence = $user->numero;

            $batiment = Batiments::where('code_batiment', $validatedData['building_value'])
                ->where('code_agence', $codeAgence)
                ->first();

            if (! $batiment) {
                return back()->withErrors(['building_value' => "Bâtiment introuvable ou non rattaché à votre agence."])->withInput();
            }

            $appartement = Appartements::where('code_appartement', $validatedData['apartment_value'])
                ->where('code_batiment', $batiment->code_batiment)
                ->first();

            if (! $appartement) {
                return back()->withErrors(['apartment_value' => "Appartement introuvable dans ce bâtiment."])->withInput();
            }

            $locataire = Locataires::where('code_locataires', $validatedData['tenant_value'])
                ->where('code_agence', $codeAgence)
                ->first();

            if (! $locataire) {
                return back()->withErrors(['tenant_value' => "Locataire introuvable pour votre agence."])->withInput();
            }

            $year = date('Y');
            $lastLocation = Locations::where('code_location', 'like', "LOC-{$year}-%")
                ->orderBy('code_location', 'desc')
                ->first();

            if ($lastLocation && preg_match('/^LOC-' . $year . '-(\d{3})$/', $lastLocation->code_location, $m)) {
                $newNumber = str_pad(((int) $m[1]) + 1, 3, '0', STR_PAD_LEFT);
            } else {
                $newNumber = '001';
            }
            $code_location = "LOC-{$year}-{$newNumber}";

            if ($request->hasFile('contract_document') && $request->file('contract_document')->isValid()) {
                $extension = $request->file('contract_document')->getClientOriginalExtension();
                $fileName = $code_location . '_' . time() . '.' . $extension;
                $filePath = $request->file('contract_document')->storeAs('contrats', $fileName, 'public');
            } else {
                return back()->withErrors(['contract_document' => "Le fichier du contrat n'est pas valide."])->withInput();
            }

            $dateDebut = Carbon::parse($validatedData['start_date'])->startOfDay();
            $duration = (int) $validatedData['duration'];
            $dateFin = $dateDebut->copy()->addMonths($duration)->subDay();
            $periodeString = $dateDebut->toDateString() . ' - ' . $dateFin->toDateString() . " ({$duration} mois)";

            $location = Locations::create([
                'code_location'    => $code_location,
                'periode'          => $periodeString,
                'caution'          => $validatedData['deposit'],
                'statut'           => $validatedData['statut'],
                //'date_debut'       => $dateDebut->toDateString(),
                'code_agence'      => $codeAgence,
                'code_batiment'    => $batiment->code_batiment,
                'code_appartement' => $appartement->code_appartement,
                'code_locataire'   => $locataire->code_locataires,
                'contrat_document' => $filePath,
            ]);

            // Marquer l'appartement en location
            $appartement->statut = 'en_location';
            $appartement->save();

            return redirect()->route('locations.index')->with([
                'success' => "Location créée avec succès !",
                'code_location' => $code_location,
            ]);
        } catch (ValidationException $e) {
            throw $e;
        } catch (MassAssignmentException $e) {
            Log::error('Mass assignment lors de la création de la location: '.$e->getMessage());
            return back()->withErrors([
                'internal_error' => "Attribut(s) non assignable(s) sur Locations: ".$e->getMessage(),
            ])->withInput();
        } catch (\Throwable $e) {
            if (!empty($filePath) && Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            }
            Log::error('Erreur lors de la création de la location: '.$e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return back()->withErrors(['internal_error' => $e->getMessage(). ' | '.$e->getFile().':'.$e->getLine()])->withInput();
        }
    }

    /**
     * Affiche les détails d'une location donnée.
     */
  /*  public function show($id)
    {
        $location = Locations::with(['locataire', 'batiment', 'appartement'])->findOrFail($id);
        return view('locations.show', compact('location'));
    }
    */
    /**
     * API: Appartements disponibles pour un bâtiment précis (par code_batiment)
     * GET /agence-immobiliere/locations/apartments/{codeBatiment}
     * Retourne un JSON des appartements
     */
    public function apartmentsByBuilding(Request $request, string $codeBatiment)
    {
        $user = Auth::user();
        $agenceCode = $user->numero;

        // Vérifie que le bâtiment appartient bien à l'agence connectée
        $batiment = Batiments::where('code_batiment', $codeBatiment)
            ->where('code_agence', $agenceCode)
            ->first();

        if (! $batiment) {
            return response()->json(['message' => "Bâtiment introuvable ou non rattaché à votre agence."], 404);
        }

        // On filtre selon le bâtiment, et on peut limiter aux dispo si besoin
        $appartements = Appartements::where('code_batiment', $codeBatiment)
            ->get()
            ->map(function ($app) {
                return [
                    'code_appartement' => $app->code_appartement,
                    'numero'           => $app->numero,
                    'loyer_mensuel'    => $app->loyer_mensuel,
                    'capacite'         => $app->capacite ?? '',
                    'statut'           => $app->statut,
                ];
            });

        return response()->json(['data' => $appartements]);
    }

    /**
     * Affiche le formulaire d'édition d'une location.
     */
    public function edit($id)
    {
        $location = Locations::with(['locataire', 'batiment', 'appartement'])->findOrFail($id);
        $user = Auth::user();
        $agenceCode = $user->numero;
        $locataires = Locataires::where('code_agence', $agenceCode)->get();
        $batiments = Batiments::where('code_agence', $agenceCode)->get();
        $appartements = Appartements::whereIn('code_batiment', $batiments->pluck('code_batiment'))->get();

        return view('locations.edit', compact('location', 'locataires', 'batiments', 'appartements'));
    }

    /**
     * Met à jour une location dans la base.
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'statut'            => 'required|string|max:50',
            'start_date'        => 'required|date',
            'duration'          => 'required|numeric|min:1',
            'deposit'           => 'required|numeric',
            // autres champs selon le besoin
        ]);

        $location = Locations::findOrFail($id);
        $dateDebut = Carbon::parse($validatedData['start_date'])->startOfDay();
        $duration = (int) $validatedData['duration'];
        $dateFin = $dateDebut->copy()->addMonths($duration)->subDay();
        $periodeString = $dateDebut->toDateString() . ' - ' . $dateFin->toDateString() . " ({$duration} mois)";

        $location->update([
            'periode'  => $periodeString,
            'caution'  => $validatedData['deposit'],
            'statut'   => $validatedData['statut'],
            //'date_debut' => $dateDebut->toDateString(),
            // autres champs
        ]);

        return redirect()->route('locations.index')->with('success', 'Location mise à jour avec succès !');
    }

    /**
     * Supprime une location.
     */
    public function destroy($id)
    {
        $location = Locations::findOrFail($id);

        // libère l'appartement ?
        $appartement = $location->appartement;
        if ($appartement) {
            $appartement->statut = 'disponible';
            $appartement->save();
        }

        // suppression du document associé
        if ($location->contrat_document && Storage::disk('public')->exists($location->contrat_document)) {
            Storage::disk('public')->delete($location->contrat_document);
        }

        $location->delete();
        return redirect()->route('locations.index')->with('success', 'Location supprimée !');
    }
}