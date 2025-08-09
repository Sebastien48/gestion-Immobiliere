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

<!-- Filtres et recherche -->
<div class="bg-white rounded-lg shadow p-4 mb-6">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="md:col-span-2">
            <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Recherche</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
                <input type="text" id="search" placeholder="Nom, adresse, propriétaire..." 
                       class="pl-10 w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
            </div>
        </div>
        <div>
            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
            <select id="status" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                <option value="all">Tous</option>
                <option value="active">Actifs</option>
                <option value="inactive">Inactifs</option>
            </select>
        </div>
        <div class="flex items-end">
            <button onclick="applyFilters()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md w-full flex items-center justify-center">
                <i class="fas fa-filter mr-2"></i> Filtrer
            </button>
        </div>
    </div>
</div>

<!-- Tableau des bâtiments -->
<div class="bg-white rounded-lg shadow overflow-hidden mb-8">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" onclick="sortTable('name')">
                        <div class="flex items-center">
                            Nom
                            <i class="fas fa-sort ml-1 text-gray-400"></i>
                        </div>
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Adresse</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Appartements</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200" id="buildingsTable">
                <!-- Rempli dynamiquement par JS -->
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <a href="{{ route('batiments.show', 1) }}" class="font-medium text-blue-600 hover:text-blue-800 flex items-center">
                            <i class="fas fa-building text-gray-400 mr-2"></i> Résidence Yasmina
                        </a>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        Avenue 15 rue princesse, 00225 Abiadjan
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full mr-2">24</span>
                            <span class="text-xs text-gray-500">(18 occupés)</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Actif</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <button onclick="openModal('editBuildingModal', 1)" class="text-blue-600 hover:text-blue-900 mr-3" title="Modifier">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button onclick="openModal('deleteBuildingModal', 1)" class="text-red-600 hover:text-red-900" title="Supprimer">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
                <!-- Plus de lignes... -->
            </tbody>
        </table>
    </div>
    <!-- Pagination -->
    <div class="bg-gray-50 px-6 py-3 flex items-center justify-between border-t border-gray-200">
        <div class="text-sm text-gray-500">
            Affichage de <span id="startItem">1</span> à <span id="endItem">5</span> sur <span id="totalItems">12</span> bâtiments
        </div>
        <nav class="flex space-x-2">
            <button id="prevPage" class="px-3 py-1 border border-gray-300 rounded-md text-gray-700 bg-white cursor-not-allowed" disabled>
                <i class="fas fa-chevron-left"></i>
            </button>
            <button id="nextPage" class="px-3 py-1 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50">
                <i class="fas fa-chevron-right"></i>
            </button>
        </nav>
    </div>
</div>

<!-- Modal Ajout -->
<div id="addBuildingModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl">
        <div class="flex justify-between items-center border-b px-6 py-4">
            <h3 class="text-lg font-bold text-gray-800">
                <i class="fas fa-plus-circle text-blue-500 mr-2"></i> Ajouter un bâtiment
            </h3>
            <button onclick="closeModal('addBuildingModal')" class="text-gray-400 hover:text-gray-500">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="addBuildingForm" class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="buildingName" class="block text-sm font-medium text-gray-700 mb-1">Nom du bâtiment*</label>
                    <input type="text" id="buildingName" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label for="buildingOwner" class="block text-sm font-medium text-gray-700 mb-1">Propriétaire*</label>
                    <input type="text" id="buildingOwner" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div class="md:col-span-2">
                    <label for="buildingAddress" class="block text-sm font-medium text-gray-700 mb-1">Adresse complète*</label>
                    <input type="text" id="buildingAddress" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label for="buildingApartments" class="block text-sm font-medium text-gray-700 mb-1">Nombre d'appartements*</label>
                    <input type="number" id="buildingApartments" min="1" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label for="buildingStatus" class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
                    <select id="buildingStatus" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                        <option value="active">Actif</option>
                        <option value="inactive">Inactif</option>
                    </select>
                </div>
                <div class="md:col-span-2">
                    <label for="buildingDescription" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea id="buildingDescription" rows="3" 
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
<div id="editBuildingModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl">
        <div class="flex justify-between items-center border-b px-6 py-4">
            <h3 class="text-lg font-bold text-gray-800">
                <i class="fas fa-edit text-blue-500 mr-2"></i> Modifier le bâtiment
            </h3>
            <button onclick="closeModal('editBuildingModal')" class="text-gray-400 hover:text-gray-500">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="editBuildingForm" class="p-6">
            <input type="hidden" id="editBuildingId">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nom du bâtiment*</label>
                    <input type="text" id="editBuildingName" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Propriétaire*</label>
                    <input type="text" id="editBuildingOwner" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Adresse complète*</label>
                    <input type="text" id="editBuildingAddress" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nombre d'appartements*</label>
                    <input type="number" id="editBuildingApartments" min="1" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
                    <select id="editBuildingStatus" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                        <option value="active">Actif</option>
                        <option value="inactive">Inactif</option>
                    </select>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea id="editBuildingDescription" rows="3" 
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
<div id="deleteBuildingModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-md">
        <div class="flex justify-between items-center border-b px-6 py-4">
            <h3 class="text-lg font-bold text-gray-800">
                <i class="fas fa-exclamation-triangle text-red-500 mr-2"></i> Confirmer la suppression
            </h3>
            <button onclick="closeModal('deleteBuildingModal')" class="text-gray-400 hover:text-gray-500">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="p-6">
            <p class="text-gray-600 mb-4">Êtes-vous sûr de vouloir supprimer le bâtiment <span id="buildingToDelete" class="font-semibold"></span> ?</p>
            <p class="text-sm text-red-600 mb-4"><i class="fas fa-exclamation-circle mr-1"></i> Cette action supprimera également tous les appartements associés et est irréversible.</p>
            <div class="flex justify-end space-x-3">
                <button onclick="closeModal('deleteBuildingModal')" 
                        class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50">
                    Annuler
                </button>
                <button onclick="confirmDelete()" 
                        class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 flex items-center">
                    <i class="fas fa-trash mr-2"></i> Supprimer définitivement
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    // Données simulées
    const buildingsData = [
        {
            id: 1,
            name: "Résidence Yasmina",
            address: "Avenue 15 rue princesse, 00225 Abiadjan",
            owner: "SCI Yasmina",
            apartments: 24,
            occupied: 18,
            status: "active",
            description: "Résidence haut de gamme avec espace vert"
        },
        // Plus de données...
    ];

    // Gestion des modals
    function openModal(modalId, buildingId = null) {
        if (buildingId && modalId === 'deleteBuildingModal') {
            const building = buildingsData.find(b => b.id === buildingId);
            document.getElementById('buildingToDelete').textContent = building.name;
        }else if (modalId === 'editBuildingModal') {
            const building = buildingsData.find(b => b.id === buildingId);
            if (building) {
                document.getElementById('editBuildingId').value = building.id;
                document.getElementById('editBuildingName').value = building.name;
                document.getElementById('editBuildingOwner').value = building.owner;
                document.getElementById('editBuildingAddress').value = building.address;
                document.getElementById('editBuildingApartments').value = building.apartments;
                document.getElementById('editBuildingStatus').value = building.status;
                document.getElementById('editBuildingDescription').value = building.description || '';
            }
        }
        document.getElementById(modalId).classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    // Gestion du formulaire
    document.getElementById('addBuildingForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Validation
        const requiredFields = ['buildingName', 'buildingOwner', 'buildingAddress', 'buildingApartments'];
        let isValid = true;
        
        requiredFields.forEach(fieldId => {
            const field = document.getElementById(fieldId);
            if (!field.value.trim()) {
                field.classList.add('border-red-500');
                isValid = false;
            } else {
                field.classList.remove('border-red-500');
            }
        });

        if (!isValid) {
            showAlert('error', 'Veuillez remplir tous les champs obligatoires');
            return;
        }

        // Simulation d'enregistrement
        const newBuilding = {
            name: document.getElementById('buildingName').value,
            address: document.getElementById('buildingAddress').value,
            owner: document.getElementById('buildingOwner').value,
            apartments: document.getElementById('buildingApartments').value,
            status: document.getElementById('buildingStatus').value,
            description: document.getElementById('buildingDescription').value
        };

        console.log("Nouveau bâtiment:", newBuilding);
        closeModal('addBuildingModal');
        showAlert('success', 'Bâtiment enregistré avec succès!');
        
        // Ici: AJAX pour sauvegarder en base + actualiser le tableau
    });

    // Mettre à jour la fonction openModal
    function openModal(modalId, buildingId = null) {
        if (buildingId) {
            if (modalId === 'deleteBuildingModal') {
                const building = buildingsData.find(b => b.id === buildingId);
                document.getElementById('buildingToDelete').textContent = building.name;
            } else if (modalId === 'editBuildingModal') {
                const building = buildingsData.find(b => b.id === buildingId);
                if (building) {
                    document.getElementById('editBuildingId').value = building.id;
                    document.getElementById('editBuildingName').value = building.name;
                    document.getElementById('editBuildingOwner').value = building.owner;
                    document.getElementById('editBuildingAddress').value = building.address;
                    document.getElementById('editBuildingApartments').value = building.apartments;
                    document.getElementById('editBuildingStatus').value = building.status;
                    document.getElementById('editBuildingDescription').value = building.description || '';
                }
            }
        }
        document.getElementById(modalId).classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    // Gestion du formulaire d'édition
    document.getElementById('editBuildingForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const buildingId = document.getElementById('editBuildingId').value;
        const updatedBuilding = {
            name: document.getElementById('editBuildingName').value,
            owner: document.getElementById('editBuildingOwner').value,
            address: document.getElementById('editBuildingAddress').value,
            apartments: document.getElementById('editBuildingApartments').value,
            status: document.getElementById('editBuildingStatus').value,
            description: document.getElementById('editBuildingDescription').value
        };

        console.log("Mise à jour du bâtiment:", buildingId, updatedBuilding);
        closeModal('editBuildingModal');
        showAlert('success', 'Bâtiment mis à jour avec succès!');
        
        // Ici: AJAX pour sauvegarder en base + actualiser le tableau
    });

    function confirmDelete() {
        // Simulation suppression
        console.log("Bâtiment supprimé");
        closeModal('deleteBuildingModal');
        showAlert('success', 'Bâtiment supprimé avec succès');
        
        // Ici: AJAX pour suppression réelle + actualiser le tableau
    }

    function applyFilters() {
        const searchTerm = document.getElementById('search').value.toLowerCase();
        const statusFilter = document.getElementById('status').value;
        
        // Filtrage simulé
        const filtered = buildingsData.filter(building => {
            const matchesSearch = building.name.toLowerCase().includes(searchTerm) || 
                                building.address.toLowerCase().includes(searchTerm) ||
                                building.owner.toLowerCase().includes(searchTerm);
            
            const matchesStatus = statusFilter === 'all' || building.status === statusFilter;
            
            return matchesSearch && matchesStatus;
        });
        
        console.log("Résultats filtrés:", filtered);
        showAlert('info', `Filtre appliqué: ${filtered.length} résultats`);
    }

    function showAlert(type, message) {
        const alertDiv = document.createElement('div');
        alertDiv.className = `fixed top-4 right-4 p-4 rounded-md shadow-lg text-white ${
            type === 'error' ? 'bg-red-500' : 
            type === 'success' ? 'bg-green-500' : 'bg-blue-500'
        }`;
        alertDiv.innerHTML = `
            <div class="flex items-center">
                <i class="fas ${type === 'error' ? 'fa-exclamation-circle' : type === 'success' ? 'fa-check-circle' : 'fa-info-circle'} mr-2"></i>
                <span>${message}</span>
            </div>
        `;
        document.body.appendChild(alertDiv);
        
        setTimeout(() => {
            alertDiv.remove();
        }, 3000);
    }

    // Tri du tableau
    function sortTable(column) {
        console.log(`Tri par ${column}`);
        // Implémentation du tri...
    }

    // Initialisation
    document.addEventListener('DOMContentLoaded', function() {
        // Ici: Chargement initial des données via AJAX
    });
</script>
@endsection