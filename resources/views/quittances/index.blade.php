@extends('layout')

@section('title', 'Gestion des Quittances')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div class="flex flex-row gap-2 items-center">
        <h2 class="text-2xl font-bold text-gray-800">
            <i class="fas fa-receipt text-blue-600 mr-2"></i> Gestion des Quittances
        </h2>
        <!-- Bouton : Générer une nouvelle quittance -->
        <form action="{{ route('quittances.creer_via_form') }}" method="POST" class="ml-4">
            @csrf
            <!-- Selon ton besoin, tu peux afficher un select locataire ou paiement à associer à la nouvelle quittance ici -->
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-3 py-2 rounded-lg flex items-center">
                <i class="fas fa-plus mr-2"></i> Voir les quittances
            </button>
        </form>
    </div>
</div>

<!-- Section détail si une quittance est sélectionnée 
@if(isset($quittance) && $quittance)
    <div class="mb-6 p-4 bg-gray-100 rounded border border-blue-200">
        <h3 class="text-lg font-semibold mb-2">
            <i class="fas fa-info-circle mr-2 text-blue-500"></i>Détail de la quittance n°{{ $quittance->id_quittance }}
        </h3>
        <ul class="mb-2">
            <li><strong>Appartement :</strong> {{ $quittance->paiement->code_appartement ?? 'N/A' }}</li>
            <li><strong>Bâtiment :</strong> {{ $quittance->paiement->batiment->nom ?? 'N/A' }}</li>
            <li><strong>Locataire :</strong> {{ $quittance->paiement->locataire->nom ?? 'N/A' }}</li>
            <li><strong>Mois :</strong> {{ $quittance->paiement->mois ?? 'N/A' }}</li>
            <li><strong>Montant :</strong> {{ isset($quittance->paiement->montant) ? number_format($quittance->paiement->montant, 0, ',', ' ') . ' FCFA' : 'N/A' }}</li>
        </ul>
        <a href="{{ route('quittances.download', $quittance->id_quittance) }}" 
           class="inline-block bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
           <i class="fas fa-download mr-1"></i> Télécharger la quittance PDF
        </a>
    </div>
@endif
*/
-->
<!-- Filtres -->
<div class="bg-white rounded-lg shadow p-4 mb-6">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div>
            <label for="buildingFilter" class="block text-sm font-medium text-gray-700 mb-1">Bâtiment</label>
            <select id="buildingFilter" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                <option value="">Tous les bâtiments</option>
                                        @foreach ($quittances as $quittance)
                        <option value="{{ $quittance->paiement->batiment->code_batiment ?? '' }}">
                            {{ $quittance->paiement->batiment->nom ?? 'N/A' }}
                        </option>
                    @endforeach
            </select>
        </div>
        <div>
            <label for="monthFilter" class="block text-sm font-medium text-gray-700 mb-1">Mois</label>
            <input type="month" id="monthFilter" class="w-full px-3 py-2 border border-gray-300 rounded-md" value="2023-07">
        </div>
        <div>
            <label for="statusFilter" class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
            <select id="statusFilter"  class="w-full px-3 py-2 border border-gray-300 rounded-md">
                <option value="">Tous</option>
                <option value="payee">Payée</option>
                <option value="avance">Avance</option>
                <option value="impayee">Impayée</option>
            </select>
        </div>
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
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Référence</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Appartement</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bâtiment</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mois(Année)</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Montant</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
@forelse ($quittances as $q)
    <tr>
        <td class="px-6 py-4 whitespace-nowrap">
            <a href="{{ route('quittances.detail', $q->id_quittance) }}" 
               class="font-medium text-blue-600 hover:text-blue-800">
                {{ $q->id_quittance }}
            </a>
        </td>
        <td class="px-6 py-4 whitespace-nowrap">
            {{ $q->paiement->code_appartement ?? 'N/A' }}
        </td>
        <td class="px-6 py-4 whitespace-nowrap">
            {{ $q->paiement->batiment->nom ?? 'N/A' }}
        </td>
        <td class="px-6 py-4 whitespace-nowrap">
            {{ $q->paiement->mois ?? 'N/A' }}
        </td>
        <td class="px-6 py-4 whitespace-nowrap font-medium">
            {{ isset($q->paiement->montant) ? number_format($q->paiement->montant, 0, ',', ' ') . ' FCFA' : 'N/A' }}
        </td>
        <td class="px-6 py-4 whitespace-nowrap">
            <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">
                Payée
            </span>
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
            <a href="{{ route('quittances.download', $q->id_quittance) }}" 
               class="text-green-600 hover:text-green-900 mr-3">
                <i class="fas fa-download"></i>
            </a>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="7" class="px-6 py-4 text-center text-gray-500">
            Aucune quittance à telecharger.
        </td>
    </tr>
@endforelse
</tbody>
        </table>
    </div>

    <!-- Pagination (statique ici) -->
    <div class="bg-gray-50 px-6 py-3 flex items-center justify-between border-t border-gray-200">
        <div class="text-sm text-gray-500">
            Affichage de <span>1</span> à <span>{{ $quittances->count() }}</span> sur <span>{{ $quittances->count() }}</span> quittances
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
function applyFilters() {
    const buildingId = document.getElementById('buildingFilter').value;
    const month = document.getElementById('monthFilter').value;
    const status = document.getElementById('statusFilter').value;
    alert(`Filtres appliqués:\nBâtiment: ${buildingId || 'Tous'}\nMois: ${month || 'Tous'}\nStatut: ${status || 'Tous'}`);
}

document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const batimentId = urlParams.get('batiment_id');
    if (batimentId) {
        document.getElementById('buildingFilter').value = batimentId;
    }
});

function editQuittance(quittance_id) {
    alert(`Édition de la quittance ${id}`);
}

function deleteQuittance(quittance_id) {
    if (confirm('Êtes-vous sûr de vouloir supprimer cette quittance ?')) {
        alert(`Quittance ${id} supprimée !`);
    }
}
</script>
@endsection