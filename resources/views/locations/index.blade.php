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

<!-- Filtres et recherche -->
<div class="bg-white rounded-lg shadow p-4 mb-6">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <!-- Filtre par statut -->
        <div>
            <label for="statusFilter" class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
            <select id="statusFilter" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                <option value="">Toutes</option>
                <option value="active">Actives</option>
                <option value="pending">En attente</option>
                <option value="ended">Terminées</option>
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
        
        <!-- Filtre par date -->
        <div>
            <label for="dateFilter" class="block text-sm font-medium text-gray-700 mb-1">Période</label>
            <select id="dateFilter" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                <option value="">Toutes périodes</option>
                <option value="current">En cours</option>
                <option value="next-month">Prochain mois</option>
                <option value="past">Passées</option>
            </select>
        </div>
        
        <!-- Recherche -->
        <div>
            <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Recherche</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
                <input type="text" id="search" placeholder="Code, locataire..." 
                       class="pl-10 w-full px-3 py-2 border border-gray-300 rounded-md">
            </div>
        </div>
    </div>
</div>

<!-- Tableau des locations -->
<div class="bg-white rounded-lg shadow overflow-hidden mb-8">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Code
                    </th>
                    <th scope="col" class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Locataire
                    </th>
                    <th scope="col" class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Appartement
                    </th>
                    <th scope="col" class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Période
                    </th>
                    <th scope="col" class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Loyer
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
                <!-- Location active -->
                <tr>
                    <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                        <span class="font-mono text-blue-600">LOC-2023-001</span>
                    </td>
                    <td class="px-4 sm:px-6 py-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center text-blue-600">
                                <i class="fas fa-user"></i>
                            </div>
                            <div class="ml-4">
                                <div class="font-medium">KOUADIO Amani</div>
                                <div class="text-sm text-gray-500">CI-12345678</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                        <div class="font-medium">B1-05</div>
                        <div class="text-sm text-gray-500">Résidence Yasmina</div>
                    </td>
                    <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                        <div>01/01/2023 - 31/12/2023</div>
                        <div class="text-sm text-gray-500">12 mois</div>
                    </td>
                    <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                        <div class="font-medium">750 000 FCFA</div>
                        <div class="text-sm text-gray-500">Caution: 1 500 000 FCFA</div>
                    </td>
                    <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                        <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Active</span>
                    </td>
                    <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex flex-col sm:flex-row gap-2">
                            <button onclick="viewLocationDetails('LOC-2023-001')" class="text-blue-600 hover:text-blue-900" title="Détails">
                                <i class="fas fa-eye"></i>
                                <span class="sm:hidden">Voir</span>
                            </button>
                            <button onclick="updateRent('LOC-2023-001')" class="text-yellow-600 hover:text-yellow-900" title="Modifier montant">
                                <i class="fas fa-money-bill-wave"></i>
                                <span class="sm:hidden">Modifier</span>
                            </button>
                            <button onclick="extendContract('LOC-2023-001')" class="text-purple-600 hover:text-purple-900" title="Prolonger">
                                <i class="fas fa-calendar-plus"></i>
                                <span class="sm:hidden">Prolonger</span>
                            </button>
                            <button onclick="terminateContract('LOC-2023-001')" class="text-red-600 hover:text-red-900" title="Résilier">
                                <i class="fas fa-file-contract"></i>
                                <span class="sm:hidden">Résilier</span>
                            </button>
                        </div>
                    </td>
                </tr>
                
                <!-- Location en attente -->
                <tr>
                    <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                        <span class="font-mono text-yellow-600">LOC-2023-002</span>
                    </td>
                    <td class="px-4 sm:px-6 py-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10 bg-yellow-100 rounded-full flex items-center justify-center text-yellow-600">
                                <i class="fas fa-user"></i>
                            </div>
                            <div class="ml-4">
                                <div class="font-medium">TRAORE Fatou</div>
                                <div class="text-sm text-gray-500">CI-87654321</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                        <div class="font-medium">A-03</div>
                        <div class="text-sm text-gray-500">Immeuble Bellevue</div>
                    </td>
                    <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                        <div>01/07/2023 - 30/06/2024</div>
                        <div class="text-sm text-gray-500">12 mois</div>
                    </td>
                    <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                        <div class="font-medium">550 000 FCFA</div>
                        <div class="text-sm text-gray-500">Caution: 1 100 000 FCFA</div>
                    </td>
                    <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                        <span class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs rounded-full">En attente</span>
                    </td>
                    <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex flex-col sm:flex-row gap-2">
                            <button onclick="viewLocationDetails('LOC-2023-002')" class="text-blue-600 hover:text-blue-900" title="Détails">
                                <i class="fas fa-eye"></i>
                                <span class="sm:hidden">Voir</span>
                            </button>
                            <button onclick="updateRent('LOC-2023-002')" class="text-yellow-600 hover:text-yellow-900" title="Modifier montant">
                                <i class="fas fa-money-bill-wave"></i>
                                <span class="sm:hidden">Modifier</span>
                            </button>
                            <button onclick="terminateContract('LOC-2023-002')" class="text-red-600 hover:text-red-900" title="Résilier">
                                <i class="fas fa-file-contract"></i>
                                <span class="sm:hidden">Résilier</span>
                            </button>
                        </div>
                    </td>
                </tr>
                
                <!-- Location terminée -->
                <tr>
                    <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                        <span class="font-mono text-gray-500">LOC-2022-015</span>
                    </td>
                    <td class="px-4 sm:px-6 py-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10 bg-gray-100 rounded-full flex items-center justify-center text-gray-600">
                                <i class="fas fa-user"></i>
                            </div>
                            <div class="ml-4">
                                <div class="font-medium">KONATE Mamadou</div>
                                <div class="text-sm text-gray-500">CI-11223344</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                        <div class="font-medium">B2-12</div>
                        <div class="text-sm text-gray-500">Résidence Yasmina</div>
                    </td>
                    <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                        <div>01/06/2022 - 31/05/2023</div>
                        <div class="text-sm text-gray-500">12 mois</div>
                    </td>
                    <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                        <div class="font-medium">850 000 FCFA</div>
                        <div class="text-sm text-gray-500">Caution: 1 700 000 FCFA</div>
                    </td>
                    <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                        <span class="px-2 py-1 bg-gray-100 text-gray-800 text-xs rounded-full">Terminée</span>
                    </td>
                    <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex flex-col sm:flex-row gap-2">
                            <button onclick="viewLocationDetails('LOC-2022-015')" class="text-blue-600 hover:text-blue-900" title="Détails">
                                <i class="fas fa-eye"></i>
                                <span class="sm:hidden">Voir</span>
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
            Affichage de <span>1</span> à <span>3</span> sur <span>3</span> locations
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
        <form id="addLocationForm" class="p-4 sm:p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Locataire*</label>
                    <select name="tenant_id" required class="w-full px-3 py-2 border border-gray-300 rounded-md">
                        <option value="">Sélectionner un locataire</option>
                        <option value="1">KOUADIO Amani (CI-12345678)</option>
                        <option value="2">TRAORE Fatou (CI-87654321)</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Bâtiment*</label>
                    <select id="locationBuildingSelect" class="w-full px-3 py-2 border border-gray-300 rounded-md" onchange="updateLocationApartments()">
                        <option value="">Sélectionner un bâtiment</option>
                        <option value="1">Résidence Yasmina</option>
                        <option value="2">Immeuble Bellevue</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Appartement*</label>
                    <select name="apartment_id" id="locationApartmentSelect" required class="w-full px-3 py-2 border border-gray-300 rounded-md" disabled>
                        <option value="">Sélectionnez d'abord un bâtiment</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Date de début*</label>
                    <input type="date" name="start_date" required class="w-full px-3 py-2 border border-gray-300 rounded-md">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Durée (mois)*</label>
                    <input type="number" name="duration" min="1" value="12" required class="w-full px-3 py-2 border border-gray-300 rounded-md">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Loyer mensuel*</label>
                    <input type="number" name="monthly_rent" id="locationMonthlyRent" required class="w-full px-3 py-2 border border-gray-300 rounded-md" readonly>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Caution*</label>
                    <input type="number" name="deposit" id="locationDeposit" required class="w-full px-3 py-2 border border-gray-300 rounded-md" readonly>
                </div>
                
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Conditions du contrat</label>
                    <textarea name="contract_conditions" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md"></textarea>
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

<!-- Modal Détails de location -->
<div id="locationDetailsModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4 sm:p-6">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl mx-4 sm:mx-6 overflow-y-auto" style="max-height: 90vh;">
        <div class="flex justify-between items-center border-b px-4 sm:px-6 py-4 sticky top-0 bg-white z-10">
            <h3 class="text-lg font-bold text-gray-800">
                <i class="fas fa-file-contract text-blue-500 mr-2"></i> Détails de la location
            </h3>
            <button onclick="closeModal('locationDetailsModal')" class="text-gray-400 hover:text-gray-500 text-xl">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="p-4 sm:p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6 mb-6">
                <div>
                    <h4 class="font-medium text-gray-900 mb-2">Code location</h4>
                    <p class="font-mono text-blue-600" id="detailCode">LOC-2023-001</p>
                </div>
                <div>
                    <h4 class="font-medium text-gray-900 mb-2">Statut</h4>
                    <p><span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full" id="detailStatus">Active</span></p>
                </div>
                
                <div class="md:col-span-2">
                    <h4 class="font-medium text-gray-900 mb-2">Locataire</h4>
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center text-blue-600">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="ml-4">
                            <p class="font-medium" id="detailTenantName">KOUADIO Amani</p>
                            <p class="text-sm text-gray-500" id="detailTenantId">CI-12345678</p>
                        </div>
                    </div>
                </div>
                
                <div>
                    <h4 class="font-medium text-gray-900 mb-2">Appartement</h4>
                    <p class="font-medium" id="detailApartment">B1-05</p>
                    <p class="text-sm text-gray-500" id="detailBuilding">Résidence Yasmina</p>
                </div>
                <div>
                    <h4 class="font-medium text-gray-900 mb-2">Période</h4>
                    <p id="detailPeriod">01/01/2023 - 31/12/2023</p>
                    <p class="text-sm text-gray-500" id="detailDuration">12 mois</p>
                </div>
                
                <div>
                    <h4 class="font-medium text-gray-900 mb-2">Loyer mensuel</h4>
                    <p class="font-medium" id="detailRent">750 000 FCFA</p>
                </div>
                <div>
                    <h4 class="font-medium text-gray-900 mb-2">Caution</h4>
                    <p class="font-medium" id="detailDeposit">1 500 000 FCFA</p>
                </div>
                
                <div class="md:col-span-2">
                    <h4 class="font-medium text-gray-900 mb-2">Conditions du contrat</h4>
                    <p class="text-gray-700 whitespace-pre-line" id="detailConditions">
                        - Paiement avant le 5 de chaque mois
                        - Charges comprises
                        - Préavis de 2 mois pour résiliation
                    </p>
                </div>
            </div>
            
            <div class="border-t border-gray-200 pt-4">
                <h4 class="font-medium text-gray-900 mb-3">Historique des paiements</h4>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Mois
                                </th>
                                <th scope="col" class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Montant
                                </th>
                                <th scope="col" class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Date paiement
                                </th>
                                <th scope="col" class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Quittance
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr>
                                <td class="px-3 py-2 whitespace-nowrap text-sm">
                                    Janvier 2023
                                </td>
                                <td class="px-3 py-2 whitespace-nowrap text-sm font-medium">
                                    750 000 FCFA
                                </td>
                                <td class="px-3 py-2 whitespace-nowrap text-sm">
                                    02/01/2023
                                </td>
                                <td class="px-3 py-2 whitespace-nowrap text-sm">
                                    <button class="text-blue-600 hover:text-blue-900">
                                        <i class="fas fa-download mr-1"></i> PDF
                                    </button>
                                </td>
                            </tr>
                            <!-- Ajouter d'autres paiements ici -->
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="flex justify-end space-x-3 mt-6">
                <button onclick="closeModal('locationDetailsModal')" 
                        class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50">
                    Fermer
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Modification du montant -->
<div id="updateRentModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4 sm:p-6">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-md mx-4 sm:mx-6 overflow-y-auto" style="max-height: 90vh;">
        <!-- En-tête du modal -->
        <div class="flex justify-between items-center border-b px-4 sm:px-6 py-4 sticky top-0 bg-white z-10">
            <h3 class="text-lg sm:text-xl font-bold text-gray-800">
                <i class="fas fa-money-bill-wave text-yellow-500 mr-2"></i> Modifier le montant
            </h3>
            <button onclick="closeModal('updateRentModal')" class="text-gray-400 hover:text-gray-500 text-xl">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <!-- Contenu du formulaire -->
        <form id="updateRentForm" class="p-4 sm:p-6">
            <!-- Informations du contrat -->
            <div class="mb-4">
                <p class="text-sm sm:text-base text-gray-600 mb-1">Contrat:</p>
                <p class="font-medium text-sm sm:text-base" id="contractToUpdate">LOC-2023-001 - KOUADIO Amani</p>
                <p class="text-xs sm:text-sm text-gray-500" id="contractApartment">B1-05 - Résidence Yasmina</p>
            </div>
            
            <!-- Champs du formulaire -->
            <div class="space-y-3 sm:space-y-4">
                <!-- Ancien loyer -->
                <div>
                    <label class="block text-sm sm:text-base font-medium text-gray-700 mb-1">Ancien loyer mensuel</label>
                    <div class="relative">
                        <input type="number" id="oldRentInput" 
                               class="w-full px-3 py-2 sm:py-2.5 border border-gray-300 rounded-md bg-gray-100 pr-8" readonly>
                        <span class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500">FCFA</span>
                    </div>
                </div>
                
                <!-- Nouveau loyer -->
                <div>
                    <label class="block text-sm sm:text-base font-medium text-gray-700 mb-1">Nouveau loyer mensuel*</label>
                    <div class="relative">
                        <input type="number" name="new_rent" id="newRentInput" required 
                               class="w-full px-3 py-2 sm:py-2.5 border border-gray-300 rounded-md pr-8">
                        <span class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500">FCFA</span>
                    </div>
                </div>
                
                <!-- Nouvelle caution -->
                <div>
                    <label class="block text-sm sm:text-base font-medium text-gray-700 mb-1">Nouvelle caution (2x loyer)</label>
                    <div class="relative">
                        <input type="number" name="new_deposit" id="newDepositInput" 
                               class="w-full px-3 py-2 sm:py-2.5 border border-gray-300 rounded-md bg-gray-100 pr-8" readonly>
                        <span class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500">FCFA</span>
                    </div>
                </div>
                
                <!-- Motif de modification -->
                <div>
                    <label class="block text-sm sm:text-base font-medium text-gray-700 mb-1">Motif de modification*</label>
                    <select name="update_reason" required class="w-full px-3 py-2 sm:py-2.5 border border-gray-300 rounded-md">
                        <option value="">Sélectionner un motif</option>
                        <option value="agreement">Accord entre les parties</option>
                        <option value="indexation">Indexation contractuelle</option>
                        <option value="error">Correction d'erreur</option>
                        <option value="other">Autre</option>
                    </select>
                </div>
                
                <!-- Commentaires -->
                <div>
                    <label class="block text-sm sm:text-base font-medium text-gray-700 mb-1">Commentaires</label>
                    <textarea name="update_comments" rows="3" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm sm:text-base"></textarea>
                </div>
            </div>
            
            <!-- Boutons d'action -->
            <div class="flex flex-col-reverse sm:flex-row justify-end gap-3 mt-6">
                <button type="button" onclick="closeModal('updateRentModal')" 
                        class="px-4 py-2.5 sm:py-2 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50 text-sm sm:text-base">
                    Annuler
                </button>
                <button type="submit" 
                        class="px-4 py-2.5 sm:py-2 bg-yellow-600 text-white rounded-md hover:bg-yellow-700 flex items-center justify-center text-sm sm:text-base">
                    <i class="fas fa-save mr-2"></i> Enregistrer
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Prolongation de contrat -->
<div id="extendContractModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4 sm:p-6">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-md mx-4 sm:mx-6">
        <div class="flex justify-between items-center border-b px-4 sm:px-6 py-4">
            <h3 class="text-lg font-bold text-gray-800">
                <i class="fas fa-calendar-plus text-purple-500 mr-2"></i> Prolonger le contrat
            </h3>
            <button onclick="closeModal('extendContractModal')" class="text-gray-400 hover:text-gray-500 text-xl">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="extendContractForm" class="p-4 sm:p-6">
            <div class="mb-4">
                <p class="text-gray-600 mb-2">Contrat actuel: <span class="font-medium" id="currentContractPeriod">01/01/2023 - 31/12/2023</span></p>
            </div>
            
            <div class="grid grid-cols-1 gap-4 sm:gap-6 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nouvelle durée (mois)*</label>
                    <input type="number" name="extension_duration" min="1" value="12" required class="w-full px-3 py-2 border border-gray-300 rounded-md">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nouveau loyer mensuel</label>
                    <input type="number" name="new_rent" id="newRentInput" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nouvelles conditions (optionnel)</label>
                    <textarea name="new_conditions" rows="2" class="w-full px-3 py-2 border border-gray-300 rounded-md"></textarea>
                </div>
            </div>
            
            <div class="flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-3 mt-6">
                <button type="button" onclick="closeModal('extendContractModal')" 
                        class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50 order-2 sm:order-1">
                    Annuler
                </button>
                <button type="submit" 
                        class="px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700 flex items-center justify-center order-1 sm:order-2 mb-3 sm:mb-0">
                    <i class="fas fa-calendar-check mr-2"></i> Prolonger
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Résiliation de contrat -->
<div id="terminateContractModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4 sm:p-6">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-md mx-4 sm:mx-6">
        <div class="flex justify-between items-center border-b px-4 sm:px-6 py-4">
            <h3 class="text-lg font-bold text-gray-800">
                <i class="fas fa-file-contract text-red-500 mr-2"></i> Résilier le contrat
            </h3>
            <button onclick="closeModal('terminateContractModal')" class="text-gray-400 hover:text-gray-500 text-xl">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="terminateContractForm" class="p-4 sm:p-6">
            <div class="mb-4">
                <p class="text-gray-600 mb-2">Vous êtes sur le point de résilier le contrat:</p>
                <p class="font-medium" id="contractToTerminate">LOC-2023-001 - KOUADIO Amani (B1-05)</p>
            </div>
            
            <div class="grid grid-cols-1 gap-4 sm:gap-6 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Date de résiliation*</label>
                    <input type="date" name="termination_date" required class="w-full px-3 py-2 border border-gray-300 rounded-md">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Motif*</label>
                    <select name="termination_reason" required class="w-full px-3 py-2 border border-gray-300 rounded-md">
                        <option value="">Sélectionner un motif</option>
                        <option value="tenant_request">Demande du locataire</option>
                        <option value="owner_request">Demande du propriétaire</option>
                        <option value="non_payment">Non paiement</option>
                        <option value="other">Autre</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Commentaires</label>
                    <textarea name="termination_comments" rows="2" class="w-full px-3 py-2 border border-gray-300 rounded-md"></textarea>
                </div>
            </div>
            
            <div class="flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-3 mt-6">
                <button type="button" onclick="closeModal('terminateContractModal')" 
                        class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50 order-2 sm:order-1">
                    Annuler
                </button>
                <button type="submit" 
                        class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 flex items-center justify-center order-1 sm:order-2 mb-3 sm:mb-0">
                    <i class="fas fa-file-contract mr-2"></i> Confirmer la résiliation
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

    // Mise à jour des appartements disponibles pour la location
    function updateLocationApartments() {
        const buildingSelect = document.getElementById('locationBuildingSelect');
        const apartmentSelect = document.getElementById('locationApartmentSelect');
        
        if (buildingSelect.value) {
            // Simuler le chargement des appartements disponibles
            apartmentSelect.innerHTML = '';
            
            if (buildingSelect.value === '1') {
                // Appartements de la Résidence Yasmina
                const options = [
                    {id: 1, number: 'B1-05', rent: 750000, deposit: 1500000, status: 'libre'},
                    {id: 2, number: 'B1-07', rent: 650000, deposit: 1300000, status: 'occupe'},
                    {id: 3, number: 'B2-12', rent: 850000, deposit: 1700000, status: 'libre'}
                ];
                
                options.forEach(opt => {
                    const option = document.createElement('option');
                    option.value = opt.id;
                    option.textContent = `${opt.number} - ${opt.rent.toLocaleString()} FCFA/mois`;
                    option.dataset.rent = opt.rent;
                    option.dataset.deposit = opt.deposit;
                    option.disabled = opt.status !== 'libre';
                    if (opt.status !== 'libre') {
                        option.textContent += ' (Occupé)';
                    }
                    apartmentSelect.appendChild(option);
                });
            } else {
                // Appartements de l'Immeuble Bellevue
                const options = [
                    {id: 4, number: 'A-03', rent: 550000, deposit: 1100000, status: 'libre'},
                    {id: 5, number: 'B-08', rent: 600000, deposit: 1200000, status: 'libre'}
                ];
                
                options.forEach(opt => {
                    const option = document.createElement('option');
                    option.value = opt.id;
                    option.textContent = `${opt.number} - ${opt.rent.toLocaleString()} FCFA/mois`;
                    option.dataset.rent = opt.rent;
                    option.dataset.deposit = opt.deposit;
                    apartmentSelect.appendChild(option);
                });
            }
            
            apartmentSelect.disabled = false;
        } else {
            apartmentSelect.innerHTML = '<option value="">Sélectionnez d\'abord un bâtiment</option>';
            apartmentSelect.disabled = true;
            document.getElementById('locationMonthlyRent').value = '';
            document.getElementById('locationDeposit').value = '';
        }
    }

    // Mettre à jour le loyer et la caution quand un appartement est sélectionné
    document.getElementById('locationApartmentSelect').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        if (selectedOption && selectedOption.dataset.rent) {
            document.getElementById('locationMonthlyRent').value = selectedOption.dataset.rent;
            document.getElementById('locationDeposit').value = selectedOption.dataset.deposit;
        } else {
            document.getElementById('locationMonthlyRent').value = '';
            document.getElementById('locationDeposit').value = '';
        }
    });

    // Gestion du formulaire d'ajout de location
    document.getElementById('addLocationForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Vérifier si l'appartement est disponible
        const apartmentSelect = document.getElementById('locationApartmentSelect');
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
        
        // Générer un code de location
        const locationCode = 'LOC-' + new Date().getFullYear() + '-' + Math.floor(1000 + Math.random() * 9000);
        data.codeLocation = locationCode;
        
        console.log('Nouvelle location:', data);
        alert('Location enregistrée avec succès !\nCode: ' + locationCode);
        closeModal('addLocationModal');
    });

    // Voir les détails d'une location
    function viewLocationDetails(locationCode) {
        // Simuler le chargement des données
        const locationData = {
            code: locationCode,
            status: locationCode.includes('002') ? 'En attente' : 'Active',
            tenantName: locationCode.includes('002') ? 'TRAORE Fatou' : 'KOUADIO Amani',
            tenantId: locationCode.includes('002') ? 'CI-87654321' : 'CI-12345678',
            apartment: locationCode.includes('002') ? 'A-03' : 'B1-05',
            building: locationCode.includes('002') ? 'Immeuble Bellevue' : 'Résidence Yasmina',
            period: locationCode.includes('002') ? '01/07/2023 - 30/06/2024' : '01/01/2023 - 31/12/2023',
            duration: '12 mois',
            rent: locationCode.includes('002') ? '550 000 FCFA' : '750 000 FCFA',
            deposit: locationCode.includes('002') ? '1 100 000 FCFA' : '1 500 000 FCFA',
            conditions: '- Paiement avant le 5 de chaque mois\n- Charges comprises\n- Préavis de 2 mois pour résiliation'
        };
        
        // Remplir le modal avec les données
        document.getElementById('detailCode').textContent = locationData.code;
        document.getElementById('detailStatus').textContent = locationData.status;
        document.getElementById('detailTenantName').textContent = locationData.tenantName;
        document.getElementById('detailTenantId').textContent = locationData.tenantId;
        document.getElementById('detailApartment').textContent = locationData.apartment;
        document.getElementById('detailBuilding').textContent = locationData.building;
        document.getElementById('detailPeriod').textContent = locationData.period;
        document.getElementById('detailDuration').textContent = locationData.duration;
        document.getElementById('detailRent').textContent = locationData.rent;
        document.getElementById('detailDeposit').textContent = locationData.deposit;
        document.getElementById('detailConditions').textContent = locationData.conditions;
        
        // Ajuster la classe du statut
        const statusElement = document.getElementById('detailStatus');
        statusElement.className = 'px-2 py-1 text-xs rounded-full ';
        if (locationData.status === 'Active') {
            statusElement.classList.add('bg-green-100', 'text-green-800');
        } else if (locationData.status === 'Terminée') {
            statusElement.classList.add('bg-gray-100', 'text-gray-800');
        } else {
            statusElement.classList.add('bg-yellow-100', 'text-yellow-800');
        }
        
        openModal('locationDetailsModal');
    }

    // Modifier le montant du loyer
    function updateRent(locationCode) {
        // Simuler le chargement des données du contrat
        const isPending = locationCode.includes('002');
        
        document.getElementById('contractToUpdate').textContent = locationCode + ' - ' + 
            (isPending ? 'TRAORE Fatou' : 'KOUADIO Amani');
        document.getElementById('contractApartment').textContent = 
            (isPending ? 'A-03 - Immeuble Bellevue' : 'B1-05 - Résidence Yasmina');
        
        const currentRent = isPending ? 550000 : 750000;
        document.getElementById('oldRentInput').value = currentRent;
        document.getElementById('newRentInput').value = currentRent;
        
        // Calcul automatique de la nouvelle caution
        document.getElementById('newRentInput').addEventListener('input', function() {
            const newRent = parseFloat(this.value) || 0;
            document.getElementById('newDepositInput').value = newRent * 2;
        });
        
        openModal('updateRentModal');
    }

    // Gestion du formulaire de modification du loyer
    document.getElementById('updateRentForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const data = Object.fromEntries(formData);
        console.log('Modification du loyer:', data);
        
        alert('Loyer modifié avec succès !');
        closeModal('updateRentModal');
    });

    // Prolonger un contrat
    function extendContract(locationCode) {
        // Simuler le chargement des données du contrat
        document.getElementById('currentContractPeriod').textContent = '01/01/2023 - 31/12/2023';
        document.getElementById('newRentInput').value = '750000';
        
        openModal('extendContractModal');
    }

    // Gestion du formulaire de prolongation
    document.getElementById('extendContractForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const data = Object.fromEntries(formData);
        console.log('Prolongation de contrat:', data);
        
        alert('Contrat prolongé avec succès !');
        closeModal('extendContractModal');
    });

    // Résilier un contrat
    function terminateContract(locationCode) {
        // Simuler le chargement des données du contrat
        const isPending = locationCode.includes('002');
        
        document.getElementById('contractToTerminate').textContent = locationCode + ' - ' + 
            (isPending ? 'TRAORE Fatou (A-03)' : 'KOUADIO Amani (B1-05)');
        
        // Définir la date de résiliation par défaut à aujourd'hui
        const today = new Date();
        const dd = String(today.getDate()).padStart(2, '0');
        const mm = String(today.getMonth() + 1).padStart(2, '0');
        const yyyy = today.getFullYear();
        document.querySelector('#terminateContractForm input[name="termination_date"]').value = `${yyyy}-${mm}-${dd}`;
        
        openModal('terminateContractModal');
    }

    // Gestion du formulaire de résiliation
    document.getElementById('terminateContractForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const data = Object.fromEntries(formData);
        console.log('Résiliation de contrat:', data);
        
        alert('Contrat résilié avec succès !');
        closeModal('terminateContractModal');
    });

    // Générer une quittance
    function generateReceipt(locationCode) {
        alert('Génération de la quittance pour ' + locationCode + '\nCette fonctionnalité sera implémentée avec la génération de PDF.');
    }

    // Fermer les modals en cliquant en dehors
    document.addEventListener('click', function(event) {
        if (event.target === document.getElementById('addLocationModal') || 
            event.target === document.getElementById('locationDetailsModal') || 
            event.target === document.getElementById('updateRentModal') ||
            event.target === document.getElementById('extendContractModal') || 
            event.target === document.getElementById('terminateContractModal')) {
            closeModal(event.target.id);
        }
    });
</script>
@endsection