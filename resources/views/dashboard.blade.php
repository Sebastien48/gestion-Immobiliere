@extends('layout')

@section('title', 'Tableau de bord')

@section('content')
<div class="mb-8">
    <h2 class="text-2xl font-bold text-gray-800 flex items-center">
        <i class="fas fa-tachometer-alt text-blue-600 mr-3"></i> Tableau de bord
    </h2>
    <p class="text-gray-600">Aperçu global de votre activité immobilière</p>
</div>

<!-- Cartes de statistiques -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <!-- Carte Bâtiments -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden border-l-4 border-blue-500">
        <div class="p-6">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Bâtiments gérés</p>
                    <p class="text-3xl font-bold mt-2" id="buildingsCount">{{$buildingsCount}}</p>
                </div>
                <div class="bg-blue-100 text-blue-600 p-3 rounded-full">
                    <i class="fas fa-building text-xl"></i>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{route('batiments.index')}}" class="text-blue-600 hover:text-blue-800 text-sm flex items-center">
                    Voir la liste complète <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Carte Appartements -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden border-l-4 border-green-500">
        <div class="p-6">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Appartements</p>
                    <div class="flex items-baseline mt-2 space-x-4">
                            <p class="text-2xl font-bold text-green-600" id="apartmentsOccupied">{{$appartementsOccupes}}</p>
                                    <p class="text-xs text-gray-500">Occupés</p>
                                </div>
                              <!--  <div class="border-l border-gray-200 h-10"></div> -->
                                <div>
                                    <p class="text-2xl font-bold text-blue-600" id="apartmentsAvailable">{{$appartementsLibres}}</p>
                                    <p class="text-xs text-gray-500">Disponibles</p>
                    </div>
                </div>
                <div class="bg-green-100 text-green-600 p-3 rounded-full">
                    <i class="fas fa-home text-xl"></i>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{route('appartements.index')}}" class="text-green-600 hover:text-green-800 text-sm flex items-center">
                    Gérer les appartements <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Carte Paiements -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden border-l-4 border-yellow-500">
    <div class="p-6">
        @php
            // Récupérer le mois courant (format YYYY-MM)
            $moisCourant = now()->format('Y-m');
            $paiementMois = $paiementStats['par_mois'][$moisCourant] ?? 0;
            $totalPaiements = $paiementStats['total'] ?? 0;
        @endphp

        <p class="text-gray-500 text-sm font-medium">
            Paiements du mois
        </p>
        <p class="text-3xl font-bold mt-2" id="pendingPayments">
            {{ number_format($paiementMois, 0, ',', ' ') }} FCFA
        </p>
        <p class="text-sm text-gray-500 mt-1">
            Total : 
            <span class="font-medium">
                {{ number_format($totalPaiements, 0, ',', ' ') }} FCFA
            </span>
        </p>
        <div class="mt-4">
            <a href="{{ route('paiements.index') }}" class="text-yellow-600 hover:text-yellow-800 text-sm flex items-center">
                Voir les paiements 
                <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
    </div>
</div>
    </div>
</div>

<!-- Section Rappels et alertes -->
<div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
        <h3 class="text-lg font-bold text-gray-800 flex items-center">
            <i class="fas fa-bell text-yellow-500 mr-2"></i> Rappels et alertes
        </h3>
        <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">3 nouveaux</span>
    </div>
    <div class="divide-y divide-gray-200">
        <div class="p-4 hover:bg-blue-50 transition-colors">
            <div class="flex items-start">
                <div class="flex-shrink-0 pt-1">
                    <div class="bg-red-100 text-red-600 p-2 rounded-full">
                        <i class="fas fa-exclamation-circle"></i>
                    </div>
                </div>
                <div class="ml-4 flex-1">
                    <p class="text-sm font-medium text-gray-900">Contrats à renouveler</p>
                    <p class="text-sm text-gray-500">3 contrats arrivent à expiration dans 15 jours</p>
                    <p class="text-xs text-gray-400 mt-1">Il y a 2 heures</p>
                </div>
                <button class="text-blue-600 hover:text-blue-800 text-sm">
                    Voir
                </button>
            </div>
        </div>
        <div class="p-4 hover:bg-blue-50 transition-colors">
            <div class="flex items-start">
                <div class="flex-shrink-0 pt-1">
                    <div class="bg-yellow-100 text-yellow-600 p-2 rounded-full">
                        <i class="fas fa-clock"></i>
                    </div>
                </div>
                <div class="ml-4 flex-1">
                    <p class="text-sm font-medium text-gray-900">Paiements en retard</p>
                    <p class="text-sm text-gray-500">2 locataires n'ont pas encore payé ce mois</p>
                    <p class="text-xs text-gray-400 mt-1">Aujourd'hui, 09:30</p>
                </div>
                <button class="text-blue-600 hover:text-blue-800 text-sm">
                    Voir
                </button>
            </div>
        </div>
        <div class="p-4 hover:bg-blue-50 transition-colors">
            <div class="flex items-start">
                <div class="flex-shrink-0 pt-1">
                    <div class="bg-green-100 text-green-600 p-2 rounded-full">
                        <i class="fas fa-home"></i>
                    </div>
                </div>
                <div class="ml-4 flex-1">
                    <p class="text-sm font-medium text-gray-900">Appartement disponible</p>
                    <p class="text-sm text-gray-500">Le studio B2-14 est maintenant libre</p>
                    <p class="text-xs text-gray-400 mt-1">Hier, 16:45</p>
                </div>
                <button class="text-blue-600 hover:text-blue-800 text-sm">
                    Voir
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Section Derniers paiements -->
<div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
        <h3 class="text-lg font-bold text-gray-800 flex items-center">
            <i class="fas fa-money-bill-wave text-green-600 mr-2"></i> Derniers paiements
        </h3>
        <a href="/paiements" class="text-blue-600 hover:text-blue-800 text-sm">
            Voir tout <i class="fas fa-arrow-right ml-1"></i>
        </a>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Locataire</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Appartement</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mois</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Montant</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200" id="recentPayments">
                <!-- Rempli dynamiquement par JS -->
            </tbody>
        </table>
    </div>
</div>

<!-- Section Activité récente -->
<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
        <h3 class="text-lg font-bold text-gray-800 flex items-center">
            <i class="fas fa-history text-purple-600 mr-2"></i> Activité récente
        </h3>
    </div>
    <div class="p-6">
        <div class="space-y-4">
            <div class="flex items-start">
                <div class="flex-shrink-0 pt-1">
                    <div class="bg-blue-100 text-blue-600 p-2 rounded-full">
                        <i class="fas fa-file-contract"></i>
                    </div>
                </div>
                <div class="ml-4 flex-1">
                    <p class="text-sm font-medium text-gray-900">Nouveau contrat signé</p>
                    <p class="text-sm text-gray-500">Marie Ange - Appartement B1-05</p>
                    <p class="text-xs text-gray-400 mt-1">Aujourd'hui, 11:20</p>
                </div>
            </div>
            <div class="flex items-start">
                <div class="flex-shrink-0 pt-1">
                    <div class="bg-green-100 text-green-600 p-2 rounded-full">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                </div>
                <div class="ml-4 flex-1">
                    <p class="text-sm font-medium text-gray-900">Paiement enregistré</p>
                    <p class="text-sm text-gray-500">Jean Marc - 750 mille FCFA - Juillet 2023</p>
                    <p class="text-xs text-gray-400 mt-1">Hier, 14:30</p>
                </div>
            </div>
            <div class="flex items-start">
                <div class="flex-shrink-0 pt-1">
                    <div class="bg-purple-100 text-purple-600 p-2 rounded-full">
                        <i class="fas fa-user-plus"></i>
                    </div>
                </div>
                <div class="ml-4 flex-1">
                    <p class="text-sm font-medium text-gray-900">Nouveau locataire</p>
                    <p class="text-sm text-gray-500">Sophie Koffi ajoutée au système</p>
                    <p class="text-xs text-gray-400 mt-1">Hier, 10:15</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Données simulées pour le tableau de bord
    const dashboardData = {
        buildings: {{ $buildingsCount ?? 0 }},
       
        pendingPayments: 5,
        recentPayments: [
            { tenant: "Jean Marc", apartment: "B2-12", month: "Juillet 2023", amount: "750 mille FCFA", status: "paid" },
            { tenant: "Marie Ange", apartment: "B1-05", month: "Juillet 2023", amount: "650 mille FCFA", status: "paid" },
            { tenant: "Thomas Shelby", apartment: "B3-08", month: "Juillet 2023", amount: "820 mille FCFA", status: "pending" }
        ]
    };

    // Fonction pour obtenir les initiales du nom et prénom
    function getInitials(fullName) {
        const names = fullName.trim().split(' ');
        let initials = '';
        if (names.length > 0) initials += names[0][0] || '';
        if (names.length > 1) initials += names[1][0] || '';
        return initials.toUpperCase();
    }

    // Initialisation du tableau de bord
    document.addEventListener('DOMContentLoaded', function() {
        // Mise à jour des cartes statistiques
        // document.getElementById('buildingsCount').textContent = dashboardData.buildings;
        document.getElementById('apartmentsOccupied').textContent = dashboardData.apartments.occupied;
        document.getElementById('apartmentsAvailable').textContent = dashboardData.apartments.available;
        document.getElementById('pendingPayments').textContent = dashboardData.pendingPayments;

        // Remplissage des derniers paiements
        const paymentsTable = document.getElementById('recentPayments');
        paymentsTable.innerHTML = '';
        
        dashboardData.recentPayments.forEach(payment => {
            const statusClass = payment.status === 'paid' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800';
            const statusText = payment.status === 'paid' ? 'Payé' : 'En attente';
            const initials = getInitials(payment.tenant);

            const row = document.createElement('tr');
            row.className = 'hover:bg-gray-50';
            row.innerHTML = `
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-10 w-10">
                            <div class="h-10 w-10 rounded-full bg-blue-200 flex items-center justify-center text-lg font-bold text-blue-700">
                                ${initials}
                            </div>
                        </div>
                        <div class="ml-4">
                            <div class="text-sm font-medium text-gray-900">${payment.tenant}</div>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    ${payment.apartment}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    ${payment.month}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                    ${payment.amount}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="px-2 py-1 text-xs rounded-full ${statusClass}">${statusText}</span>
                </td>
            `;
            paymentsTable.appendChild(row);
        });
    });
</script>
@endsection