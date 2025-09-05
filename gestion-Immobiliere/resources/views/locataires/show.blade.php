@extends('layout')

@section('title', 'Détails du Locataire')

@section('content')
<!-- En-tête avec boutons d'action -->
<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div class="flex items-center">
        <div class="flex-shrink-0 h-16 w-16 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 text-2xl mr-4">
            <i class="fas fa-user"></i>
        </div>
        <div>
            <h2 class="text-2xl font-bold text-gray-800" id="tenantName">{{ $locataire->nom }} {{ $locataire->prenom }}</h2>
            <p class="text-gray-600">
                <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded">Locataire</span>
                <span class="mx-2">•</span>
                <span id="tenantCni">{{ $locataire->numero_piece ?? $locataire->code_locataires }}</span>
            </p>
        </div>
    </div>
    <div class="flex space-x-3">
        <button onclick="openModal('editTenantModal')" 
            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center">
            <i class="fas fa-edit mr-2"></i> Modifier
        </button>
        <button onclick="window.location.href='{{route('locataires.index')}}'" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-lg flex items-center">
            <i class="fas fa-arrow-left mr-2"></i> Retour
        </button>
    </div>
</div>

<!-- Cartes d'information -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

    <!-- Carte Informations personnelles -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden border-l-4 border-blue-500">
        <div class="p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                <i class="fas fa-id-card text-blue-500 mr-2"></i> Informations personnelles
            </h3>
            <ul class="space-y-3">
                <li class="flex justify-between">
                    <span class="text-gray-600">Date de naissance:</span>
                    <span class="font-medium">{{ $locataire->date_naissance }}</span>
                </li>
                <li class="flex justify-between">
                    <span class="text-gray-600">Nationalité:</span>
                    <span class="font-medium">{{ $locataire->nationalité }}</span>
                </li>
                <li class="flex justify-between">
                    <span class="text-gray-600">Profession:</span>
                    <span class="font-medium">{{ $locataire->profession }}</span>
                </li>
            </ul>
        </div>
    </div>

    <!-- Carte Contact -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden border-l-4 border-green-500">
        <div class="p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                <i class="fas fa-address-book text-green-500 mr-2"></i> Contact
            </h3>
            <ul class="space-y-3">
                <li class="flex items-start">
                    <i class="fas fa-phone text-gray-400 mt-1 mr-2"></i>
                    <span class="font-medium">{{ $locataire->telephone }}</span>
                </li>
                <li class="flex items-start">
                    <i class="fas fa-envelope text-gray-400 mt-1 mr-2"></i>
                    <span class="font-medium">{{ $locataire->email }}</span>
                </li>
                <li class="flex items-start">
                    <i class="fas fa-map-marker-alt text-gray-400 mt-1 mr-2"></i>
                    <span class="font-medium">{{ $locataire->adresse }}</span>
                </li>
            </ul>
        </div>
    </div>
    <!-- ... Les autres blocs restent, tu passes en dynamique dès que tu as la structure -->
</div>
@endsection