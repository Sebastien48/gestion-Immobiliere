@extends('layout')

@section('title', 'Gestion des Locations')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <h2 class="text-2xl font-bold text-gray-800">
        <i class="fas fa-file-contract text-blue-600 mr-2"></i> Gestion des Locations
    </h2>
    <button onclick="openModal('addLocationModal')" 
        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center">
        <i class="fas fa-plus mr-2"></i> Nouvelle location
    </button>
</div>

@if (session('success'))
    <div class="mb-4 px-4 py-3 rounded-md bg-green-100 text-green-800 font-semibold flex items-center">
        <i class="fas fa-check-circle mr-2"></i>
        {{ session('success') }}
        @if(session('code_location'))
            <span class="ml-3 px-2 py-1 bg-blue-200 text-blue-700 rounded text-xs">
                Contrat # {{ session('code_location') }}
            </span>
        @endif
    </div>
@endif

@if ($errors->any())
    <div class="mb-4 px-4 py-3 rounded-md bg-red-100 text-red-800 font-semibold">
        <i class="fas fa-exclamation-circle mr-2"></i>
        <ul class="list-disc ml-6">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<!-- Filtres et recherche (exemple statique) -->
<div class="bg-white rounded-lg shadow p-4 mb-6">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div>
            <label for="statusFilter" class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
            <select id="statusFilter" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                <option value="">Toutes</option>
                <option value="active">Rupture du contrat</option>
                <option value="pending">En location</option>
                <option value="ended">Fin de la location</option>
            </select>
        </div>
        <div>
            <label for="buildingFilter" class="block text-sm font-medium text-gray-700 mb-1">Bâtiment</label>
            <select id="buildingFilter" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                <option value="">Tous les bâtiments</option>
                @foreach ($batiments as $b)
                    <option value="{{ $b->code_batiment }}">{{ $b->nom }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="dateFilter" class="block text-sm font-medium text-gray-700 mb-1">Période</label>
            <select id="dateFilter" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                <option value="">Toutes périodes</option>
                <option value="current">En cours</option>
                <option value="next-month">Prochain mois</option>
                <option value="past">Passées</option>
            </select>
        </div>
        <div>
            <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Recherche</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
                <input type="text" id="search" placeholder="Code de la location, locataire..." 
                       class="pl-10 w-full px-3 py-2 border border-gray-300 rounded-md">
                <div id="results"></div>  
            </div>
        </div>
    </div>
</div>

<!-- Tableau des locations (exemple statique ici, à remplacer par tes données réelles si souhaité) -->
<div class="bg-white rounded-lg shadow overflow-hidden mb-8">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Code de la location</th>
                    <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Locataire</th>
                    <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Appartement & bâtiment</th>
                    <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Période</th>
                    <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Loyer</th>
                    <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                    <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
           <tbody class="bg-white divide-y divide-gray-200">
    @foreach ($locations as $location)
        <tr>
            <!-- Code Location -->
            <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                <span class="font-mono text-blue-600">{{ $location->code_location ?? '-' }}</span>
            </td>
            <!-- Nom Prenom Locataire -->
            <td class="px-4 sm:px-6 py-4">
                <div class="flex items-center">
                    <div class="ml-4">
                        <div class="font-medium">
                            {{ $location->locataire->nom ?? '-' }} {{ $location->locataire->prenom ?? '' }}
                        </div>
                    </div>
                </div>
            </td>
            <!-- Appartement & Batiment -->
            <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                <div class="font-medium">{{ $location->appartement->numero ?? '-' }}</div>
                <div class="text-sm text-gray-500">{{ $location->batiment->nom ?? '-' }}</div>
            </td>
            <!-- Période -->
            <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                <div>{{ $location->periode ?? '-' }}</div>
            </td>
            <!-- Loyer & Caution-->
            <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                <div class="font-medium">{{ number_format($location->appartement->loyer_mensuel ?? 0, 0, ',', ' ') }} FCFA</div>
                <div class="text-sm text-gray-500">Caution: {{ number_format($location->caution ?? 0, 0, ',', ' ') }} FCFA</div>
            </td>
            <!-- Statut -->
            <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                <span class="px-2 py-1 
                    @if($location->statut === 'active') bg-green-100 text-green-800
                    @elseif($location->statut === 'arret') bg-red-100 text-red-800
                    @else bg-gray-100 text-gray-800
                    @endif
                    text-xs rounded-full">
                    {{ ucfirst($location->statut) }}
                </span>
            </td>
            <!-- Actions -->
            <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm font-medium">
                <div class="flex flex-col sm:flex-row gap-2">
                    <button class="text-blue-600 hover:text-blue-900" title="Détails">
                        <i class="fas fa-eye"></i>
                    </button>
                    <button class="text-yellow-600 hover:text-yellow-900" title="Modifier montant">
                        <i class="fas fa-money-bill-wave"></i>
                    </button>
                    <button class="text-purple-600 hover:text-purple-900" title="Prolonger">
                        <i class="fas fa-calendar-plus"></i>
                    </button>
                    <button class="text-red-600 hover:text-red-900" title="Résilier">
                        <i class="fas fa-file-contract"></i>
                    </button>
                </div>
            </td>
        </tr>
    @endforeach
    @if ($locations->isEmpty())
        <tr>
            <td colspan="7" class="text-center text-gray-500 py-6">Aucune location trouvée.</td>
        </tr>
    @endif
</tbody>
        </table>
    </div>

    <div class="bg-gray-50 px-4 sm:px-6 py-3 flex items-center justify-between border-t border-gray-200">
        <div class="text-sm text-gray-500">
            Affichage de
            <span>{{ $locations->firstItem() }}</span>
            à
            <span>{{ $locations->lastItem() }}</span>
            sur
            <span>{{ $locations->total() }}</span>
            locations
        </div>
        <nav class="flex space-x-2">
            {{ $locations->links() }}
        </nav>
    </div>
</div>

<!-- Modal Ajout de location -->
<div id="addLocationModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4 sm:p-6">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl mx-4 sm:mx-6 overflow-y-auto" style="max-height: 90vh;">
        <div class="flex justify-between items-center border-b px-4 sm:px-6 py-4 sticky top-0 bg-white z-10">
            <h3 class="text-lg font-bold text-gray-800">
                <i class="fas fa-file-contract text-blue-500 mr-2"></i> Nouvelle location
            </h3>
            <button onclick="closeModal('addLocationModal')" class="text-gray-400 hover:text-gray-500 text-xl">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <form id="addLocationForm" method="POST" action="{{ route('locations.store') }}" class="p-4 sm:p-6" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                <!-- Locataire -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Locataire*</label>
                    <select name="tenant_value" class="w-full px-3 py-2 border border-gray-300 rounded-md" required>
                        <option value="">-- Sélectionnez un locataire --</option>
                        @foreach ($locataires as $loc)
                            <option value="{{ $loc->code_locataires }}">{{ $loc->nom }} {{ $loc->prenom }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Bâtiment -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Bâtiment*</label>
                    <select name="building_value" id="locationBuildingSelect"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md"
                            data-apartments-url="{{ route('locations.apartments', ['codeBatiment' => '___CODE___']) }}"
                            required>
                        <option value="">Sélectionner un bâtiment</option>
                        @foreach ($batiments as $batiment )
                            <option value="{{ $batiment->code_batiment }}">{{ $batiment->nom }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Appartement -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Appartement*</label>
                    <select name="apartment_value" id="locationApartmentSelect" required class="w-full px-3 py-2 border border-gray-300 rounded-md" disabled>
                        <option value="">Sélectionnez d'abord un bâtiment</option>
                    </select>
                    <p class="text-xs text-gray-500 mt-1">Les appartements seront chargés automatiquement selon le bâtiment choisi.</p>
                </div>

                <!-- Dates et durée -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Date de début*</label>
                    <input type="date" name="start_date" required class="w-full px-3 py-2 border border-gray-300 rounded-md">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Durée (mois)*</label>
                    <input type="number" name="duration" min="1" value="12" required class="w-full px-3 py-2 border border-gray-300 rounded-md">
                </div>

                <!-- Loyer et caution (remplis automatiquement) -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Loyer mensuel*</label>
                    <input type="number" name="monthly_rent" id="locationMonthlyRent" required class="w-full px-3 py-2 border border-gray-300 rounded-md" readonly>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Caution*</label>
                    <input type="number" name="deposit" id="locationDeposit" required class="w-full px-3 py-2 border border-gray-300 rounded-md" >
                </div>

                <!-- Statut -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="statut">Statut*</label>
                    <select name="statut" id="statut" required class="w-full px-3 py-2 border border-gray-300 rounded-md">
                        <option value="">Sélectionner un statut</option>
                        <option value="arret">Arrêt</option>
                        <option value="en_location">En location</option>
                        <option value="en_attente">En attente</option>
                    </select>
                </div>

                <!-- Contrat PDF -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="contract_document">Document du contrat (PDF)*</label>
                    <input 
                        type="file" 
                        name="contract_document" 
                        id="contract_document" 
                        accept="application/pdf"
                        required 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" 
                    >
                    <p class="text-xs text-gray-500 mt-1">Format accepté: PDF uniquement (max: 2 Mo).</p>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-3 mt-6">
                <button type="button" onclick="closeModal('addLocationModal')" 
                        class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50 order-2 sm:order-1">
                    Annuler
                </button>
                <button type="submit" 
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 flex items-center justify-center order-1 sm:order-2 mb-3 sm:mb-0">
                    <i class="fas fa-save mr-2"></i> Enregistrer la location
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modals (détails, modification, prolongation, résiliation) -> conservés tels quels si besoin -->
<!-- ... tu peux conserver tes modals existants ici ... -->

<script>
    // Utilitaires Modals
    function openModal(modalId) {
        document.getElementById(modalId).classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }
    function closeModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    // Chargement dynamique des appartements en fonction du bâtiment (via API controller)
    (function setupDynamicApartments() {
        const buildingSelect = document.getElementById('locationBuildingSelect');
        const apartmentSelect = document.getElementById('locationApartmentSelect');
        const monthlyRentInput = document.getElementById('locationMonthlyRent');
      //  const depositInput = document.getElementById('locationDeposit');

        if (!buildingSelect || !apartmentSelect) return;

        const urlTemplate = buildingSelect.getAttribute('data-apartments-url'); // .../apartments/___CODE___

        buildingSelect.addEventListener('change', async function () {
            const codeBatiment = this.value;
            monthlyRentInput.value = '';
            

            // Reset Apartments select
            apartmentSelect.innerHTML = '<option value="">Sélectionnez d\'abord un bâtiment</option>';
            apartmentSelect.disabled = false;

            if (!codeBatiment) return;

            const url = urlTemplate.replace('___CODE___', encodeURIComponent(codeBatiment));

            try {
                const res = await fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    },
                    credentials: 'same-origin'
                });

                if (!res.ok) {
                    throw new Error('Erreur de chargement des appartements');
                }

                const payload = await res.json();
                apartmentSelect.innerHTML = '<option value="">-- Sélectionnez un appartement --</option>';

                (payload.data || []).forEach(app => {
                    const option = document.createElement('option');
                    option.value = app.code_appartement;
                    option.textContent = `${app.numero}${app.loyer_mensuel ? ' - ' + Number(app.loyer_mensuel).toLocaleString() + ' FCFA/mois' : ''}`;
                    if (app.loyer_mensuel) option.dataset.rent = app.loyer_mensuel;
                   
                    apartmentSelect.appendChild(option);
                });

                apartmentSelect.disabled = false;
            } catch (e) {
                console.error(e);
                apartmentSelect.innerHTML = '<option value="">Erreur de chargement</option>';
                apartmentSelect.disabled = true;
            }
        });

        // Quand un appartement est choisi, on remplit loyer et caution si disponibles
        apartmentSelect.addEventListener('change', function () {
            const opt = this.options[this.selectedIndex];
            monthlyRentInput.value = opt && opt.dataset.rent ? opt.dataset.rent : '';
            //depositInput.value = opt && opt.dataset.deposit ? opt.dataset.deposit : '';
        });
    })();
</script>
@endsection