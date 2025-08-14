@extends('layout')

@section('title', 'Gestion des Bâtiments')

@section('content')

<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <h2 class="text-2xl font-bold text-gray-800">
        <i class="fas fa-building text-blue-600 mr-2"></i> Gestion des Bâtiments
    </h2>
    <button onclick="openModal('addBuildingModal')" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center">
        <i class="fas fa-plus mr-2"></i> Ajouter un bâtiment
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
    <form method="GET" action="{{ route('batiments.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="md:col-span-2">
            <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Recherche</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
                <input type="text" id="search" name="search" value="{{ request('search') }}" placeholder="Nom, adresse, propriétaire..." 
                       class="pl-10 w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
            </div>
        </div>
        <div>
            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
            <select id="status" name="status" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                <option value="">Tous</option>
                <option value="actif" {{ request('status') == 'actif' ? 'selected' : '' }}>Actif</option>
                <option value="inactif" {{ request('status') == 'inactif' ? 'selected' : '' }}>Inactif</option>
            </select>
        </div>
        <div class="flex items-end">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md w-full flex items-center justify-center">
                <i class="fas fa-filter mr-2"></i> Filtrer
            </button>
        </div>
    </form>
</div>

<!-- Tableau des bâtiments -->
<div class="bg-white rounded-lg shadow overflow-hidden mb-8">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Adresse</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Appartements</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200" id="buildingsTable">
                @forelse($batiments as $batiment)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <a href="{{ route('batiments.show', ['code_batiment' => $batiment->code_batiment]) }}"
                                class="font-medium text-blue-600 hover:text-blue-800 flex items-center">
                                <i class="fas fa-building text-gray-400 mr-2"></i>
                                {{ $batiment->nom ?? $batiment->code_batiment }}
                            </a>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $batiment->adresse }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full mr-2">
                                    {{ $batiment->nombre_Appartements ?? $batiment->nombre_appartements ?? 0 }}
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 {{ $batiment->status == 'actif' ? 'bg-green-100 text-green-800' : 'bg-gray-200 text-gray-600' }} text-xs rounded-full">
                                {{ ucfirst($batiment->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <button title="Modifier"
                                    onclick="openEditModal('{{ $batiment->code_batiment }}', '{{ addslashes($batiment->nom ?? $batiment->code_batiment) }}', '{{ addslashes($batiment->proprietaire) }}', '{{ addslashes($batiment->adresse) }}', '{{ $batiment->nombre_Appartements ?? $batiment->nombre_appartements ?? 0 }}', '{{ $batiment->status }}', `{{ addslashes($batiment->description ?? '') }}`)"
                                    class="text-blue-600 hover:text-blue-900 mr-3">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button title="Supprimer"
                                    onclick="openDeleteModal('{{ $batiment->code_batiment }}', '{{ addslashes($batiment->nom ?? $batiment->code_batiment) }}')"
                                    class="text-red-600 hover:text-red-900">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-gray-500">Aucun bâtiment trouvé.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="bg-gray-50 px-6 py-3 flex items-center justify-between border-t border-gray-200">
        <div class="text-sm text-gray-500">
            {{ $batiments->firstItem() ?? 0 }} à {{ $batiments->lastItem() ?? 0 }} sur {{ $batiments->total() ?? 0 }} bâtiments
        </div>
        <div>
            {{ $batiments->links() }}
        </div>
    </div>
</div>

<!-- Modal Ajout -->

<div id="addBuildingModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl flex flex-col">
        <div class="flex justify-between items-center border-b px-6 py-4">
            <h3 class="text-lg font-bold text-gray-800">
                <i class="fas fa-plus-circle text-blue-500 mr-2"></i> Ajouter un bâtiment
            </h3>
            <button type="button" onclick="closeModal('addBuildingModal')" class="text-gray-400 hover:text-gray-500">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <form id="addBuildingForm" method="POST" action="{{ route('batiments.post') }}" class="p-6">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="buildingName" class="block text-sm font-medium text-gray-700 mb-1">Nom du bâtiment*</label>
                    <input type="text" id="buildingName" name="nom" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label for="buildingOwner" class="block text-sm font-medium text-gray-700 mb-1">Propriétaire*</label>
                    <input type="text" id="buildingOwner" name="proprietaire" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div >
                    <label for="buildingAddress" class="block text-sm font-medium text-gray-700 mb-1">Adresse complète*</label>
                    <input type="text" id="buildingAddress" name="adresse" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label for="buildingAgency" class="block text-sm font-medium text-gray-700 mb-1">Numéro d'agence*</label>
                    <input type="text" id="buildingAgency" name="code_agence" required placeholder="{{$numeroAgence}}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label for="buildingApartments" class="block text-sm font-medium text-gray-700 mb-1">Nombre d'appartements*</label>
                    <input type="number" id="buildingApartments" name="nombre_Appartements" min="1" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label for="buildingStatus" class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
                    <select id="buildingStatus" name="status"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                        <option value="actif">Actif</option>
                        <option value="inactif">Inactif</option>
                    </select>
                </div>
                <div class="md:col-span-2">
                    <label for="buildingDescription" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea id="buildingDescription" name="description" rows="3"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"></textarea>
                </div>
            </div>
            <div class="flex justify-end space-x-3 mt-6">
                <button type="button" onclick="closeModal('addBuildingModal')"
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

<!-- Modal Édition -->
<div id="editBuildingModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl flex flex-col">
        <div class="flex justify-between items-center border-b px-6 py-4">
            <h3 class="text-lg font-bold text-gray-800">
                <i class="fas fa-edit text-blue-500 mr-2"></i> Modifier le bâtiment
            </h3>
            <button type="button" onclick="closeModal('editBuildingModal')" class="text-gray-400 hover:text-gray-500">
                <i class="fas fa-times"></i>
            </button>
        </div>

                <form id="editBuildingForm" method="POST" action="#" class="p-6">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="editBuildingId" name="id" value="">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="editBuildingName" class="block text-sm font-medium text-gray-700 mb-1">Nom du bâtiment*</label>
                            <input type="text" id="editBuildingName" name="nom" required value=""
                                class="w-full px-3 py-2 border border-gray-300 rounded-md">
                        </div>
                        <div>
                            <label for="editBuildingOwner" class="block text-sm font-medium text-gray-700 mb-1">Propriétaire*</label>
                            <input type="text" id="editBuildingOwner" name="proprietaire" required value=""
                                class="w-full px-3 py-2 border border-gray-300 rounded-md">
                        </div>
                        <div class="md:col-span-2">
                            <label for="editBuildingAddress" class="block text-sm font-medium text-gray-700 mb-1">Adresse complète*</label>
                            <input type="text" id="editBuildingAddress" name="adresse" required value=""
                                class="w-full px-3 py-2 border border-gray-300 rounded-md">
                        </div>
                        <div>
                            <label for="editBuildingApartments" class="block text-sm font-medium text-gray-700 mb-1">Nombre d'appartements*</label>
                            <input type="number" id="editBuildingApartments" name="nombre_Appartements" min="1" required value=""
                                class="w-full px-3 py-2 border border-gray-300 rounded-md">
                        </div>
                        <div>
                            <label for="editBuildingStatus" class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
                            <select id="editBuildingStatus" name="status"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md">
                                <option value="actif">Actif</option>
                                <option value="inactif">Inactif</option>
                            </select>
                        </div>
                        <div class="md:col-span-2">
                            <label for="editBuildingDescription" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                            <textarea id="editBuildingDescription" name="description" rows="3"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md"></textarea>
                        </div>
                    </div>
                    <div class="flex justify-end space-x-3 mt-6">
                        <button type="button" onclick="closeModal('editBuildingModal')"
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

<!-- Modal Suppression -->
<div id="deleteBuildingModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-md flex flex-col">
        <div class="flex justify-between items-center border-b px-6 py-4">
            <h3 class="text-lg font-bold text-gray-800">
                <i class="fas fa-exclamation-triangle text-red-500 mr-2"></i> Confirmer la suppression
            </h3>
            <button type="button" onclick="closeModal('deleteBuildingModal')" class="text-gray-400 hover:text-gray-500">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="p-6">
            <p class="text-gray-600 mb-4">Êtes-vous sûr de vouloir supprimer le bâtiment <span id="buildingToDelete" class="font-semibold"></span> ?</p>
            <p class="text-sm text-red-600 mb-4"><i class="fas fa-exclamation-circle mr-1"></i> Cette action supprimera également tous les appartements associés et est irréversible.</p>
            <form id="deleteBuildingForm" method="POST" action="#">
                @csrf
                @method('DELETE')
                <input type="hidden" id="deleteBuildingId" name="id">
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeModal('deleteBuildingModal')"
                        class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        Annuler
                    </button>
                    <button type="submit"
                        class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 flex items-center">
                        <i class="fas fa-trash mr-2"></i> Supprimer définitivement
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openModal(modalId) {
    document.getElementById(modalId).classList.remove('hidden');
    document.getElementById(modalId).classList.add('flex');
    document.body.classList.add('overflow-hidden');
}
function closeModal(modalId) {
    document.getElementById(modalId).classList.add('hidden');
    document.getElementById(modalId).classList.remove('flex');
    document.body.classList.remove('overflow-hidden');
}

/**
 * Préremplit et ouvre le modal d'édition.
 */
function openEditModal(id, nom, proprietaire, adresse, nbAppartements, status, description) {
    document.getElementById('editBuildingId').value = id;
    document.getElementById('editBuildingName').value = nom;
    document.getElementById('editBuildingOwner').value = proprietaire;
    document.getElementById('editBuildingAddress').value = adresse;
    document.getElementById('editBuildingApartments').value = nbAppartements;
    document.getElementById('editBuildingStatus').value = status;
    document.getElementById('editBuildingDescription').value = description;
    openModal('editBuildingModal');
}

/**
 * Préremplit et ouvre le modal de suppression.
 */
function openDeleteModal(id, nom) {
    document.getElementById('deleteBuildingId').value = id;
    document.getElementById('buildingToDelete').textContent = nom;
    openModal('deleteBuildingModal');
}

//Bonne pratique: tu traites les formulaires avec action backend (POST/PATCH/DELETE) et vérifies la sécurité CSRF de Laravel.
</script>
@endsection