<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mot de passe oublié</title>
   
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/app4.css') }}" type="text/css">

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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-800 mb-2">Mot de passe oublié ?</h2>
                    <p class="text-gray-600">Pas de problème ! Entrez vos informations ci-dessous</p>
                </div>
                
                <!-- Onglets -->
                <div class="flex mb-6 bg-gray-100 rounded-xl p-1">
                    <button 
                        class="tab-button flex-1 py-2 px-4 rounded-lg text-sm font-semibold active" 
                        onclick="switchTab('email')"
                        id="email-tab"
                    >
                        <svg class="w-4 h-4 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                        </svg>
                        Email
                    </button>
                    <button 
                        class="tab-button flex-1 py-2 px-4 rounded-lg text-sm font-semibold text-gray-600" 
                        onclick="switchTab('phone')"
                        id="phone-tab"
                    >
                        <svg class="w-4 h-4 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        Téléphone
                    </button>
                </div>
                
                <form id="forgot-password-form" class="space-y-6">
                    <!-- Formulaire Email -->
                    <div id="email-form" class="form-content">
                        <div class="relative">
                            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Adresse e-mail</label>
                            <div class="relative">
                                <input 
                                    type="email" 
                                    id="email" 
                                    name="email" 
                                    required 
                                    class="input-field has-icon w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-800"
                                    placeholder="exemple@email.com"
                                >
                                
                            </div>
                        </div>
                    </div>
                    
                    <!-- Formulaire Téléphone -->
                    <div id="phone-form" class="form-content" style="display: none;">
                        <div class="relative">
                            <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">Numéro de téléphone</label>
                            <div class="relative">
                                <input 
                                    type="tel" 
                                    id="phone" 
                                    name="phone" 
                                    class="input-field has-icon w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-800"
                                    placeholder="+225 01 02 03 04 05"
                                >
                                
                            </div>
                            <p class="text-xs text-gray-500 mt-2">Format: +225 XX XX XX XX XX</p>
                        </div>
                    </div>
                    
                    <button 
                        type="submit" 
                        class="btn-primary w-full text-white font-bold py-3 px-6 rounded-xl transition-all duration-300"
                        id="submit-btn"
                    >
                        Rédirection en cour ... <i class="fas fa-spinner fa-spin ml-2"></i>
                    </button>
                </form>
                
                <!-- Messages de succès et d'erreur -->
                <div id="success-message" class="success-message">
                    <p>✓ Un lien de réinitialisation a été envoyé avec succès !</p>
                </div>
                
                <div id="error-message" class="error-message">
                    <p>✗ Une erreur s'est produite. Veuillez réessayer.</p>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/password.js') }}"></script>
        
    </script>
</body>
</html>