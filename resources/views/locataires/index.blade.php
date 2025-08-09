@extends('layout')

@section('title', 'Gestion des Locataires')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <h2 class="text-2xl font-bold text-gray-800">
        <i class="fas fa-users text-blue-600 mr-2"></i> Gestion des Locataires
    </h2>
    <button onclick="openModal('addTenantModal')" 
        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center">
        <i class="fas fa-plus mr-2"></i> Ajouter un locataire
    </button>
</div>

<!-- Filtres et recherche -->
<div class="bg-white rounded-lg shadow p-4 mb-6">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <!-- Filtre par statut -->
        <div>
            <label for="statusFilter" class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
            <select id="statusFilter" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                <option value="">Tous</option>
                <option value="avec-logement">Avec logement</option>
                <option value="sans-logement">Sans logement</option>
            </select>
        </div>
        
        <!-- Filtre par bâtiment -->
        <div>
            <label for="buildingFilter" class="block text-sm font-medium text-gray-700 mb-1">Bâtiment</label>
            <select id="buildingFilter" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                <option value="">Tous les bâtiments</option>
                <option value="1">Résidence Yasmina</option>
                <option value="2">Immeuble Bellevue</option>
            </select>
        </div>
        
        <!-- Recherche -->
        <div class="md:col-span-2">
            <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Recherche</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
                <input type="text" id="search" placeholder="Nom, téléphone, email..." 
                       class="pl-10 w-full px-3 py-2 border border-gray-300 rounded-md">
            </div>
        </div>
    </div>
</div>

<!-- Tableau des locataires -->
<div class="bg-white rounded-lg shadow overflow-hidden mb-8">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Nom & Prénom
                    </th>
                    <th scope="col" class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Contact
                    </th>
                    <th scope="col" class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Appartement
                    </th>
                    <th scope="col" class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Statut
                    </th>
                    <th scope="col" class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <!-- Exemple de locataire avec logement -->
                <tr>
                    <td class="px-4 sm:px-6 py-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center text-blue-600">
                                <i class="fas fa-user"></i>
                            </div>
                            <div class="ml-4">
                                <a href="/locataires/1" class="font-medium text-blue-600 hover:text-blue-800">KOUADIO Amani</a>
                                <div class="text-sm text-gray-500">CI-12345678</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">amanikouadio@example.com</div>
                        <div class="text-sm text-gray-500">+225 07 08 09 10 11</div>
                    </td>
                    <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                        <a href="/appartements/1" class="text-blue-600 hover:text-blue-800">B1-05</a>
                        <div class="text-sm text-gray-500">Résidence Yasmina</div>
                    </td>
                    <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                        <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Locataire</span>
                    </td>
                    <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex flex-col sm:flex-row gap-2">
                            <button onclick="assignApartment(1)" class="text-purple-600 hover:text-purple-900" title="Attribuer un logement">
                                <i class="fas fa-home"></i>
                                <span class="sm:hidden">Attribuer</span>
                            </button>
                            <button onclick="editTenant(1)" class="text-blue-600 hover:text-blue-900">
                                <i class="fas fa-edit"></i>
                                <span class="sm:hidden">Modifier</span>
                            </button>
                            <button onclick="deleteTenant(1)" class="text-red-600 hover:text-red-900">
                                <i class="fas fa-trash"></i>
                                <span class="sm:hidden">Supprimer</span>
                            </button>
                        </div>
                    </td>
                </tr>
                
                <!-- Exemple de locataire sans logement -->
                <tr>
                    <td class="px-4 sm:px-6 py-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10 bg-gray-100 rounded-full flex items-center justify-center text-gray-600">
                                <i class="fas fa-user"></i>
                            </div>
                            <div class="ml-4">
                                <a href="/locataires/2" class="font-medium text-blue-600 hover:text-blue-800">TRAORE Fatou</a>
                                <div class="text-sm text-gray-500">CI-87654321</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">fatoutraore@example.com</div>
                        <div class="text-sm text-gray-500">+225 01 02 03 04 05</div>
                    </td>
                    <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        Aucun logement
                    </td>
                    <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                        <span class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs rounded-full">En attente</span>
                    </td>
                    <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex flex-col sm:flex-row gap-2">
                            <button onclick="assignApartment(2)" class="text-purple-600 hover:text-purple-900" title="Attribuer un logement">
                                <i class="fas fa-home"></i>
                                <span class="sm:hidden">Attribuer</span>
                            </button>
                            <button onclick="editTenant(2)" class="text-blue-600 hover:text-blue-900">
                                <i class="fas fa-edit"></i>
                                <span class="sm:hidden">Modifier</span>
                            </button>
                            <button onclick="deleteTenant(2)" class="text-red-600 hover:text-red-900">
                                <i class="fas fa-trash"></i>
                                <span class="sm:hidden">Supprimer</span>
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    <div class="bg-gray-50 px-4 sm:px-6 py-3 flex items-center justify-between border-t border-gray-200">
        <div class="text-sm text-gray-500">
            Affichage de <span>1</span> à <span>2</span> sur <span>2</span> locataires
        </div>
        <nav class="flex space-x-2">
            <button class="px-3 py-1 border border-gray-300 rounded-md text-gray-700 bg-white cursor-not-allowed" disabled>
                <i class="fas fa-chevron-left"></i>
            </button>
            <button class="px-3 py-1 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50">
                <i class="fas fa-chevron-right"></i>
            </button>
        </nav>
    </div>
</div>

<!-- Modal Ajout de locataire -->
<div id="addTenantModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4 sm:p-6">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl mx-4 sm:mx-6 overflow-y-auto" style="max-height: 90vh;">
        <div class="flex justify-between items-center border-b px-4 sm:px-6 py-4 sticky top-0 bg-white z-10">
            <h3 class="text-lg font-bold text-gray-800">
                <i class="fas fa-user-plus text-blue-500 mr-2"></i> Ajouter un locataire
            </h3>
            <button onclick="closeModal('addTenantModal')" class="text-gray-400 hover:text-gray-500 text-xl">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="addTenantForm" class="p-4 sm:p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nom*</label>
                    <input type="text" name="last_name" required class="w-full px-3 py-2 border border-gray-300 rounded-md">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Prénom*</label>
                    <input type="text" name="first_name" required class="w-full px-3 py-2 border border-gray-300 rounded-md">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">CNI/Passport*</label>
                    <input type="file" name="identity_number" required class="w-full px-3 py-2 border border-gray-300 rounded-md">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Date de naissance</label>
                    <input type="date" name="birth_date" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Téléphone*</label>
                    <input type="tel" name="phone" required class="w-full px-3 py-2 border border-gray-300 rounded-md">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Adresse</label>
                    <input type="text" name="address" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Profession</label>
                    <input type="text" name="profession" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nationalité</label>
                    <input type="text" name="nationality" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                </div>
            </div>
            <div class="flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-3 mt-6">
                <button type="button" onclick="closeModal('addTenantModal')" 
                        class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50 order-2 sm:order-1">
                    Annuler
                </button>
                <button type="submit" 
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 flex items-center justify-center order-1 sm:order-2 mb-3 sm:mb-0">
                    <i class="fas fa-save mr-2"></i> Enregistrer
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Modification de locataire -->
<div id="editTenantModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4 sm:p-6">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl mx-4 sm:mx-6 overflow-y-auto" style="max-height: 90vh;">
        <div class="flex justify-between items-center border-b px-4 sm:px-6 py-4 sticky top-0 bg-white z-10">
            <h3 class="text-lg font-bold text-gray-800">
                <i class="fas fa-user-edit text-blue-500 mr-2"></i> Modifier le locataire
            </h3>
            <button onclick="closeModal('editTenantModal')" class="text-gray-400 hover:text-gray-500 text-xl">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="editTenantForm" class="p-4 sm:p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nom*</label>
                    <input type="text" name="last_name" value="KOUADIO" required class="w-full px-3 py-2 border border-gray-300 rounded-md">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Prénom*</label>
                    <input type="text" name="first_name" value="Amani" required class="w-full px-3 py-2 border border-gray-300 rounded-md">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">CNI/Passport*</label>
                    <input type="file" name="identity_number" value="CI-12345678" required class="w-full px-3 py-2 border border-gray-300 rounded-md">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Date de naissance</label>
                    <input type="date" name="birth_date" value="1985-06-15" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Téléphone*</label>
                    <input type="tel" name="phone" value="0708091011" required class="w-full px-3 py-2 border border-gray-300 rounded-md">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" value="amanikouadio@example.com" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Adresse</label>
                    <input type="text" name="address" value="Rue des Jardins, Cocody" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Profession</label>
                    <input type="text" name="profession" value="Commercial" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nationalité</label>
                    <input type="text" name="nationality" value="Ivoirienne" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                </div>
            </div>
            <div class="flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-3 mt-6">
                <button type="button" onclick="closeModal('editTenantModal')" 
                        class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50 order-2 sm:order-1">
                    Annuler
                </button>
                <button type="submit" 
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 flex items-center justify-center order-1 sm:order-2 mb-3 sm:mb-0">
                    <i class="fas fa-save mr-2"></i> Enregistrer
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Attribution d'appartement -->
<div id="assignApartmentModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4 sm:p-6">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl mx-4 sm:mx-6 overflow-y-auto" style="max-height: 90vh;">
        <div class="flex justify-between items-center border-b px-4 sm:px-6 py-4 sticky top-0 bg-white z-10">
            <h3 class="text-lg font-bold text-gray-800">
                <i class="fas fa-home text-purple-500 mr-2"></i> Attribuer un logement
            </h3>
            <button onclick="closeModal('assignApartmentModal')" class="text-gray-400 hover:text-gray-500 text-xl">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="assignApartmentForm" class="p-4 sm:p-6">
            <div class="mb-4">
                <h4 class="font-medium text-gray-900 mb-2">Locataire: <span id="tenantName" class="font-bold">KOUADIO Amani</span></h4>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Bâtiment*</label>
                    <select id="buildingSelect" class="w-full px-3 py-2 border border-gray-300 rounded-md" onchange="updateAvailableApartments()">
                        <option value="">Sélectionner un bâtiment</option>
                        <option value="1">Résidence Yasmina</option>
                        <option value="2">Immeuble Bellevue</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Appartement*</label>
                    <select name="apartment_id" id="apartmentSelect" class="w-full px-3 py-2 border border-gray-300 rounded-md" disabled>
                        <option value="">Sélectionnez d'abord un bâtiment</option>
                    </select>
                </div>
            </div>
            
            <div class="border-t border-gray-200 pt-4 mb-4">
                <h4 class="font-medium text-gray-900 mb-4">Détails du contrat</h4>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 sm:gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Date de début*</label>
                        <input type="date" name="start_date" required 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Durée (mois)*</label>
                        <input type="number" name="duration" min="1" value="12" required 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Loyer mensuel*</label>
                        <input type="number" name="monthly_rent" id="monthlyRent" required 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md" readonly>
                    </div>
                </div>
                
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Conditions spéciales</label>
                    <textarea name="special_conditions" rows="2" class="w-full px-3 py-2 border border-gray-300 rounded-md"></textarea>
                </div>
            </div>
            
            <div class="flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-3 mt-6">
                <button type="button" onclick="closeModal('assignApartmentModal')" 
                        class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50 order-2 sm:order-1">
                    Annuler
                </button>
                <button type="submit" 
                        class="px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700 flex items-center justify-center order-1 sm:order-2 mb-3 sm:mb-0">
                    <i class="fas fa-save mr-2"></i> Enregistrer la location
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Suppression -->
<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-md mx-4">
        <div class="flex justify-between items-center border-b px-4 sm:px-6 py-4">
            <h3 class="text-lg font-bold text-gray-800">
                <i class="fas fa-exclamation-triangle text-red-500 mr-2"></i> Confirmer la suppression
            </h3>
            <button onclick="closeModal('deleteModal')" class="text-gray-400 hover:text-gray-500 text-xl">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="p-4 sm:p-6">
            <p class="text-gray-600 mb-4">Êtes-vous sûr de vouloir supprimer ce locataire ?</p>
            <p class="text-sm text-red-600 mb-4">
                <i class="fas fa-exclamation-circle mr-1"></i> Cette action est irréversible.
            </p>
            <div class="flex flex-col sm:flex-row justify-end space-y-2 sm:space-y-0 sm:space-x-3">
                <button onclick="closeModal('deleteModal')" 
                        class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50 order-2 sm:order-1">
                    Annuler
                </button>
                <button id="confirmDeleteBtn" 
                        class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 flex items-center justify-center order-1 sm:order-2">
                    <i class="fas fa-trash mr-2"></i> Supprimer
                </button>
            </div>
        </div>
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

    // Ajout de locataire
    document.getElementById('addTenantForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        const data = Object.fromEntries(formData);
        console.log('Nouveau locataire:', data);
        alert('Locataire ajouté avec succès !');
        closeModal('addTenantModal');
    });

    // Modification de locataire
    function editTenant(id) {
        // Pré-remplir avec les données du locataire
        openModal('editTenantModal');
    }

    document.getElementById('editTenantForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        const data = Object.fromEntries(formData);
        console.log('Locataire modifié:', data);
        alert('Locataire modifié avec succès !');
        closeModal('editTenantModal');
    });

    // Attribution d'appartement
    function assignApartment(tenantId) {
        // Simuler le chargement des données du locataire
        const tenantName = tenantId === 1 ? 'KOUADIO Amani' : 'TRAORE Fatou';
        document.getElementById('tenantName').textContent = tenantName;
        
        openModal('assignApartmentModal');
    }

    // Mise à jour des appartements disponibles
    function updateAvailableApartments() {
        const buildingSelect = document.getElementById('buildingSelect');
        const apartmentSelect = document.getElementById('apartmentSelect');
        
        if (buildingSelect.value) {
            // Simuler le chargement des appartements disponibles
            apartmentSelect.innerHTML = '';
            
            if (buildingSelect.value === '1') {
                // Appartements de la Résidence Yasmina
                const options = [
                    {id: 1, number: 'B1-05', rent: 750000, status: 'libre'},
                    {id: 2, number: 'B1-07', rent: 650000, status: 'occupe'},
                    {id: 3, number: 'B2-12', rent: 850000, status: 'libre'}
                ];
                
                options.forEach(opt => {
                    const option = document.createElement('option');
                    option.value = opt.id;
                    option.textContent = `${opt.number} - ${opt.rent.toLocaleString()} FCFA`;
                    option.dataset.rent = opt.rent;
                    option.disabled = opt.status !== 'libre';
                    if (opt.status !== 'libre') {
                        option.textContent += ' (Occupé)';
                    }
                    apartmentSelect.appendChild(option);
                });
            } else {
                // Appartements de l'Immeuble Bellevue
                const options = [
                    {id: 4, number: 'A-03', rent: 550000, status: 'libre'},
                    {id: 5, number: 'B-08', rent: 600000, status: 'libre'}
                ];
                
                options.forEach(opt => {
                    const option = document.createElement('option');
                    option.value = opt.id;
                    option.textContent = `${opt.number} - ${opt.rent.toLocaleString()} FCFA`;
                    option.dataset.rent = opt.rent;
                    apartmentSelect.appendChild(option);
                });
            }
            
            apartmentSelect.disabled = false;
        } else {
            apartmentSelect.innerHTML = '<option value="">Sélectionnez d\'abord un bâtiment</option>';
            apartmentSelect.disabled = true;
            document.getElementById('monthlyRent').value = '';
        }
    }

    // Mettre à jour le loyer quand un appartement est sélectionné
    document.getElementById('apartmentSelect').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        if (selectedOption && selectedOption.dataset.rent) {
            document.getElementById('monthlyRent').value = selectedOption.dataset.rent;
        } else {
            document.getElementById('monthlyRent').value = '';
        }
    });

    // Gestion du formulaire d'attribution
    document.getElementById('assignApartmentForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Vérifier si l'appartement est disponible
        const apartmentSelect = document.getElementById('apartmentSelect');
        const selectedOption = apartmentSelect.options[apartmentSelect.selectedIndex];
        
        if (selectedOption.disabled) {
            alert('Cet appartement est déjà occupé. Veuillez en sélectionner un autre.');
            return;
        }
        
        // Vérifier la date de début
        const startDate = new Date(this.start_date.value);
        const today = new Date();
        today.setHours(0, 0, 0, 0);
        
        if (startDate < today) {
            alert('La date de début ne peut pas être antérieure à la date actuelle.');
            return;
        }
        
        // Simuler l'enregistrement
        const formData = new FormData(this);
        const data = Object.fromEntries(formData);
        console.log('Contrat de location:', data);
        
        closeModal('assignApartmentModal');
        alert('Location enregistrée avec succès ! Le locataire a été attribué à l\'appartement.');
    });

    // Gestion de la suppression
    function deleteTenant(id) {
        document.getElementById('confirmDeleteBtn').onclick = function() {
            // Simuler la suppression
            alert(`Locataire ${id} supprimé avec succès !`);
            closeModal('deleteModal');
        };
        openModal('deleteModal');
    }

    // Fermer les modals en cliquant en dehors
    document.addEventListener('click', function(event) {
        if (event.target === document.getElementById('addTenantModal') || 
            event.target === document.getElementById('editTenantModal') || 
            event.target === document.getElementById('assignApartmentModal') || 
            event.target === document.getElementById('deleteModal')) {
            closeModal(event.target.id);
        }
    });
</script>
@endsection