<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Gestion Immobilière</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{asset('css/app5.css')}}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen">
        <!-- En-tête -->
        <header class="bg-blue-800 text-white shadow-md">
            <div class="container mx-auto px-4 py-4">
                <div class="flex justify-between items-center">
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-600 to-indigo-600 flex items-center justify-center text-white font-bold shadow-lg">
                                <i class="fas fa-building text-lg"></i>
                            </div>
                            <span class="text-xl font-bold text-white">
                                Immobilier<span class="text-blue-300">Pro</span>
                            </span>
                        </div>
                        <nav class="hidden md:flex space-x-1">
                            <a href="#" class="px-3 py-2 rounded-md text-sm font-medium bg-blue-900 text-white">Tableau de bord</a>
                            <a href="#utilisateurs" class="px-3 py-2 rounded-md text-sm font-medium text-blue-200 hover:text-white">Utilisateurs</a>
                            <a href="#agences" class="px-3 py-2 rounded-md text-sm font-medium text-blue-200 hover:text-white">Agences</a>
                            <a href="#statistiques" class="px-3 py-2 rounded-md text-sm font-medium text-blue-200 hover:text-white">Statistiques</a>
                        </nav>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <button class="text-blue-200 hover:text-white relative">
                                <i class="fas fa-bell text-xl"></i>
                                <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">0</span>
                            </button>
                        </div>
                        
                        <!-- Dropdown pour l'admin avec bouton de déconnexion -->
                        <div class="relative">
                            <button onclick="toggleDropdown()" class="bg-blue-700 hover:bg-blue-600 px-4 py-2 rounded-lg flex items-center text-sm">
                                <i class="fas fa-user-circle mr-2"></i> {{$initiales ?? 'AG'}}
                                <i class="fas fa-chevron-down ml-2"></i>
                            </button>
                            
                            <!-- Menu dropdown -->
                            <div id="adminDropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                                <a href="{{route('logout')}}" class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                    <i class="fas fa-sign-out-alt mr-2"></i>Déconnexion
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Zone pour afficher les messages -->
        <div id="formMessage" class="mb-4"></div>

        <!-- Contenu principal -->
        <main class="container mx-auto px-4 py-8">
            <!-- Section Statistiques -->
            <section id="statistiques" class="mb-12">
                <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                    <i class="fas fa-chart-bar text-blue-600 mr-3"></i> Statistiques des inscriptions
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-5 gap-6 mb-8">
                    <!-- Total Utilisateurs -->
                    <div class="stat-card bg-white rounded-lg shadow-md p-6 border-t-4 border-blue-500">
                        <div class="flex justify-between">
                            <div>
                                <p class="text-gray-500 text-sm font-medium">Total Utilisateurs</p>
                                <p class="text-3xl font-bold mt-2" id="agencesTotal">0</p>
                            </div>
                            <div class="bg-blue-100 text-blue-600 p-3 rounded-full h-12 w-12 flex items-center justify-center">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                        <div class="mt-4">
                            <span class="text-gray-600 text-sm font-medium">
                                <i class="fas fa-info-circle"></i> Utilisateurs inscrits
                            </span>
                        </div>
                    </div>

                    <!-- Inscriptions ce mois -->
                    <div class="stat-card bg-white rounded-lg shadow-md p-6 border-t-4 border-green-500">
                        <div class="flex justify-between">
                            <div>
                                <p class="text-gray-500 text-sm font-medium">Inscriptions ce mois</p>
                                <p class="text-3xl font-bold mt-2" id="monthlyRegistrations">0</p>
                            </div>
                            <div class="bg-green-100 text-green-600 p-3 rounded-full h-12 w-12 flex items-center justify-center">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                        </div>
                        <div class="mt-4">
                            <span class="text-green-600 text-sm font-medium">
                                <i class="fas fa-arrow-up"></i> Nouvelles inscriptions
                            </span>
                        </div>
                    </div>

                    <!-- Inscriptions cette semaine -->
                    <div class="stat-card bg-white rounded-lg shadow-md p-6 border-t-4 border-purple-500">
                        <div class="flex justify-between">
                            <div>
                                <p class="text-gray-500 text-sm font-medium">Inscriptions cette semaine</p>
                                <p class="text-3xl font-bold mt-2" id="weeklyRegistrations">0</p>
                            </div>
                            <div class="bg-purple-100 text-purple-600 p-3 rounded-full h-12 w-12 flex items-center justify-center">
                                <i class="fas fa-calendar-week"></i>
                            </div>
                        </div>
                        <div class="mt-4">
                            <span class="text-purple-600 text-sm font-medium">
                                <i class="fas fa-chart-line"></i> Cette semaine
                            </span>
                        </div>
                    </div>

                    <!-- Total Agences -->
                    <div class="stat-card bg-white rounded-lg shadow-md p-6 border-t-4 border-orange-500">
                        <div class="flex justify-between">
                            <div>
                                <p class="text-gray-500 text-sm font-medium">Total Agences</p>
                                <p class="text-3xl font-bold mt-2" id="agencesTotaux">0</p>
                            </div>
                            <div class="bg-orange-100 text-orange-600 p-3 rounded-full h-12 w-12 flex items-center justify-center">
                                <i class="fas fa-building"></i>
                            </div>
                        </div>
                        <div class="mt-4">
                            <span class="text-orange-600 text-sm font-medium">
                                <i class="fas fa-check-circle"></i> Agences enregistrées
                            </span>
                        </div>
                    </div>

                    <!-- Total Bâtiments -->
                    <div class="stat-card bg-white rounded-lg shadow-md p-6 border-t-4 border-indigo-500">
                        <div class="flex justify-between">
                            <div>
                                <p class="text-gray-500 text-sm font-medium">Total Bâtiments</p>
                                <p class="text-3xl font-bold mt-2" id="batimentsTotal">0</p>
                            </div>
                            <div class="bg-indigo-100 text-indigo-600 p-3 rounded-full h-12 w-12 flex items-center justify-center">
                                <i class="fas fa-city"></i>
                            </div>
                        </div>
                        <div class="mt-4">
                            <span class="text-indigo-600 text-sm font-medium">
                                <i class="fas fa-home"></i> Bâtiments gérés
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Graphiques -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h3 class="text-lg font-medium text-gray-800 mb-4">Évolution des inscriptions</h3>
                        <div class="chart-container">
                            <canvas id="inscriptionsChart"></canvas>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h3 class="text-lg font-medium text-gray-800 mb-4">Répartition par rôle</h3>
                        <div class="chart-container">
                            <canvas id="rolesChart"></canvas>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h3 class="text-lg font-medium text-gray-800 mb-4">Performances Immobilières</h3>
                        <div class="chart-container">
                            <canvas id="performanceChart"></canvas>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Section Ajouter un utilisateur -->
            <section class="mb-12">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800 flex items-center">
                        <i class="fas fa-user-plus text-green-600 mr-3"></i> Ajouter un utilisateur ou un administrateur
                    </h2>
                    <button onclick="showUserForm()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md flex items-center">
                        <i class="fas fa-plus mr-2"></i> Ajouter
                    </button>
                </div>

                <!-- Formulaire pour ajouter un utilisateur -->
                <div id="userFormContainer" class="bg-white rounded-lg shadow-md p-6 hidden">
                    <form id="userForm" method="POST" action="{{route('admin.users.store')}}" class="space-y-4" enctype="multipart/form-data">
                        @csrf
                       
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="nom" class="block text-sm font-medium text-gray-700">Nom *</label>
                                <input type="text" id="nom" name="nom" required autocomplete="family-name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border">
                            </div>
                            <div>
                                <label for="prenom" class="block text-sm font-medium text-gray-700">Prénom *</label>
                                <input type="text" id="prenom" name="prenom" required autocomplete="given-name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border">
                            </div>
                            <div>
                                <label for="agenceUser" class="block text-sm font-medium text-gray-700">Agence</label>
                                <select id="agenceUser" name="agence_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border">
                                    <option value="">-- Sélectionner une agence (optionnel) --</option>
                                    @if(isset($agences))
                                        @foreach($agences as $agence)
                                            <option value="{{ $agence->id }}">{{ $agence->nomAgence }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div>
                                <label for="telephone" class="block text-sm font-medium text-gray-700">Numéro de téléphone *</label>
                                <input type="tel" id="telephone" name="telephone" required autocomplete="tel" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border">
                            </div>
                            <div>
                                <label for="role" class="block text-sm font-medium text-gray-700">Rôle *</label>
                                <select id="role" name="role" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border">
                                    <option value="administrateur">Administrateur</option>
                                    <option value="utilisateur">Utilisateur</option>
                                </select>
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Email *</label>
                                <input type="email" id="email" name="email" required autocomplete="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border">
                            </div>
                            <div class="password-container">
                                <label for="password" class="block text-sm font-medium text-gray-700">Mot de passe *</label>
                                <input type="password" id="password" name="password" required autocomplete="new-password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border pr-10">
                                <button type="button" onclick="togglePassword('password')" class="password-toggle">
                                    <i class="fas fa-eye text-gray-400 hover:text-gray-600" id="passwordToggleIcon"></i>
                                </button>
                            </div>
                            <div class="password-container">
                                <label for="confirmPassword" class="block text-sm font-medium text-gray-700">Confirmer le mot de passe *</label>
                                <input type="password" id="confirmPassword" name="confirmPassword" required autocomplete="new-password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border pr-10">
                                <button type="button" onclick="togglePassword('confirmPassword')" class="password-toggle">
                                    <i class="fas fa-eye text-gray-400 hover:text-gray-600" id="confirmPasswordToggleIcon"></i>
                                </button>
                            </div>
                        </div>
                        <div class="flex justify-end space-x-4">
                            <button type="button" onclick="hideUserForm()" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md flex items-center">
                                <i class="fas fa-times mr-2"></i> Annuler
                            </button>
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md flex items-center">
                                <i class="fas fa-save mr-2"></i> Enregistrer
                            </button>
                        </div>
                    </form>
                </div>
            </section>

            <!-- Section Ajouter une agence -->
            <section id="agences" class="mb-12">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800 flex items-center">
                        <i class="fas fa-building text-green-600 mr-3"></i> Enregistrer une nouvelle agence
                    </h2>
                    <button onclick="showAgenceForm()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md flex items-center">
                        <i class="fas fa-plus mr-2"></i> Ajouter
                    </button>
                </div>

                <!-- Formulaire pour ajouter une agence -->
                <div id="agenceFormContainer" class="bg-white rounded-lg shadow-md p-6 hidden">
                    <form id="agenceForm" method="POST" action="{{ route('admin.agences.store') }}" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="numero" class="block text-sm font-medium text-gray-700">Numéro d'enregistrement *</label>
                                <input type="text" id="numero" name="numero" required autocomplete="organization" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border">
                            </div>
                            <div>
                                <label for="nomAgence" class="block text-sm font-medium text-gray-700">Nom de l'agence *</label>
                                <input type="text" id="nomAgence" name="nomAgence" required autocomplete="organization" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border">
                            </div>
                            <div>
                                <label for="fondateur" class="block text-sm font-medium text-gray-700">Nom du fondateur / responsable *</label>
                                <input type="text" id="fondateur" name="fondateur" required autocomplete="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border">
                            </div>
                            <div>
                                <label for="emailAgence" class="block text-sm font-medium text-gray-700">Email professionnel *</label>
                                <input type="email" id="emailAgence" name="emailAgence" required autocomplete="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border">
                            </div>
                            <div class="md:col-span-2">
                                <label for="adresse" class="block text-sm font-medium text-gray-700">Adresse complète *</label>
                                <input type="text" id="adresse" name="adresse" required autocomplete="street-address" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border">
                            </div>
                            <div>
                                <label for="telephoneAgence" class="block text-sm font-medium text-gray-700">Téléphone *</label>
                                <input type="tel" id="telephoneAgence" name="telephoneAgence" required autocomplete="tel" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border">
                            </div>
                            <div>
                                <label for="logo" class="block text-sm font-medium text-gray-700">Logo de l'agence *</label>
                                <input type="file" id="logo" name="logo" accept="image/*" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            </div>
                            <div>
                                <label for="document" class="block text-sm font-medium text-gray-700">Image de vérification officielle *</label>
                                <input type="file" id="document" name="document" accept="image/*" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            </div>
                        </div>
                        <div class="flex justify-end space-x-4">
                            <button type="button" onclick="hideAgenceForm()" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md flex items-center">
                                <i class="fas fa-times mr-2"></i> Annuler
                            </button>
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md flex items-center">
                                <i class="fas fa-save mr-2"></i> Enregistrer l'agence
                            </button>
                        </div>
                    </form>
                </div>
            </section>

            <!-- Section Utilisateurs validés -->
            <section id="utilisateurs" class="mb-12">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800 flex items-center">
                        <i class="fas fa-user-check text-green-600 mr-3"></i> Utilisateurs validés
                    </h2>
                    <div class="relative">
                        <select id="filterValidated" class="appearance-none bg-white border border-gray-300 rounded-md pl-3 pr-8 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="all">Tous les utilisateurs</option>
                            <option value="active">Actifs</option>
                            <option value="suspended">Suspendus</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            <i class="fas fa-chevron-down text-xs"></i>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Code</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rôle</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Agence</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200" id="validatedUsersTable">
                                <tr id="skeletonRow">
                                    <td colspan="6" class="px-6 py-4 text-center">
                                        <div class="flex flex-col items-center space-y-3">
                                            <div class="skeleton skeleton-text w-3/4"></div>
                                            <div class="skeleton skeleton-text w-1/2"></div>
                                            <div class="skeleton skeleton-text w-2/3"></div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex items-center justify-between">
                        <div class="text-sm text-gray-500">
                            Affichage de <span id="validatedStart">0</span> à <span id="validatedEnd">0</span> sur <span id="validatedTotal">0</span> utilisateurs
                        </div>
                        <div class="flex space-x-2">
                            <button id="prevValidated" class="px-3 py-1 border border-gray-300 rounded-md text-gray-700 bg-white cursor-not-allowed" >
                                Précédent
                            </button>
                            <button id="nextValidated" class="px-3 py-1 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                Suivant
                            </button>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Section Liste des agences -->
            <section class="mb-12">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800 flex items-center">
                        <i class="fas fa-building text-blue-600 mr-3"></i> Liste des agences
                    </h2>
                </div>

                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Numéro d'enregistrement</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nom</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Adresse</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Téléphone</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fondateur</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="agencesTable" class="bg-white divide-y divide-gray-200">
                                <tr id="skeletonRowAgencies">
                                    <td colspan="7" class="text-center px-6 py-4">
                                        <div class="flex flex-col items-center space-y-3">
                                            <div class="w-3/4 h-4 bg-gray-200 rounded animate-pulse"></div>
                                            <div class="w-1/2 h-4 bg-gray-200 rounded animate-pulse"></div>
                                            <div class="w-2/3 h-4 bg-gray-200 rounded animate-pulse"></div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="px-6 py-4 bg-gray-50 flex items-center justify-between border-t">
                        <div class="text-sm text-gray-500">
                            Total: <span id="agencesTotalCount">0</span> agences
                        </div>
                        <div class="flex space-x-2">
                            <button id="prevAgences" class="px-3 py-1 border rounded text-gray-700 bg-white cursor-not-allowed" disabled>Précédent</button>
                            <button id="nextAgences" class="px-3 py-1 border rounded text-gray-700 bg-white hover:bg-gray-50">Suivant</button>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-8 relative z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="flex items-center justify-center mb-4">
                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-600 to-indigo-600 flex items-center justify-center text-white font-bold">
                    <i class="fas fa-building"></i>
                </div>
                <span class="ml-2 text-lg font-bold text-blue-400">Immobilier<span class="text-blue-300">Pro</span></span>
            </div>
            <p class="text-gray-400 text-sm">
                &copy; 2025 Gestion Immobilière Pro. Tous droits réservés.
            </p>
        </div>
    </footer>

    <!-- Scripts généraux -->
    <script>
        // Variables globales
        let inscriptionsChart, rolesChart, performanceChart;
        let currentUserPage = 1;
        let currentAgencyPage = 1;

        // Fonctions communes
        function togglePassword(fieldId) {
            const passwordInput = document.getElementById(fieldId);
            const passwordIcon = document.getElementById(fieldId + 'ToggleIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                passwordIcon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                passwordIcon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }

        function toggleDropdown() {
            const dropdown = document.getElementById('adminDropdown');
            dropdown.classList.toggle('hidden');
        }

        function showUserForm() {
            document.getElementById('userFormContainer').classList.remove('hidden');
        }

        function hideUserForm() {
            document.getElementById('userFormContainer').classList.add('hidden');
            document.getElementById('userForm').reset();
        }

        function showAgenceForm() {
            document.getElementById('agenceFormContainer').classList.remove('hidden');
        }

        function hideAgenceForm() {
            document.getElementById('agenceFormContainer').classList.add('hidden');
            document.getElementById('agenceForm').reset();
        }

        function initCharts() {
            // Vérifier que Chart.js est chargé
            if (typeof Chart === 'undefined') {
                console.error('Chart.js n\'est pas chargé');
                return;
            }

            const ctxInscriptions = document.getElementById('inscriptionsChart').getContext('2d');
            if (inscriptionsChart) inscriptionsChart.destroy();
            inscriptionsChart = new Chart(ctxInscriptions, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
                    datasets: [{
                        label: 'Inscriptions',
                        data: [12, 19, 3, 5, 2, 3, 7],
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        fill: true,
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
            
            const ctxRoles = document.getElementById('rolesChart').getContext('2d');
            if (rolesChart) rolesChart.destroy();
            rolesChart = new Chart(ctxRoles, {
                type: 'pie',
                data: {
                    labels: ['Utilisateurs', 'Administrateurs'],
                    datasets: [{
                        data: [300, 50],
                        backgroundColor: ['#36A2EB', '#FF6384'],
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                }
            });

            // Nouveau graphique de performances
            const ctxPerformance = document.getElementById('performanceChart').getContext('2d');
            if (performanceChart) performanceChart.destroy();
            performanceChart = new Chart(ctxPerformance, {
                type: 'bar',
                data: {
                    labels: ['Bâtiments', 'Appartements', 'Locataires', 'Locations'],
                    datasets: [{
                        label: 'Nombre',
                        data: [25, 150, 120, 95],
                        backgroundColor: [
                            'rgba(54, 162, 235, 0.8)',
                            'rgba(255, 99, 132, 0.8)',
                            'rgba(255, 205, 86, 0.8)',
                            'rgba(75, 192, 192, 0.8)'
                        ],
                        borderColor: [
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 99, 132, 1)',
                            'rgba(255, 205, 86, 1)',
                            'rgba(75, 192, 192, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }

        function updateCharts() {
            fetch('/admin/stats')
                .then(response => response.json())
                .then(data => {
                    //console.log('Données reçues:', data);
                    
                    // Met à jour le graphique des inscriptions
                    if (inscriptionsChart && data.months && data.inscriptions) {
                        inscriptionsChart.data.labels = data.months;
                        inscriptionsChart.data.datasets[0].data = data.inscriptions;
                        inscriptionsChart.update();
                    }

                    // Met à jour le graphique des rôles
                    if (rolesChart && data.roles) {
                        rolesChart.data.labels = Object.keys(data.roles);
                        rolesChart.data.datasets[0].data = Object.values(data.roles);
                        rolesChart.update();
                    }

                    // Met à jour le graphique de performances avec les données réelles
                    if (performanceChart && data.performance) {
                        performanceChart.data.datasets[0].data = [
                            data.performance.batiments || 0,
                            data.performance.appartements || 0,
                            data.performance.locataires || 0,
                            data.performance.locations || 0
                        ];
                        performanceChart.update();
                    }

                    // Met à jour les statistiques dans les cartes
                    if (data.batiments_total !== undefined) {
                        document.getElementById('batimentsTotal').textContent = data.batiments_total;
                    }
                })
                .catch(error => {
                    console.error('Erreur lors du chargement des statistiques:', error);
                });
        }

        // Chargement des utilisateurs validés
        async function loadValidatedUsers(page = 1) {
            const tableBody = document.getElementById('validatedUsersTable');
            const filter = document.getElementById('filterValidated').value;
            const prevBtn = document.getElementById('prevValidated');
            const nextBtn = document.getElementById('nextValidated');
            const agencesTotal = document.getElementById('agencesTotal');
            const agencessemaine = document.getElementById('weeklyRegistrations');
            const agencesmois = document.getElementById('monthlyRegistrations');
            
            // Afficher le skeleton pendant le chargement
            tableBody.innerHTML = `
                <tr id="skeletonRow">
                    <td colspan="6" class="px-6 py-4 text-center">
                        <div class="flex flex-col items-center space-y-3">
                            <div class="skeleton skeleton-text w-3/4"></div>
                            <div class="skeleton skeleton-text w-1/2"></div>
                            <div class="skeleton skeleton-text w-2/3"></div>
                        </div>
                    </td>
                </tr>
            `;

            try {
                const response = await fetch(`/admin/users?page=${page}&filter=${filter}`);
                const data = await response.json();

                if (!data.success) throw new Error(data.message || 'Erreur de chargement');

                // Remplissage du tableau
                tableBody.innerHTML = '';
                data.users.forEach(user => {
                    const row = `
                        <tr>
                            <td class="px-6 py-4">${user.code}</td>
                            <td class="px-6 py-4">${user.nom} ${user.prenom}</td>
                            <td class="px-6 py-4">${user.email}</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full ${user.role === 'administrateur' ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800'}">
                                    ${user.role}
                                </span>
                            </td>
                            <td class="px-6 py-4">${user.agence ? user.agence.nomAgence : '-'}</td>
                            <td class="px-6 py-4">
                                <button class="text-blue-600 hover:underline" onclick="editUser(${user.id})">Modifier</button>
                                <button class="text-red-600 hover:underline ml-2" onclick="deleteUser(${user.id})">Supprimer</button>
                            </td>
                        </tr>
                    `;
                    tableBody.insertAdjacentHTML('beforeend', row);
                });

                // Boutons de pagination
                prevBtn.disabled = data.current_page <= 1;
                nextBtn.disabled = data.current_page >= data.last_page;
                agencesTotal.textContent = data.total;
                document.getElementById('validatedTotal').textContent = data.total;
                document.getElementById('validatedStart').textContent = data.from;
                document.getElementById('validatedEnd').textContent = data.to;
                
                prevBtn.classList.toggle('cursor-not-allowed', prevBtn.disabled);
                nextBtn.classList.toggle('cursor-not-allowed', nextBtn.disabled);
                agencessemaine.textContent = data.userssemaine;
                agencesmois.textContent = data.usersmois;
                
                currentUserPage = data.current_page;

            } catch (error) {
                tableBody.innerHTML = `<tr><td colspan="6" class="text-center p-4 text-red-600">${error.message}</td></tr>`;
            }
        }

        // Chargement des agences
        async function loadAgencies(page = 1) {
            const tableBody = document.getElementById('agencesTable');
            const agencesTotaux = document.getElementById('agencesTotaux');
            const agencesTotalCount = document.getElementById('agencesTotalCount');
            const prevBtn = document.getElementById('prevAgences');
            const nextBtn = document.getElementById('nextAgences');

            // Afficher le skeleton pendant le chargement
            tableBody.innerHTML = `
                <tr id="skeletonRowAgencies">
                    <td colspan="7" class="text-center px-6 py-4">
                        <div class="flex flex-col items-center space-y-3">
                            <div class="w-3/4 h-4 bg-gray-200 rounded animate-pulse"></div>
                            <div class="w-1/2 h-4 bg-gray-200 rounded animate-pulse"></div>
                            <div class="w-2/3 h-4 bg-gray-200 rounded animate-pulse"></div>
                        </div>
                    </td>
                </tr>
            `;

            try {
                const response = await fetch(`/admin/agences/list?page=${page}`);
                const data = await response.json();

                if (!data.success) throw new Error(data.message || 'Erreur de chargement');

                // Remplissage du tableau
                tableBody.innerHTML = '';
                if (data.agences.length === 0) {
                    tableBody.innerHTML = `<tr><td colspan="7" class="text-center p-4 text-gray-500">Aucune agence trouvée.</td></tr>`;
                } else {
                    data.agences.forEach(agence => {
                        const row = `
                            <tr>
                                <td class="px-6 py-4">${agence.numero}</td>
                                <td class="px-6 py-4">${agence.nomAgence}</td>
                                <td class="px-6 py-4">${agence.emailAgence}</td>
                                <td class="px-6 py-4">${agence.adresse}</td>
                                <td class="px-6 py-4">${agence.telephoneAgence}</td>
                                <td class="px-6 py-4">${agence.fondateur}</td>
                                <td class="px-6 py-4">
                                    <p class="text-blue-600 hover:underline ml-2"> ${agence.users ? agence.users.length : 0} agents</p>
                                    <button class="text-red-600 hover:underline ml-2" onclick="deleteAgency(${agence.id})">Supprimer</button>
                                    <button class="text-yellow-600 hover:underline ml-2" onclick="editAgency(${agence.id})">Modifier</button>
                                </td>
                            </tr>
                        `;
                        tableBody.insertAdjacentHTML('beforeend', row);
                    });
                }

                // Mise à jour des statistiques
                agencesTotaux.textContent = data.total;
                agencesTotalCount.textContent = data.total;

                // Pagination
                prevBtn.disabled = data.current_page <= 1;
                nextBtn.disabled = data.current_page >= data.last_page;

                prevBtn.classList.toggle('cursor-not-allowed', prevBtn.disabled);
                nextBtn.classList.toggle('cursor-not-allowed', nextBtn.disabled);

                currentAgencyPage = data.current_page;

            } catch (error) {
                tableBody.innerHTML = `<tr><td colspan="7" class="text-center p-4 text-red-600">${error.message}</td></tr>`;
            }
        }

        // Édition d'utilisateur
        function editUser(userId) {
            fetch(`/admin/users/${userId}/edit`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const user = data.user;
                        document.getElementById('nom').value = user.nom;
                        document.getElementById('prenom').value = user.prenom;
                        document.getElementById('agenceUser').value = user.agence || '';
                        document.getElementById('telephone').value = user.telephone;
                        document.getElementById('role').value = user.role;
                        document.getElementById('email').value = user.email;
                        
                        // Modifier le formulaire pour l'édition
                        const form = document.getElementById('userForm');
                        form.action = `/admin/users/${userId}`;
                        form.querySelector('button[type="submit"]').innerHTML = '<i class="fas fa-sync mr-2"></i> Mettre à jour';
                        
                        showUserForm();
                    } else {
                        alert('Erreur lors du chargement des données utilisateur');
                    }
                });
        }

        // Suppression d'utilisateur
        function deleteUser(userId) {
            if (confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')) {
                fetch(`/admin/users/${userId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        loadValidatedUsers();
                    }
                });
            }
        }

        // Édition agence
        function editAgency(agencyId) {
            fetch(`/admin/agences/${agencyId}/edit`)
                .then(response => response.json())
                .then(agence => {
                    document.getElementById('numero').value = agence.numero;
                    document.getElementById('nomAgence').value = agence.nomAgence;
                    document.getElementById('fondateur').value = agence.fondateur;
                    document.getElementById('emailAgence').value = agence.emailAgence;
                    document.getElementById('adresse').value = agence.adresse;
                    document.getElementById('telephoneAgence').value = agence.telephoneAgence;
                    
                    // Modifier le formulaire pour l'édition
                    showAgenceForm();
                    const form = document.getElementById('agenceForm');
                    form.action = `/admin/agences/${agencyId}`;
                    form.querySelector('button[type="submit"]').innerHTML = '<i class="fas fa-sync mr-2"></i> Mettre à jour';
                });
        }

        // Suppression agence
        function deleteAgency(agencyId) {
            if (confirm('Êtes-vous sûr de vouloir supprimer cette agence ?')) {
                fetch(`/admin/agences/${agencyId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        loadAgencies();
                    }
                });
            }
        }

        // Gestion du formulaire utilisateur
        document.getElementById('userForm').addEventListener('submit', async function(event) {
            event.preventDefault();

            const form = event.target;
            const submitBtn = form.querySelector('button[type="submit"]');
            const messageDiv = document.getElementById('formMessage');
            const token = document.querySelector('meta[name="csrf-token"]').content;

            // Validation des mots de passe
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirmPassword').value;

            if (password !== confirmPassword) {
                messageDiv.innerHTML = `<div class="bg-red-100 text-red-800 p-3 rounded">❌ Les mots de passe ne correspondent pas</div>`;
                return;
            }

            try {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Enregistrement...';

                const formData = new FormData(form);
                formData.append('password_confirmation', confirmPassword);

                const response = await fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': token
                    },
                    body: formData
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    messageDiv.innerHTML = `<div class="bg-green-100 text-green-800 p-3 rounded">✅ ${data.message}</div>`;
                    form.reset();
                    hideUserForm();
                    loadValidatedUsers();
                } else {
                    messageDiv.innerHTML = `<div class="bg-red-100 text-red-800 p-3 rounded">❌ ${data.message || 'Erreur lors de la création'}</div>`;
                }
            } catch (error) {
                messageDiv.innerHTML = `<div class="bg-red-100 text-red-800 p-3 rounded">❌ Erreur réseau: ${error.message}</div>`;
            } finally {
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fas fa-save mr-2"></i> Enregistrer';
            }
        });

        // Gestion du formulaire agence
        document.getElementById('agenceForm').addEventListener('submit', async function(event) {
            event.preventDefault();

            const form = event.target;
            const submitBtn = form.querySelector('button[type="submit"]');
            const messageDiv = document.getElementById('formMessage');
            const token = document.querySelector('meta[name="csrf-token"]').content;

            try {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Enregistrement...';

                const formData = new FormData(form);
                let method = 'POST';
                if (form.action.match(/\/agences\/(\d+)$/)) {
                    method = 'POST';
                    formData.append('_method', 'PATCH');
                }

                const response = await fetch(form.action, {
                    method: method,
                    headers: {
                        'X-CSRF-TOKEN': token
                    },
                    body: formData
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    messageDiv.innerHTML = `<div class="bg-green-100 text-green-800 p-3 rounded">✅ ${data.message}</div>`;
                    form.reset();
                    hideAgenceForm();
                    loadAgencies();
                } else {
                    messageDiv.innerHTML = `<div class="bg-red-100 text-red-800 p-3 rounded">❌ ${data.message || 'Erreur lors de la création'}</div>`;
                }
            } catch (error) {
                messageDiv.innerHTML = `<div class="bg-red-100 text-red-800 p-3 rounded">❌ Erreur réseau: ${error.message}</div>`;
            } finally {
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fas fa-save mr-2"></i> Enregistrer l\'agence';
            }
        });

        // Initialisation
        document.addEventListener('DOMContentLoaded', function() {
            // Attendre que Chart.js soit chargé
            if (typeof Chart !== 'undefined') {
                initCharts();
                updateCharts();
            } else {
                console.error('Chart.js n\'est pas disponible');
            }

            // Événements de pagination utilisateurs
            document.getElementById('prevValidated').addEventListener('click', () => {
                if (currentUserPage > 1) loadValidatedUsers(currentUserPage - 1);
            });

            document.getElementById('nextValidated').addEventListener('click', () => {
                loadValidatedUsers(currentUserPage + 1);
            });

            // Filtre utilisateurs
            document.getElementById('filterValidated').addEventListener('change', () => {
                loadValidatedUsers();
            });

            // Événements de pagination agences
            document.getElementById('prevAgences').addEventListener('click', () => {
                if (currentAgencyPage > 1) loadAgencies(currentAgencyPage - 1);
            });

            document.getElementById('nextAgences').addEventListener('click', () => {
                loadAgencies(currentAgencyPage + 1);
            });

            // Charger initialement
            loadValidatedUsers();
            loadAgencies();
        });

        // Fermer le dropdown si on clique ailleurs
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('adminDropdown');
            const button = event.target.closest('[onclick="toggleDropdown()"]');
            
            if (!button && !dropdown.contains(event.target)) {
                dropdown.classList.add('hidden');
            }
        });
    </script>
</body>
</html>