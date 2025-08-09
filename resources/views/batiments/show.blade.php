@extends('layout')

@section('title', 'Détails du Bâtiment')

@section('content')
<!-- En-tête avec boutons d'action -->
<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <h2 class="text-2xl font-bold text-gray-800 flex items-center">
            <i class="fas fa-building text-blue-600 mr-3"></i>
            <span id="buildingName">Résidence Yasmina</span>
        </h2>
        <p class="text-gray-600 mt-1">
            <i class="fas fa-map-marker-alt text-gray-400 mr-1"></i>
            <span id="buildingAddress">Avenue 15 rue princesse, 00225 Abiadjan</span>
        </p>
    </div>
    <div class="flex space-x-3">
        <button onclick="openModal('editBuildingModal')" 
            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center">
            <i class="fas fa-edit mr-2"></i> Modifier
        </button>
        <button onclick="window.location.href='/batiments'" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-lg flex items-center">
            <i class="fas fa-arrow-left mr-2"></i> Retour
        </button>
    </div>
</div>

<!-- Cartes d'information -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <!-- Carte Informations de base -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden border-l-4 border-blue-500">
        <div class="p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                <i class="fas fa-info-circle text-blue-500 mr-2"></i> Informations de base
            </h3>
            <ul class="space-y-3">
                <li class="flex justify-between">
                    <span class="text-gray-600">Propriétaire:</span>
                    <span class="font-medium" id="buildingOwner">SCI Yasmina</span>
                </li>
                <li class="flex justify-between">
                    <span class="text-gray-600">Appartements:</span>
                    <span>
                        <span class="font-medium" id="buildingApartments">24</span>
                        <span class="text-sm text-gray-500 ml-1">(18 occupés)</span>
                    </span>
                </li>
                <li class="flex justify-between">
                    <span class="text-gray-600">Date création:</span>
                    <span class="font-medium">15/06/2018</span>
                </li>
                <li class="flex justify-between">
                    <span class="text-gray-600">Statut:</span>
                    <span id="buildingStatus" class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Actif</span>
                </li>
            </ul>
        </div>
    </div>

    <!-- Carte Statistiques -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden border-l-4 border-green-500">
        <div class="p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                <i class="fas fa-chart-bar text-green-500 mr-2"></i> Statistiques
            </h3>
            <ul class="space-y-3">
                <li class="flex justify-between">
                    <span class="text-gray-600">Taux d'occupation:</span>
                    <div class="w-1/2 bg-gray-200 rounded-full h-2.5 mt-1">
                        <div class="bg-green-600 h-2.5 rounded-full" style="width: 75%"></div>
                    </div>
                </li>
                <li class="flex justify-between">
                    <span class="text-gray-600">Loyer moyen:</span>
                    <span class="font-medium">750 mille</span>
                </li>
                <li class="flex justify-between">
                    <span class="text-gray-600">Retards ce mois:</span>
                    <span class="font-medium">2</span>
                </li>
                <li class="flex justify-between">
                    <span class="text-gray-600">Dernier paiement:</span>
                    <span class="font-medium">05/07/2023</span>
                </li>
            </ul>
        </div>
    </div>

    <!-- Carte Actions rapides -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden border-l-4 border-purple-500">
        <div class="p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                <i class="fas fa-bolt text-purple-500 mr-2"></i> Actions rapides
            </h3>
            <div class="space-y-3">
                <button onclick="window.location.href='/appartements?batiment_id=1&action=add'" 
                        class="w-full flex items-center justify-between p-3 hover:bg-purple-50 rounded-lg transition">
                    <span class="text-purple-600">
                        <i class="fas fa-plus-circle mr-2"></i> Ajouter un appartement
                    </span>
                    <i class="fas fa-chevron-right text-purple-400"></i>
                </button>
                
                <button onclick="window.location.href='/quittances?batiment_id=1'" 
                        class="w-full flex items-center justify-between p-3 hover:bg-purple-50 rounded-lg transition">
                    <span class="text-purple-600">
                        <i class="fas fa-receipt mr-2"></i> Voir les quittances
                    </span>
                    <i class="fas fa-chevron-right text-purple-400"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Section Description -->
<div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
    <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-medium text-gray-900 flex items-center">
            <i class="fas fa-align-left text-blue-500 mr-2"></i> Description
        </h3>
    </div>
    <div class="p-6">
        <p id="buildingDescription" class="text-gray-600">
            Résidence haut de gamme située dans le 16ème arrondissement de Paris. 
            Bâtiment de 5 étages avec ascenseur, comprenant 24 appartements allant 
            du studio au 3 pièces. Espace vert commun et local à vélos sécurisé.
        </p>
    </div>
</div>

<!-- Bouton Voir les appartements -->
<div class="text-center mb-8">
    <button onclick="window.location.href='/appartements?batiment_id=1'" 
            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition-colors">
        <i class="fas fa-home mr-2"></i> Voir les appartements de ce bâtiment
    </button>
</div>

<!-- Modal Modification Bâtiment -->
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
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nom*</label>
                    <input type="text" name="name" value="Résidence Yasmina" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Adresse*</label>
                    <input type="text" name="address" value="Avenue 15 rue princesse, 00225 Abiadjan" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Propriétaire*</label>
                    <input type="text" name="owner" value="SCI Yasmina" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Statut*</label>
                    <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                        <option value="active" selected>Actif</option>
                        <option value="inactive">Inactif</option>
                    </select>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea name="description" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md">Résidence haut de gamme située dans le 16ème arrondissement de Paris. Bâtiment de 5 étages avec ascenseur, comprenant 24 appartements allant du studio au 3 pièces. Espace vert commun et local à vélos sécurisé.</textarea>
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

<script>
    // Fonctions pour gérer les modals
    function openModal(modalId) {
        document.getElementById(modalId).classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    // Gestion du formulaire de modification
    document.getElementById('editBuildingForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Simuler la mise à jour des données
        const formData = new FormData(this);
        const data = Object.fromEntries(formData);
        
        document.getElementById('buildingName').textContent = data.name;
        document.getElementById('buildingAddress').textContent = data.address;
        document.getElementById('buildingOwner').textContent = data.owner;
        document.getElementById('buildingDescription').textContent = data.description;
        
        const statusElement = document.getElementById('buildingStatus');
        statusElement.textContent = data.status === 'active' ? 'Actif' : 'Inactif';
        if (data.status === 'active') {
            statusElement.className = 'px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full';
        } else {
            statusElement.className = 'px-2 py-1 bg-gray-100 text-gray-800 text-xs rounded-full';
        }
        
        closeModal('editBuildingModal');
        
        // Simuler une notification de succès
        alert('Bâtiment mis à jour avec succès !');
    });
</script>
@endsection