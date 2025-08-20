<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ImmobilierPro - Gestion Locative</title>
 
    <script src="https://cdn.tailwindcss.com"></script>   
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .glass-nav {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
        }
        .hero-gradient {
            background: linear-gradient(135deg, #1E3A8A 0%, #3B82F6 100%);
        }
        .feature-icon {
            background: linear-gradient(135deg, #3B82F6 0%, #1E3A8A 100%);
        }
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        .mobile-menu {
            display: none;
        }
        .mobile-menu.active {
            display: block;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navigation fixe -->
    <nav class="glass-nav fixed w-full top-0 z-50 border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-600 to-indigo-600 flex items-center justify-center text-white font-bold shadow-lg">
                        <i class="fas fa-building text-lg"></i>
                    </div>
                    <span class="text-xl font-bold text-blue-900">
                        Immobilier<span class="text-blue-500">Pro</span>
                    </span>
                </div>
                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-4">
                        <a href="#features" class="text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium transition-colors">Fonctionnalités</a>
                        <a href="#gestion" class="text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium transition-colors">Gestion Locative</a>
                        <a href="#stats" class="text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium transition-colors">Avantages</a>
                        <a href="#contact" class="text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium transition-colors">Contact</a>
                        <a href="{{route ('login')}}" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors">Connexion Agents</a>
                    </div>
                </div>
                <!-- Menu hamburger mobile -->
                <div class="md:hidden">
                    <button id="mobile-menu-btn" class="text-gray-700 hover:text-blue-600">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
            <!-- Menu mobile -->
            <div id="mobile-menu" class="mobile-menu md:hidden bg-white border-t border-gray-200">
                <div class="px-2 pt-2 pb-3 space-y-1">
                    <a href="#features" class="block px-3 py-2 text-gray-700 hover:text-blue-600 transition-colors">Fonctionnalités</a>
                    <a href="#gestion" class="block px-3 py-2 text-gray-700 hover:text-blue-600 transition-colors">Gestion Locative</a>
                    <a href="#stats" class="block px-3 py-2 text-gray-700 hover:text-blue-600 transition-colors">Avantages</a>
                    <a href="#contact" class="block px-3 py-2 text-gray-700 hover:text-blue-600 transition-colors">Contact</a>
                    <a href="{{route('login')}}" class="block px-3 py-2 bg-blue-600 text-white rounded-lg text-center mt-2">Connexion Agents</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Section Hero -->
    <section class="hero-gradient pt-32 pb-20 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <h1 class="text-4xl md:text-5xl font-bold mb-6 leading-tight">
                        Solution complète de 
                        <span class="text-blue-200">gestion immobilière</span> 
                        pour professionnels
                    </h1>
                    <p class="text-xl mb-8 text-blue-100 leading-relaxed">
                        Optimisez la gestion de votre parc immobilier, simplifiez la relation avec vos locataires 
                        et automatisez vos processus avec notre plateforme spécialisée.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{route('login')}}" class="bg-white text-blue-600 font-semibold px-8 py-4 rounded-xl hover:bg-gray-100 transition-all duration-300 text-center">
                            Accéder à la plateforme
                        </a>
                    </div>
                </div>
                <div class="relative">
                    <img src="https://images.unsplash.com/photo-1560518883-ce09059eeffa?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" 
                         alt="Gestion immobilière" 
                         class="rounded-2xl shadow-2xl border-8 border-white/20">
                </div>
            </div>
        </div>
    </section>

    <!-- Statistiques pour le marketing -->
    <section id="stats" class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <div class="text-center">
                    <div class="text-4xl font-bold text-blue-600">+500</div>
                    <div class="text-gray-600 mt-2">Bâtiments gérés</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold text-green-500">+2K</div>
                    <div class="text-gray-600 mt-2">Locataires</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold text-indigo-600">98%</div>
                    <div class="text-gray-600 mt-2">Paiements à temps</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold text-red-500">24/7</div>
                    <div class="text-gray-600 mt-2">Support disponible</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Fonctionnalités principales -->
    <section id="features" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Fonctionnalités Clés</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Tout ce dont vous avez besoin pour une gestion immobilière efficace
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Gestion des bâtiments -->
                <div class="bg-white rounded-2xl p-8 shadow-lg card-hover">
                    <div class="feature-icon w-16 h-16 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-building text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-4 text-gray-800">Gestion des Bâtiments</h3>
                    <p class="text-gray-600">
                        Enregistrez et gérez l'ensemble de vos propriétés avec toutes les informations techniques 
                        et administratives centralisées.
                    </p>
                </div>

                <!-- Gestion locative -->
                <div class="bg-white rounded-2xl p-8 shadow-lg card-hover">
                    <div class="feature-icon w-16 h-16 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-file-contract text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-4 text-gray-800">Contrats & Locations</h3>
                    <p class="text-gray-600">
                        Créez et suivez les contrats de location, renouvellements.
                    </p>
                </div>

                <!-- Paiements -->
                <div class="bg-white rounded-2xl p-8 shadow-lg card-hover">
                    <div class="feature-icon w-16 h-16 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-euro-sign text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-4 text-gray-800">Suivi des Paiements</h3>
                    <p class="text-gray-600">
                        Enregistrez les loyers, générez des quittances automatiques et visualisez 
                        les historiques de paiement.
                    </p>
                </div>

                <!-- Documents -->
                <div class="bg-white rounded-2xl p-8 shadow-lg card-hover">
                    <div class="feature-icon w-16 h-16 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-folder-open text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-4 text-gray-800">Gestion Documentaire</h3>
                    <p class="text-gray-600">
                        Centralisez tous vos documents (contrats, diagnostics, quittances) 
                        dans un espace sécurisé.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Gestion Locative -->
    <section id="gestion" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div class="order-2 lg:order-1">
                    <h2 class="text-3xl font-bold text-gray-800 mb-6">Gestion Locative Simplifiée</h2>
                    
                    <div class="space-y-8">
                        <div class="flex items-start">
                            <div class="bg-blue-100 w-10 h-10 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                                <i class="fas fa-check text-blue-600"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-800 mb-2">Suivi des Contrats</h3>
                                <p class="text-gray-600">
                                    Visualisez les dates clés (échéances, renouvellements).
                                </p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="bg-blue-100 w-10 h-10 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                                <i class="fas fa-check text-blue-600"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-800 mb-2">Quittances Automatiques</h3>
                                <p class="text-gray-600">
                                    Générez et envoyez des quittances PDF en un clic après chaque 
                                    paiement enregistré.
                                </p>
                            </div>  
                        </div>
                    </div>
                </div>
                
                <div class="order-1 lg:order-2 relative">
                    <img src="https://images.unsplash.com/photo-1554469384-e58fac16e23a?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" 
                         alt="Interface de gestion" 
                         class="rounded-2xl shadow-xl border-8 border-white h-90 object-cover">
                </div>
            </div>
        </div>
    </section>

    <!-- Section Contact -->
    
<!-- Section Contact corrigée -->
<section id="contact" class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold text-gray-800 mb-4">Contactez notre équipe</h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Vous souhaitez une démonstration ou avez des questions sur notre solution ?
            </p>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <div class="space-y-8">
                <div class="flex items-start">
                    <div class="bg-blue-500 w-12 h-12 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                        <i class="fas fa-phone-alt text-white"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Support Technique</h3>
                        <p class="text-gray-600">+225 01 01 98 48 88</p>
                        <p class="text-gray-500 text-sm">Lundi - Vendredi : 8h - 18h</p>
                    </div>
                </div>
                
                <div class="flex items-start">
                    <div class="bg-indigo-500 w-12 h-12 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                        <i class="fas fa-map-marker-alt text-white"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Siège</h3>
                        <p class="text-gray-600">Abidjan, Côte d'ivoire</p>
                        <p class="text-gray-500 text-sm">Sur rendez-vous uniquement</p>
                    </div>
                </div>
            </div>

            <!-- Formulaire de contact corrigé -->
            <form id="contact-form" class="bg-white rounded-2xl shadow-lg p-8 space-y-6" action="https://formspree.io/f/xdkdpgrn" method="POST">
                <div>
                    <label class="block text-gray-700 mb-1" for="name">Nom complet</label>
                    <input type="text" name="name" id="name" required class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Votre nom">
                </div>
                <div>
                    <label class="block text-gray-700 mb-1" for="email">Email professionnel</label>
                    <input type="email" name="email" id="email" required class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="contact@votreagence.com">
                </div>
                <div>
                    <label class="block text-gray-700 mb-1" for="message">Votre message</label>
                    <textarea name="message" id="message" rows="4" required class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none" placeholder="Décrivez vos besoins..."></textarea>
                </div>
                <button type="submit" id="submit-btn" class="w-full bg-blue-600 text-white font-semibold py-3 px-6 rounded-lg hover:bg-blue-700 transition-colors">
                    Envoyer la demande
                </button>
                
                <!-- Messages de statut -->
                <div id="success-message" class="hidden bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    ✓ Merci ! Votre message a été envoyé avec succès.
                </div>
                
                <div id="error-message" class="hidden bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    ✗ Une erreur s'est produite. Veuillez réessayer.
                </div>
            </form>
        </div>
    </div>
</section>

    <!-- Pied de page -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <div class="flex items-center justify-center mb-4">
                        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-600 to-indigo-600 flex items-center justify-center text-white font-bold">
                            <i class="fas fa-building"></i>
                        </div>
                        <span class="ml-2 text-lg font-bold text-blue-400">Immobilier<span class="text-blue-300">Pro</span></span>
                    </div>
                    <p class="text-gray-400 text-sm">
                        La solution tout-en-un pour la gestion professionnelle de votre parc immobilier.
                    </p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Plateforme</h3>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#features" class="hover:text-white transition-colors">Fonctionnalités</a></li>
                        <li><a href="#gestion" class="hover:text-white transition-colors">Gestion Locative</a></li>
                        <li><a href={{route('login')}} class="hover:text-white transition-colors">Espace Agent</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Ressources</h3>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-white transition-colors">Documentation</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">FAQ</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Blog</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Légal</h3>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-white transition-colors">Confidentialité</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Mentions légales</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400 text-sm">
                &copy; 2025 ImmobilierPro - Tous droits réservés
            </div>
        </div>
    </footer>

    <!-- Script pour menu mobile -->
    <script>
         document.getElementById('mobile-menu-btn').addEventListener('click', function () {
        document.getElementById('mobile-menu').classList.toggle('active');
    });

    // Gestion du formulaire de contact
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('contact-form');
        const successMessage = document.getElementById('success-message');
        const errorMessage = document.getElementById('error-message');
        const submitBtn = document.getElementById('submit-btn');

        form.addEventListener('submit', function (e) {
            // Ne pas empêcher l'envoi par défaut pour laisser Formspree traiter
            // e.preventDefault(); <- SUPPRIMÉ
            
            // Masquer les messages précédents
            successMessage.classList.add('hidden');
            errorMessage.classList.add('hidden');
            
            // Changer le texte du bouton pendant l'envoi
            submitBtn.textContent = 'Envoi en cours...';
            submitBtn.disabled = true;
            
            // Simuler un délai puis afficher le message de succès
            setTimeout(() => {
                successMessage.classList.remove('hidden');
                form.reset();
                submitBtn.textContent = 'Envoyer la demande';
                submitBtn.disabled = false;
            }, 2000);
        });
    });
    </script>
</body>
</html>