@extends('layout')

@section('title', 'Gestion des Paiements')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <h2 class="text-2xl font-bold text-gray-800">
        <i class="fas fa-money-bill-wave text-blue-600 mr-2"></i> Gestion des Paiements
    </h2>
    <button onclick="openModal('addPaymentModal')" 
            class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg flex items-center">
        <i class="fas fa-plus mr-2"></i> Enregistrer un paiement
    </button>
</div>
 @if (session('success'))
    <div class="mb-4 px-4 py-3 rounded-md bg-green-100 text-green-800 font-semibold flex items-center">
        <i class="fas fa-check-circle mr-2"></i>
        {{ session('success') }}
        @if(session('paiement_id'))
            <span class="ml-3 px-2 py-1 bg-blue-200 text-blue-700 rounded text-xs">
                Contrat # {{ session('paiement_id') }}
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
<!-- Filtres -->
<div class="bg-white rounded-lg shadow p-4 mb-6">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <!-- Filtre par locataire -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Locataire</label>
            <select class="w-full px-3 py-2 border border-gray-300 rounded-md">
                <option value="">Tous les locataires</option>
                <option value="1">Jean Marc (B1-05)</option>
                <option value="2">Marie Ange (B2-12)</option>
                <option value="3">Thomas Shelby (A-03)</option>
            </select>
        </div>
        
        <!-- Filtre par mois -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Mois</label>
            <select class="w-full px-3 py-2 border border-gray-300 rounded-md">
                <option value="">Tous les mois</option>
                    <option value="Janvier">Janvier</option>
                    <option value="Février">Février</option>
                    <option value="Mars">Mars</option>
                    <option value="Avril">Avril</option>
                    <option value="Mai">Mai</option>
                    <option value="juin">Juin</option>
                    <option value="Juillet">Juillet</option>
                    <option value="Août">Août</option>
                    <option value="Septembre">Sptembre</option>
                    <option value=" Octobre">Octobre</option>
                    <option value="Novembre">Novembre</option>
                    <option value="Décembre">Décembre</option>

                </select>
            </select>
        </div>
        
        <!-- Filtre par statut -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
            <select class="w-full px-3 py-2 border border-gray-300 rounded-md">
                <option value="">Tous</option>
                <option value="payé">Payé</option>
                <option value="partiel">Partiel</option>
                <option value="annulé">annulé</option>
            </select>
        </div>
        
        <!-- Recherche -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Recherche</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
                <input type="text" placeholder="Code, locataire..." 
                       class="pl-10 w-full px-3 py-2 border border-gray-300 rounded-md">
            </div>
        </div>
    </div>
</div>

<!-- Liste des paiements -->
<div class="bg-white rounded-lg shadow overflow-hidden mb-8">
   <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Réference</th>
                    <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Locataire</th>
                    <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mois</th>
                    <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Montant à payer</th>
                    <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                    <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                    <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($paiements as $paiement)
                <tr>
                    <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                        <span class="font-mono text-blue-600">{{ $paiement->reference ?? $paiement->paiement_id }}</span>
                    </td>
                    <td class="px-4 sm:px-6 py-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10 rounded-full flex items-center justify-center
                                @php
                                    // Juste pour attribuer une couleur selon l'initiale
                                    $colors = ['bg-blue-100 text-blue-600','bg-purple-100 text-purple-600','bg-yellow-100 text-yellow-600','bg-green-100 text-green-600'];
                                    $index = ord(strtoupper($paiement->locataire->nom[0] ?? 'A')) % count($colors);
                                @endphp
                                {{ $colors[$index] }}">
                                @if($paiement->locataire)
                                    {{ strtoupper(substr($paiement->locataire->nom, 0, 1) . substr($paiement->locataire->prenom ?? '', 0, 1)) }}
                                @else
                                    ?
                                @endif
                            </div>
                            <div class="ml-4">
                                <div class="font-medium">
                                    {{ $paiement->locataire->nom ?? 'Inconnu' }}
                                </div>
                                <div class="text-sm text-gray-500">
                                    {{ $paiement->appartement->code_appartement ?? '' }}
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ $paiement->mois }}</div>
                    </td>
                    <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium">{{ number_format($paiement->montant, 0, ',', ' ') }} FCFA</div>
                    </td>
                    <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-500">{{ $paiement->created_at ? $paiement->created_at->format('d/m/Y') : '-' }}</div>
                    </td>
                    <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
    @php
        if ($paiement->statut == 'payer') {
            $bg = 'bg-green-100 text-green-800';
            $statut = 'Payé';
        } elseif ($paiement->statut == 'avance') {
            $bg = 'bg-orange-100 text-orange-700';
            $statut = 'Avance';
        } else {
            $bg = 'bg-red-700 text-red-100';
            $statut = 'Impayé';
        }
    @endphp
    <span class="px-2 py-1 text-xs rounded-full {{ $bg }}">{{ $statut }}</span>
</td>
                    <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex flex-col sm:flex-row gap-2">
                            <button 
                                onclick="openDetailModal('paiement-detail-{{ $paiement->paiement_id }}')" 
                                class="text-blue-600 hover:text-blue-900" title="Voir">
                                <i class="fas fa-eye"></i>
                                <span class="sm:hidden">Voir</span>
                            </button>
                        </div>
                        <!-- Modal par paiement (caché par défaut, unique via id) -->
                        <div id="paiement-detail-{{ $paiement->paiement_id }}"
                             class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4 sm:p-6">
                            <div class="bg-white rounded-lg shadow-xl w-full max-w-md mx-4 sm:mx-6">
                                <div class="flex justify-between items-center border-b px-4 sm:px-6 py-4">
                                    <h3 class="text-lg font-bold text-gray-800">
                                        <i class="fas fa-file-invoice-dollar text-blue-500 mr-2"></i> Détails du paiement
                                    </h3>
                                    <button onclick="closeDetailModal('paiement-detail-{{ $paiement->paiement_id }}')" class="text-gray-400 hover:text-gray-500 text-xl">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                                <div class="p-4 sm:p-6 space-y-4">
                                    <div>
                                        <p class="text-sm text-gray-500">Code paiement</p>
                                        <p class="font-mono font-medium text-blue-600">{{ $paiement->reference ?? $paiement->paiement_id }}</p>
                                    </div>
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 @if($paiement->locataire) {{ $colors[$index] }} @endif rounded-full flex items-center justify-center mr-3">
                                            @if($paiement->locataire)
                                                {{ strtoupper(substr($paiement->locataire->nom, 0, 1) . substr($paiement->locataire->prenom ?? '', 0, 1)) }}
                                            @else
                                                ?
                                            @endif
                                        </div>
                                        <div>
                                            <p class="font-medium">{{ $paiement->locataire->nom ?? 'Inconnu' }}</p>
                                            <p class="text-sm text-gray-500">{{ $paiement->appartement->code_appartement ?? '' }}</p>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <p class="text-sm text-gray-500">Mois concerné</p>
                                            <p class="font-medium">{{ $paiement->mois }}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">Date paiement</p>
                                            <p class="font-medium">{{ $paiement->created_at ? $paiement->created_at->format('d/m/Y') : '-' }}</p>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <p class="text-sm text-gray-500">Montant</p>
                                            <p class="font-medium">{{ number_format($paiement->montant, 0, ',', ' ') }} FCFA</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">Mode</p>
                                            <p class="font-medium">{{ $paiement->mode_paiement }}</p>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Référence</p>
                                        <p class="font-medium">{{ $paiement->reference ?? '-' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Statut</p>
                                        <p><span class="px-2 py-1 text-xs rounded-full {{ $bg }}">{{ $statut }}</span></p>
                                    </div>
                                </div>
                                <div class="mt-6 flex justify-end">
                                    <button onclick="closeDetailModal('paiement-detail-{{ $paiement->paiement_id }}')" 
                                            class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                        Fermer
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- Fin modal paiement -->
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
     
    
    <!-- Pagination -->

    <div class="bg-gray-50 px-4 sm:px-6 py-3 flex items-center justify-between border-t border-gray-200">
        {!! $paiements->links() !!}
    </div>
    
</div>

<!-- Modal Ajout de paiement -->
<div id="addPaymentModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4 sm:p-6">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-md mx-4 sm:mx-6 overflow-y-auto" style="max-height: 90vh;">
        <div class="flex justify-between items-center border-b px-4 sm:px-6 py-4 sticky top-0 bg-white z-10">
            <h3 class="text-lg font-bold text-gray-800">
                <i class="fas fa-money-bill-wave text-green-500 mr-2"></i> Nouveau paiement
            </h3>
            <button onclick="closeModal('addPaymentModal')" class="text-gray-400 hover:text-gray-500 text-xl">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
       <form method="POST" action="{{ route('paiements.store') }}" class="p-4 sm:p-6">
    @csrf
    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700 mb-1">Locataire*</label>
        <select name="tenant_value" required class="w-full px-3 py-2 border border-gray-300 rounded-md">
            <option value="">-- Choisir --</option>
            @foreach($locataires as $locataire)
                <option value="{{ $locataire->code_locataires }}">
                    {{ $locataire->nom }} {{ $locataire->prenom }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700 mb-1">Mois à payer*</label>
        <select name="month" required class="w-full px-3 py-2 border border-gray-300 rounded-md">
            <option value="">-- Choisir --</option>
            <option value="Janvier">Janvier</option>
            <option value="Février">Février</option>
            <option value="Mars">Mars</option>
            <option value="Avril">Avril</option>
            <option value="Mai">Mai</option>
            <option value="Juin">Juin</option>
            <option value="Juillet">Juillet</option>
            <option value="Août">Août</option>
            <option value="Septembre">Septembre</option>
            <option value="Octobre">Octobre</option>
            <option value="Novembre">Novembre</option>
            <option value="Décembre">Décembre</option>
        </select>
    </div>

    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700 mb-1">Montant*</label>
        <div class="relative">
            <input name="amount" type="number" step="0.01" class="w-full px-3 py-2 border border-gray-300 rounded-md pl-12"
                value="{{ old('amount', $montantParDefaut ?? '') }}" required placeholder="750000">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <span class="text-gray-500">FCFA</span>
            </div>
        </div>
    </div>
     <div class="mb-4">
            <label for="statusFilter" class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
            <select id="statusFilter"  name="statut" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                <option value="">Tous</option>
                <option value="payer">Payer</option>
                <option value="avance">Avance</option>
                <option value="impayer">Impayer</option>
            </select>
        </div>

    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700 mb-1">Référence</label>
        <input name="reference" type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md"
            value="{{ old('reference') }}" placeholder="Numéro de chèque, référence...">
    </div>

    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700 mb-1">Mode de paiement*</label>
        <select name="payment_method" required class="w-full px-3 py-2 border border-gray-300 rounded-md">
            <option value="">-- Choisir --</option>
            <option value="cash">Espèces</option>
            <option value="check">Chèque</option>
            <option value="transfer">Virement</option>
            <option value="mobile">Mobile Money</option>
        </select>
    </div>

    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 flex items-center justify-center">
        <i class="fas fa-save mr-2"></i> Enregistrer
    </button>
</form>
    </div>
</div>



<script>
    // Modals dynamiques par paiement
    function openDetailModal(id) {
        document.getElementById(id).classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }
    function closeDetailModal(id) {
        document.getElementById(id).classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }
    // Gère l'ajout (inchangé)
    function openModal(modalId) {
        document.getElementById(modalId).classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }
    function closeModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }
</script>
@endsection