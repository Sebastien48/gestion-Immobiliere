<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agent - Gestion Immobilière</title>
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="bg-gray-100 flex flex-col min-h-screen">
    <!-- Header -->
    <header class="bg-white shadow-sm border-b border-gray-200 fixed w-full top-0 z-50">
        <div class="flex items-center justify-between px-6 py-3">
            <div class="flex items-center space-x-4">
                <button id="sidebarToggle" class="lg:hidden text-gray-600 hover:text-gray-900">
                    <i class="fas fa-bars text-xl"></i>
                </button>
                <h1 class="text-xl font-bold text-gray-800 hidden md:block">{{$agence ? $agence->nomAgence : 'Agence'}} </h1>
                
                <!-- Barre de recherche - Visible sur desktop -->
                <div class="hidden lg:flex items-center bg-gray-100 rounded-lg px-3 py-2 ml-4">
                    <i class="fas fa-search text-gray-400 mr-2"></i>
                    <input type="text" placeholder="Rechercher locataire, bâtiment..." 
                           class="bg-transparent outline-none text-sm w-64 placeholder-gray-500">
                </div>
            </div>
            
            <div class="flex items-center space-x-4">
                <!-- Barre de recherche mobile -->
                <button id="mobileSearchToggle" class="lg:hidden text-gray-600 hover:text-gray-900">
                    <i class="fas fa-search text-xl"></i>
                </button>
                
                <!-- Notifications -->
                <div class="relative">
                    <button class="text-gray-600 hover:text-gray-900 relative">
                        <i class="fas fa-bell text-xl"></i>
                        <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">3</span>
                    </button>
                </div>
                
                <!-- User Menu -->
                <div class="relative">
                    <button id="userMenuButton" class="flex items-center space-x-2 text-gray-600 hover:text-gray-900">
                        <!-- afficher le logo de l'agence avec les initiales superposées -->
                        <div class="relative">
                            @if(isset($logo1) && $logo1)
                                <img src="{{ asset('storage/' . $logo1) }}" alt="Logo Agence" class="w-8 h-8 rounded-full object-cover"> 
                                <!-- Initiales superposées sur le logo -->
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <span class="text-white font-bold text-xs drop-shadow-lg">{{$initiales ?? 'AG'}}</span>
                                </div>
                            @else
                                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-gray-600 to-indigo-600 flex items-center justify-center text-white font-bold text-xl">
                                    {{ $initiales ?? 'AG' }}
                                </div>
                            @endif
                        </div>
                        <span class="hidden md:block text-xl font-medium">{{$initiales ?? 'Agent'}}</span>
                        <i class="fas fa-chevron-down text-xs"></i>
                    </button>
                    
                    <div id="userMenu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-2">
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            <i class="fas fa-user mr-2"></i>Profil
                        </a>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            <i class="fas fa-cog mr-2"></i>Paramètres
                        </a>
                        <hr class="my-1">
                        <a href="{{route('logout')}}" class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                            <i class="fas fa-sign-out-alt mr-2"></i>Déconnexion
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Barre de recherche mobile (cachée par défaut) -->
        <div id="mobileSearchBar" class="lg:hidden hidden px-4 py-2 bg-white border-t border-gray-200">
            <div class="flex items-center bg-gray-100 rounded-lg px-3 py-2">
                <i class="fas fa-search text-gray-400 mr-2"></i>
                <input type="text" placeholder="Rechercher..." 
                       class="bg-transparent outline-none text-sm w-full">
            </div>
        </div>
    </header>

    <!-- Sidebar -->
    <aside id="sidebar" class="fixed left-0 top-0 w-64 h-full bg-blue-800 text-white transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out z-40 pt-16">
        <div class="p-4">
            <div class="flex items-center space-x-4">
                <a href="#" class="flex items-center">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-600 to-indigo-600 flex items-center justify-center text-white font-bold">
                        <i class="fas fa-building"></i>
                    </div>
                    <span class="ml-2 text-xl font-bold text-blue-1000">Immobilier<span class="text-blue-400">Pro</span></span>
                </a>
            </div>
        </div>
        
        <nav class="px-2 space-y-1">
            <!-- Tableau de bord -->
            <a href="{{route('home')}}" class="nav-item flex items-center space-x-3 px-4 py-3 rounded-lg text-blue-100 hover:bg-blue-700 hover:text-white transition-colors">
                <i class="fas fa-tachometer-alt w-5"></i>
                <span>Tableau de bord</span>
            </a>
            
            <!-- Bâtiments -->
            <a href="batiments/index.html" class="nav-item flex items-center space-x-3 px-4 py-3 rounded-lg text-blue-100 hover:bg-blue-700 hover:text-white transition-colors">
                <i class="fas fa-building w-5"></i>
                <span>Bâtiments</span>
            </a>
            
            <!-- Appartements -->
            <a href="/appartements" class="nav-item flex items-center space-x-3 px-4 py-3 rounded-lg text-blue-100 hover:bg-blue-700 hover:text-white transition-colors">
                <i class="fas fa-home w-5"></i>
                <span>Appartements</span>
            </a>
            
            <!-- Locataires -->
            <a href="/locataires" class="nav-item flex items-center space-x-3 px-4 py-3 rounded-lg text-blue-100 hover:bg-blue-700 hover:text-white transition-colors">
                <i class="fas fa-users w-5"></i>
                <span>Locataires</span>
            </a>
            
            <!-- Locations -->
            <a href="/locations" class="nav-item flex items-center space-x-3 px-4 py-3 rounded-lg text-blue-100 hover:bg-blue-700 hover:text-white transition-colors">
                <i class="fas fa-file-contract w-5"></i>
                <span>Locations</span>
            </a>
            
            <!-- Paiements -->
            <a href="/paiements" class="nav-item flex items-center space-x-3 px-4 py-3 rounded-lg text-blue-100 hover:bg-blue-700 hover:text-white transition-colors">
                <i class="fas fa-money-bill-wave w-5"></i>
                <span>Paiements</span>
            </a>
            
            <!-- Quittances -->
            <a href="/quittances" class="nav-item flex items-center space-x-3 px-4 py-3 rounded-lg text-blue-100 hover:bg-blue-700 hover:text-white transition-colors">
                <i class="fas fa-receipt w-5"></i>
                <span>Quittances</span>
            </a>
        </nav>
    </aside>

    <!-- Sidebar Overlay (Mobile) -->
    <div id="sidebarOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-30 lg:hidden hidden"></div>

    <!-- Main Content -->
    <main class="lg:ml-64 pt-16 flex-grow">
        <div class="p-6">
            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 py-4 lg:ml-64">
        <div class="container mx-auto px-6">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="text-sm text-gray-600 mb-2 md:mb-0">
                    © 2023 ImmobilierPro - Tous droits réservés
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Toggle Sidebar (Mobile)
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');

        sidebarToggle.addEventListener('click', () => {
            sidebar.classList.toggle('-translate-x-full');
            sidebarOverlay.classList.toggle('hidden');
        });

        sidebarOverlay.addEventListener('click', () => {
            sidebar.classList.add('-translate-x-full');
            sidebarOverlay.classList.add('hidden');
        });

        // User Menu Toggle
        const userMenuButton = document.getElementById('userMenuButton');
        const userMenu = document.getElementById('userMenu');

        userMenuButton.addEventListener('click', (e) => {
            e.stopPropagation();
            userMenu.classList.toggle('hidden');
        });

        document.addEventListener('click', () => {
            userMenu.classList.add('hidden');
        });

        // Mobile Search Toggle
        const mobileSearchToggle = document.getElementById('mobileSearchToggle');
        const mobileSearchBar = document.getElementById('mobileSearchBar');

        mobileSearchToggle.addEventListener('click', () => {
            mobileSearchBar.classList.toggle('hidden');
        });

        // Responsive sidebar
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 1024) {
                sidebar.classList.remove('-translate-x-full');
                sidebarOverlay.classList.add('hidden');
                mobileSearchBar.classList.add('hidden');
            }
        });

        // Highlight current page in sidebar
        $(document).ready(function() {
            const currentPath = window.location.pathname;
            $('.nav-item').each(function() {
                const linkPath = $(this).attr('href');
                if (currentPath === linkPath) {
                    $(this).addClass('bg-blue-700 text-white');
                    $(this).removeClass('text-blue-100 hover:bg-blue-700 hover:text-white');
                }
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
        const currentPath = window.location.pathname;
        const navItems = document.querySelectorAll('.nav-item');
        
        navItems.forEach(item => {
            const linkPath = new URL(item.href).pathname;
            if (currentPath === linkPath) {
                item.classList.add('bg-blue-700', 'text-white');
                item.classList.remove('text-blue-100', 'hover:bg-blue-700', 'hover:text-white');
                
                
            }
        });
    });
    </script>
</body>
</html>