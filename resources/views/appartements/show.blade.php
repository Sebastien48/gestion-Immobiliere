
@extends('layout')

@section('title', 'Détails de l\'Appartement')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <h2 class="text-2xl font-bold text-gray-800 flex items-center">
            <i class="fas fa-home text-blue-600 mr-3"></i>
            <span>Appartement: {{ $appartement->numero }}</span>
        </h2>
        <p class="text-gray-600 mt-1">
            <i class="fas fa-building text-gray-400 mr-1"></i>
            <span>{{ optional($appartement->batiment)->nom ?? $appartement->code_batiment }}</span>
        </p>
    </div>
    <div class="flex space-x-3">
        <button onclick="window.parent.openApartmentModal('{{ $appartement->code_appartement }}')" 
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center">
            <i class="fas fa-edit mr-2"></i> Modifier
        </button>
        <a href="{{ route('appartements.index') }}" 
        class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-lg flex items-center">
            <i class="fas fa-arrow-left mr-2"></i> Retour
        </a>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <!-- Carte Informations de base -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden border-l-4 border-blue-500">
        <div class="p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                <i class="fas fa-info-circle text-blue-500 mr-2"></i> Informations
            </h3>
            <ul class="space-y-3">
                <li class="flex justify-between">
                    <span class="text-gray-600">Étage:</span>
                    <span class="font-medium">2</span>
                </li>
                <li class="flex justify-between">
                    <span class="text-gray-600">Superficie:</span>
                    <span class="font-medium">{{ $appartement->superficie }} m²</span>
                </li>
                <li class="flex justify-between">
                    <span class="text-gray-600">Loyer mensuel:</span>
                    <span class="font-medium">{{ number_format($appartement->loyer_mensuel, 0, ',', ' ') }} FCFA</span>
                </li>
                <li class="flex justify-between">
                    <span class="text-gray-600">Date création:</span>
                    <span class="font-medium">{{ $appartement->created_at ? $appartement->created_at->format('d/m/Y') : '-' }}</span>
                </li>
            </ul>
        </div>
    </div>
<!-- ... (le reste de la vue idem) ... -->

    <!-- Carte Statut -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden border-l-4 border-green-500">
        <div class="p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                <i class="fas fa-chart-bar text-green-500 mr-2"></i> Statut
            </h3>
            <div class="flex flex-col items-center justify-center h-full">
                <span class="px-4 py-2 bg-green-100 text-green-800 text-lg rounded-full mb-3">Libre</span>
                <p class="text-gray-600 text-center">Cet appartement est actuellement disponible à la location</p>
            </div>
        </div>
    </div>

    <!-- Carte Locataire actuel -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden border-l-4 border-purple-500">
        <div class="p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                <i class="fas fa-users text-purple-500 mr-2"></i> Locataire
            </h3>
            <div class="flex flex-col items-center justify-center h-full text-center">
                <i class="fas fa-user-slash text-gray-300 text-4xl mb-3"></i>
                <p class="text-gray-600">Aucun locataire actuellement</p>
                <a href="/locataires?apartment_id=" 
                    class="mt-4 text-purple-600 hover:text-purple-800 font-medium">
                    <i class="fas fa-plus mr-1"></i> Attribuer un locataire
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Section Historique des locations -->
<div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
        <h3 class="text-lg font-medium text-gray-900 flex items-center">
            <i class="fas fa-history text-blue-500 mr-2"></i> Historique des locations
        </h3>
        <a href="/locations?apartment_id=" class="text-sm text-blue-600 hover:text-blue-800">
            Voir tout l'historique
        </a>
    </div>
    <div class="p-6">
        <div class="text-center text-gray-500 py-8">
            <i class="fas fa-inbox text-3xl mb-2"></i>
            <p>Aucune location enregistrée pour cet appartement</p>
        </div>
    </div>
</div>

<!-- Section Paiements récents -->
<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
        <h3 class="text-lg font-medium text-gray-900 flex items-center">
            <i class="fas fa-money-bill-wave text-blue-500 mr-2"></i> Paiements récents
        </h3>
        <a href="/paiements?apartment_id=}}" class="text-sm text-blue-600 hover:text-blue-800">
            Voir tout l'historique
        </a>
    </div>
    <div class="p-6">
        <div class="text-center text-gray-500 py-8">
            <i class="fas fa-inbox text-3xl mb-2"></i>
            <p>Aucun paiement enregistré pour cet appartement</p>
        </div>
    </div>
</div>

<script>
    // Si la page est chargée seule (pas en iframe)
    if (window === window.parent) {
        // Définir les fonctions si elles n'existent pas
        if (typeof openApartmentModal !== 'function') {
            function openApartmentModal(apartmentId = null) {
                alert('Revenez et cliquez sur le bouton modifier de l\'appart pour modifier l\'appartement ' + apartmentId);
            }
        }
        
        // Gérer le bouton Modifier
        document.querySelector('button[onclick^="window.parent.openApartmentModal"]')?.addEventListener('click', function() {
            const match = this.getAttribute('onclick').match(/\d+/);
            if (match) openApartmentModal(match[0]);
        });
    }
</script>
@endsection