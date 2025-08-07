<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialisation du mot de passe</title>
  
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="/public/css/app3.css"  type="text/css">

</head>
<body>
    <div class="floating-shapes">
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
    </div>
    
    <div class="flex items-center justify-center min-h-screen px-4 relative z-10">
        <div class="w-full max-w-md">
            <div class="glass-card rounded-3xl shadow-2xl p-8">
                <div class="text-center mb-8">
                    <div class="w-16 h-16 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full mx-auto mb-4 flex items-center justify-center">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-800 mb-2">Nouveau mot de passe</h2>
                    <p class="text-gray-600">Choisissez un mot de passe sécurisé</p>
                </div>
                
                <form method="POST" action="" class="space-y-6">
                    @csrf
                    
                    <div class="input-group">
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Nouveau mot de passe</label>
                        <div class="relative">
                            <input 
                                type="password" 
                                id="password" 
                                name="password" 
                                required 
                                class="input-field w-full px-4 py-3 pr-12 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-800"
                                placeholder="Entrez votre nouveau mot de passe"
                            >
                            <button 
                                type="button" 
                                onclick="togglePassword('password')"
                                class="toggle-password"
                                tabindex="-1"
                            >
                                <svg id="eye-icon-password" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">Confirmer le mot de passe</label>
                        <div class="relative">
                            <input 
                                type="password" 
                                id="password_confirmation" 
                                name="password_confirmation" 
                                required 
                                class="input-field w-full px-4 py-3 pr-12 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-800"
                                placeholder="Confirmez votre mot de passe"
                            >
                            <button 
                                type="button" 
                                onclick="togglePassword('password_confirmation')"
                                class="toggle-password"
                                tabindex="-1"
                            >
                                <svg id="eye-icon-confirmation" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Indicateur de force du mot de passe -->
                    <div class="password-strength" id="password-strength" style="display: none;">
                        <div class="flex items-center space-x-2 mb-2">
                            <span class="text-sm font-medium text-gray-700">Force du mot de passe:</span>
                            <span id="strength-text" class="text-sm font-semibold"></span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div id="strength-bar" class="h-2 rounded-full transition-all duration-300"></div>
                        </div>
                    </div>
                    
                    <button 
                        type="submit" 
                        class="btn-primary w-full text-white font-bold py-3 px-6 rounded-xl transition-all duration-300"
                    >
                        Réinitialiser le mot de passe
                    </button>
                    
                    <div class="text-center mt-6">
                        <a href="login.html" class="text-blue-600 hover:text-blue-800 text-sm font-medium transition-colors duration-300">
                            Retour à la connexion
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="/public/js/reset-password.js"></script>
        
    </script>
</body>
</html>