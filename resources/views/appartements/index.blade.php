@extends('layout')

@section('title', 'Gestion des Appartements')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <h2 class="text-2xl font-bold text-gray-800">
        <i class="fas fa-home text-blue-600 mr-2"></i> Gestion des Appartements
    </h2>
    <button onclick="openApartmentModal()" 
        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center">
        <i class="fas fa-plus mr-2"></i> Ajouter un appartement
    </button>
</div>
   @if (session('success'))
    <div class="mb-4 px-4 py-3 rounded-md bg-green-100 text-green-800 font-semibold flex items-center">
        <i class="fas fa-check-circle mr-2"></i>
        {{ session('success') }}
        @if(session('code_agence'))
            <span class="ml-3 px-2 py-1 bg-blue-200 text-blue-700 rounded text-xs">
                Agence # {{ session('code_agence') }}
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
<!-- Filtres et recherche -->
<div class="bg-white rounded-lg shadow p-4 mb-6">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <!-- Filtre par bâtiment -->
        <div>
            <label for="buildingFilter" class="block text-sm font-medium text-gray-700 mb-1">Bâtiment</label>
            <select id="buildingFilter" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                <option value="">Tous les bâtiments</option>
                @foreach ($batiments as $batiment )
                <option value="{{$batiment ->code_batiment}}"> {{$batiment->nom}}</option>
                
                @endforeach
                
            </select>
        </div>
        
        <!-- Filtre par statut -->
        <div>
            <label for="statusFilter" class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
            <select id="statusFilter" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                <option value="">Tous</option>
                <option value="libre">Libre</option>
                <option value="occupe">Occupé</option>
            </select>
        </div>
        
        <!-- Recherche -->
        <div class="md:col-span-2">
            <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Recherche</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
                <input type="text" id="search" placeholder="Numéro, superficie, loyer..." 
                       class="pl-10 w-full px-3 py-2 border border-gray-300 rounded-md">
            </div>
        </div>
    </div>
</div>

<!-- Modal Ajout/Modification Appartement -->
<div id="apartmentModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl">
        <div class="flex justify-between items-center border-b px-6 py-4">
            <h3 class="text-lg font-bold text-gray-800" id="modalTitle">
                <i class="fas fa-plus-circle text-blue-500 mr-2"></i> Ajouter un appartement
            </h3>
            <button onclick="closeModal('apartmentModal')" class="text-gray-400 hover:text-gray-500">
                <i class="fas fa-times"></i>
            </button>
        </div>
                <form id="apartmentForm" method="POST" action="{{ route('appartements.store') }}" class="p-6">
                        @csrf  
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Numéro*</label>
                                <input type="text" name="numero" required 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Bâtiment*</label>
                                <select name="code_batiment" required class="w-full px-3 py-2 border border-gray-300 rounded-md">
                                    <option value="">Sélectionner un bâtiment</option>
                                    @foreach($batiments as $batiment)
                                        <option value="{{ $batiment->code_batiment }}">{{ $batiment->nom }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Superficie (m²)*</label>
                                <input type="number" step="0.01" name="superficie" required 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Loyer mensuel*</label>
                                <input type="number" step="0.01" name="loyer_mensuel" required 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md">
                            </div>
                            
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
                                <select name="statut" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                                    <option value="libre">Libre</option>
                                    <option value="occupe">Occupé</option>
                                </select>
                            </div>
                        </div>
                        <div class="flex justify-end space-x-3 mt-6">
                            <button type="button" onclick="closeModal('apartmentModal')" 
                                    class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                Annuler
                            </button>
                            <button type="submit" 
                                    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 flex items-center">
                                <i class="fas fa-save mr-2"></i> Enregistrer
                            </button>
                        </div>
                    </form>
    </div>
</div>

<!-- Tableau des appartements -->
<div class="bg-white rounded-lg shadow overflow-hidden mb-8">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Numéro
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Bâtiment
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Superficie
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Loyer
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Statut
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                   @forelse($appartements as $app)
<tr>
    <td class="px-6 py-4 whitespace-nowrap">
        <a href="{{ route('appartements.show', $app->code_appartement) }}" class="font-medium text-blue-600 hover:text-blue-800">
            {{ $app->numero ?? '-' }}
        </a>
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
        {{ optional($app->batiment)->nom ?? $app->code_batiment ?? '-' }}
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
        {{ is_numeric($app->superficie) ? $app->superficie . ' m²' : '-' }}
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
        {{ is_numeric($app->loyer_mensuel) ? number_format($app->loyer_mensuel, 0, ',', ' ') . ' FCFA' : '-' }}
    </td>
    <td class="px-6 py-4 whitespace-nowrap">
        <span class="px-2 py-1 {{ $app->statut == 'libre' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }} text-xs rounded-full">
            {{ $app->statut ? ucfirst($app->statut) : '-' }}
        </span>
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
        <button onclick="editApartment('{{ $app->code_appartement }}')" class="text-blue-600 hover:text-blue-900 mr-3">
            <i class="fas fa-edit"></i>
        </button>
        <button onclick="openDeleteModal('{{ $app->code_appartement }}')" class="text-red-600 hover:text-red-900">
            <i class="fas fa-trash"></i>
        </button>
    </td>
</tr>
@empty
<tr>
    <td colspan="6" class="text-center py-4 text-gray-500">Aucun appartement trouvé.</td>
</tr>
@endforelse
</tbody>
        </table>
    </div>
    
    <!-- Pagination -->
            <div class="bg-gray-50 px-6 py-3 flex items-center justify-between border-t border-gray-200">
    <div class="text-sm text-gray-500">
        Affichage de <span>{{ $appartements->firstItem() }}</span> à <span>{{ $appartements->lastItem() }}</span> sur <span>{{ $appartements->total() }}</span> appartements
    </div>
    <div>
        {{ $appartements->links() }}
    </div>
</div>
</div>

<!-- Modal Suppression -->
<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-md">
        <div class="flex justify-between items-center border-b px-6 py-4">
            <h3 class="text-lg font-bold text-gray-800">
                <i class="fas fa-exclamation-triangle text-red-500 mr-2"></i> Confirmer la suppression
            </h3>
            <button onclick="closeModal('deleteModal')" class="text-gray-400 hover:text-gray-500">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="p-6">
            <p class="text-gray-600 mb-4">Êtes-vous sûr de vouloir supprimer cet appartement ?</p>
            <p class="text-sm text-red-600 mb-4">
                <i class="fas fa-exclamation-circle mr-1"></i> Cette action est irréversible.
            </p>
            <div class="flex justify-end space-x-3">
                <button onclick="closeModal('deleteModal')" 
                        class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50">
                    Annuler
                </button>
                <button id="confirmDeleteBtn" 
                        class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 flex items-center">
                    <i class="fas fa-trash mr-2"></i> Supprimer
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    // Ouvrir automatiquement le modal d'ajout si le paramètre action=add est présent
    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        const action = urlParams.get('action');
        
        if (action === 'add') {
            openApartmentModal();
        }
    });

    // Fonctions pour gérer les modals
    function openModal(modalId) {
        document.getElementById(modalId).classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    function openApartmentModal(apartmentId = null) {
        const modal = document.getElementById('apartmentModal');
        const title = document.getElementById('modalTitle');
        const form = document.getElementById('apartmentForm');
        
        if (apartmentId) {
            // Mode édition
            title.innerHTML = '<i class="fas fa-edit text-blue-500 mr-2"></i> Modifier l\'appartement';
            // Simuler des données existantes
            form.querySelector('input[name="number"]').value = 'B1-05';
            form.querySelector('select[name="building_id"]').value = '1';
            form.querySelector('input[name="surface"]').value = '45';
            form.querySelector('input[name="monthly_rent"]').value = '750000';
            form.querySelector('select[name="status"]').value = 'libre';
        } else {
            // Mode création
            title.innerHTML = '<i class="fas fa-plus-circle text-blue-500 mr-2"></i> Ajouter un appartement';
            form.reset();
        }
        
        openModal('apartmentModal');
    }

    function editApartment(id) {
        openApartmentModal(id);
    }

    function openDeleteModal(id) {
        document.getElementById('confirmDeleteBtn').onclick = function() {
            // Simuler la suppression
            alert('Appartement supprimé avec succès !');
            closeModal('deleteModal');
        };
        openModal('deleteModal');
    }

    // Gestion du formulaire
  

    // Fermer le modal en cliquant en dehors
    document.addEventListener('click', function(event) {
        if (event.target === document.getElementById('apartmentModal')) {
            closeModal('apartmentModal');
        }
        if (event.target === document.getElementById('deleteModal')) {
            closeModal('deleteModal');
        }
    });
</script>
@endsection