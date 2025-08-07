<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription Agent - Gestion Immobilière</title>
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .blue-gradient {
            background: linear-gradient(135deg, #1E3A8A, #3B82F6);
        }
    </style>
</head>
<body class="bg-gray-50 font-sans">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-4">
                    <a href="#" class="flex items-center">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-600 to-indigo-600 flex items-center justify-center text-white font-bold">
                            <i class="fas fa-building"></i>
                        </div>
                        <span class="ml-2 text-xl font-bold text-blue-900">Immobilier<span class="text-blue-500">Pro</span></span>
                    </a>
                </div>
                <div class="flex items-center">
                    <a href="{{route('login')}}" class="text-blue-600 hover:text-blue-700 font-medium">
                        Déjà inscrit ? <span class="font-bold">Se connecter</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>
     <!-- Zone pour afficher les messages -->
     <div id="formMessage" class="mb-4"></div> <!-- Zone pour afficher les messages -->
     

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
            <!-- Left Column - Illustration -->
            <div class="hidden md:block">
                <div class="blue-gradient rounded-2xl p-8 text-white">
                    <h2 class="text-3xl font-bold mb-4">Rejoignez Immobilier<span class="text-blue-400">Pro</span></h2>
                    <p class="text-xl mb-6">Gérez vos propriétés et locataires avec notre plateforme professionnelle.</p>
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <div class="bg-white text-blue-600 rounded-full p-2 mr-4">
                                <i class="fas fa-home text-lg"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-lg">Gestion centralisée</h3>
                                <p class="opacity-90">Tous vos biens immobiliers dans une seule interface</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="bg-white text-blue-600 rounded-full p-2 mr-4">
                                <i class="fas fa-file-invoice-dollar text-lg"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-lg">Quittances automatiques</h3>
                                <p class="opacity-90">Générez et envoyez les quittances en quelques clics</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="bg-white text-blue-600 rounded-full p-2 mr-4">
                                <i class="fas fa-chart-line text-lg"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-lg">Tableaux de bord</h3>
                                <p class="opacity-90">Suivez vos indicateurs clés en temps réel</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Form -->
            <div>
                <div class="bg-white rounded-xl shadow-lg p-8">
                    <div class="text-center mb-8">
                        <h1 class="text-3xl font-bold text-gray-800 mb-2">Créer un compte Agent</h1>
                        <p class="text-gray-600">Inscrivez-vous pour gérer vos propriétés et locataires</p>
                    </div>

                    <!-- Affichage des erreurs générales -->
                    @if ($errors->any())
                        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-exclamation-triangle text-red-400"></i>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-red-800">
                                        Erreurs de validation
                                    </h3>
                                    <div class="mt-2 text-sm text-red-700">
                                        <ul class="list-disc pl-5 space-y-1">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <form class="space-y-4" action="{{route('register.post')}}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="nom" class="block text-sm font-medium text-gray-700 mb-1">Nom</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-user text-gray-400"></i>
                                    </div>
                                    <input type="text" id="nom" name="nom" required 
                                        class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('nom') border-red-500 @enderror"
                                        placeholder="Votre nom" value="{{ old('nom') }}">
                                    @error('nom')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div>
                                <label for="prenom" class="block text-sm font-medium text-gray-700 mb-1">Prénom</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-user text-gray-400"></i>
                                    </div>
                                    <input type="text" id="prenom" name="prenom" required 
                                        class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('prenom') border-red-500 @enderror"
                                        placeholder="Votre prénom" value="{{ old('prenom') }}">
                                    @error('prenom')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email professionnel</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-envelope text-gray-400"></i>
                                </div>
                                <input type="email" id="email" name="email" required 
                                    class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('email') border-red-500 @enderror"
                                    placeholder="email@agence.com" value="{{ old('email') }}">
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label for="telephone" class="block text-sm font-medium text-gray-700 mb-1">Téléphone</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-phone text-gray-400"></i>
                                </div>
                                <input type="tel" id="telephone" name="telephone" required 
                                    class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('telephone') border-red-500 @enderror"
                                    placeholder="Votre numéro de téléphone" value="{{ old('telephone') }}">
                                @error('telephone')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label for="nomAgence" class="block text-sm font-medium text-gray-700 mb-1">Agence</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-building text-gray-400"></i>
                                </div>
                                <select id="nomAgence" name="nomAgence" required
                                    class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('nomAgence') border-red-500 @enderror">
                                    <option value="">Sélectionnez votre agence</option>
                                    @foreach($agences as $agence)
                                        <option value="{{ $agence->nomAgence }}" {{ old('nomAgence') == $agence->nomAgence ? 'selected' : '' }}>
                                            {{ $agence->nomAgence }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('nomAgence')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Mot de passe</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-lock text-gray-400"></i>
                                </div>
                                <input type="password" id="password" name="password" required 
                                    class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('password') border-red-500 @enderror"
                                    placeholder="Créez un mot de passe">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                    <i class="fas fa-eye text-gray-400 cursor-pointer toggle-password"></i>
                                </div>
                            </div>
                            <p class="mt-1 text-xs text-gray-500">Minimum 4 à 8 caractères avec des chiffres et lettres</p>
                            @error('password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="confirmPassword" class="block text-sm font-medium text-gray-700 mb-1">Confirmer le mot de passe</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-lock text-gray-400"></i>
                                </div>
                                <input type="password" id="confirmPassword" name="password_confirmation" required 
                                    class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('password_confirmation') border-red-500 @enderror"
                                    placeholder="Confirmez votre mot de passe">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                    <i class="fas fa-eye text-gray-400 cursor-pointer toggle-password"></i>
                                </div>
                            </div>
                            @error('password_confirmation')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input id="conditions" name="conditions" type="checkbox" required
                                    class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="conditions" class="font-medium text-gray-700">
                                    J'accepte les <a href="#" class="text-blue-600 hover:text-blue-500">conditions d'utilisation</a> et la <a href="#" class="text-blue-600 hover:text-blue-500">politique de confidentialité</a>
                                </label>
                            </div>
                        </div>

                        <div>
                            <button type="submit" 
                                class="w-full blue-gradient text-white py-3 px-4 rounded-lg font-bold text-lg hover:opacity-90 transition duration-300 flex items-center justify-center">
                                <i class="fas fa-user-tie mr-2"></i> S'inscrire comme Agent
                            </button>
                        </div>

                        <div class="text-center text-sm text-gray-600">
                            Déjà inscrit ? 
                            <a href="{{route('login')}}" class="font-medium text-blue-600 hover:text-blue-500">
                                Connectez-vous ici
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-8 mt-12">
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

    <script>
        // Fonction pour basculer la visibilité du mot de passe
        document.querySelectorAll('.toggle-password').forEach(icon => {
            icon.addEventListener('click', function() {
                const input = this.closest('.relative').querySelector('input');
                const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
                input.setAttribute('type', type);
                this.classList.toggle('fa-eye-slash');
                this.classList.toggle('fa-eye');
            });
        });
    </script>
</body>
</html>