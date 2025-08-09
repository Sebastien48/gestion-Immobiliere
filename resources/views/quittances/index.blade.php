@extends('layout')

@section('title', 'Gestion des Quittances')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <h2 class="text-2xl font-bold text-gray-800">
        <i class="fas fa-receipt text-blue-600 mr-2"></i> Gestion des Quittances
    </h2>
    <button onclick="window.location.href='/quittances/creer'" 
        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center">
        <i class="fas fa-plus mr-2"></i> Créer une quittance
    </button>
</div>

<!-- Filtres -->
<div class="bg-white rounded-lg shadow p-4 mb-6">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <!-- Filtre par bâtiment -->
        <div>
            <label for="buildingFilter" class="block text-sm font-medium text-gray-700 mb-1">Bâtiment</label>
            <select id="buildingFilter" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                <option value="">Tous les bâtiments</option>
                <option value="1" selected>Résidence Yasmina</option>
                <option value="2">Immeuble Bellevue</option>
            </select>
        </div>
        
        <!-- Filtre par date -->
        <div>
            <label for="monthFilter" class="block text-sm font-medium text-gray-700 mb-1">Mois</label>
            <input type="month" id="monthFilter" class="w-full px-3 py-2 border border-gray-300 rounded-md" value="2023-07">
        </div>
        
        <!-- Filtre par statut -->
        <div>
            <label for="statusFilter" class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
            <select id="statusFilter" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                <option value="">Tous</option>
                <option value="payee">Payée</option>
                <option value="impayee">Impayée</option>
            </select>
        </div>
        
        <!-- Bouton Filtrer -->
        <div class="flex items-end">
            <button onclick="applyFilters()" class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700">
                <i class="fas fa-filter mr-2"></i> Filtrer
            </button>
        </div>
    </div>
</div>

<!-- Tableau des quittances -->
<div class="bg-white rounded-lg shadow overflow-hidden mb-8">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Référence
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Appartement
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Bâtiment
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Période
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Montant
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
                <!-- Exemple de quittance -->
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <a href="/quittances/1" class="font-medium text-blue-600 hover:text-blue-800">
                            Q-2023-001
                        </a>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <a href="/appartements/1" class="text-blue-600 hover:text-blue-800">
                            B1-05
                        </a>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        Résidence Yasmina
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        01/07/2023 - 31/07/2023
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap font-medium">
                        750 000 FCFA
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">
                            Payée
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <button onclick="editQuittance(1)" class="text-blue-600 hover:text-blue-900 mr-3">
                            <i class="fas fa-edit"></i>
                        </button>
                        <a href="#" class="text-green-600 hover:text-green-900 mr-3">
                            <i class="fas fa-download"></i>
                        </a>
                        <button onclick="deleteQuittance(1)" class="text-red-600 hover:text-red-900">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
                <!-- Plus de quittances... -->
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    <div class="bg-gray-50 px-6 py-3 flex items-center justify-between border-t border-gray-200">
        <div class="text-sm text-gray-500">
            Affichage de <span>1</span> à <span>5</span> sur <span>12</span> quittances
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

<script>
    // Appliquer les filtres
    function applyFilters() {
        const buildingId = document.getElementById('buildingFilter').value;
        const month = document.getElementById('monthFilter').value;
        const status = document.getElementById('statusFilter').value;
        
        // Simuler le filtrage
        alert(`Filtres appliqués:\nBâtiment: ${buildingId || 'Tous'}\nMois: ${month || 'Tous'}\nStatut: ${status || 'Tous'}`);
    }

    // Pré-remplir le filtre de bâtiment si présent dans l'URL
    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        const batimentId = urlParams.get('batiment_id');
        
        if (batimentId) {
            document.getElementById('buildingFilter').value = batimentId;
        }
    });

    // Fonctions pour les actions
    function editQuittance(id) {
        alert(`Édition de la quittance ${id}`);
    }

    function deleteQuittance(id) {
        if (confirm('Êtes-vous sûr de vouloir supprimer cette quittance ?')) {
            alert(`Quittance ${id} supprimée !`);
        }
    }
</script>
@endsection