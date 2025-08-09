<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialisation du mot de passe</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/app3.css') }}" type="text/css">
    <style>
        .floating-shapes {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 0;
        }
        
        .shape {
            position: absolute;
            background: linear-gradient(45deg, rgba(59, 130, 246, 0.3), rgba(147, 51, 234, 0.3));
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
        }
        
        .shape:nth-child(1) {
            width: 80px;
            height: 80px;
            top: 20%;
            left: 10%;
            animation-delay: 0s;
        }
        
        .shape:nth-child(2) {
            width: 60px;
            height: 60px;
            top: 60%;
            right: 20%;
            animation-delay: 2s;
        }
        
        .shape:nth-child(3) {
            width: 100px;
            height: 100px;
            bottom: 20%;
            left: 20%;
            animation-delay: 4s;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }
        
        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .input-field {
            transition: all 0.3s ease;
            background: rgba(249, 250, 251, 0.8);
        }
        
        .input-field:focus {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #3B82F6, #8B5CF6);
            transform: translateY(0);
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(59, 130, 246, 0.3);
        }
        
        .toggle-password {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #6B7280;
            cursor: pointer;
            transition: color 0.3s ease;
        }
        
        .toggle-password:hover {
            color: #3B82F6;
        }
        
        .strength-weak { background-color: #EF4444; width: 25%; }
        .strength-fair { background-color: #F59E0B; width: 50%; }
        .strength-good { background-color: #10B981; width: 75%; }
        .strength-strong { background-color: #059669; width: 100%; }
        
        .error-message {
            background: rgba(239, 68, 68, 0.1);
            border-left: 4px solid #EF4444;
            animation: slideIn 0.3s ease;
        }
        
        .success-message {
            background: rgba(16, 185, 129, 0.1);
            border-left: 4px solid #10B981;
            animation: slideIn 0.3s ease;
        }
        
        @keyframes slideIn {
            from { opacity: 0; transform: translateX(-20px); }
            to { opacity: 1; transform: translateX(0); }
        }
    </style>
</head>

<body class="min-h-screen bg-gradient-to-br from-blue-600 via-blue to-purple-0">
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

                <!-- Messages d'erreur Laravel -->
                @if ($errors->any())
                <div class="error-message rounded-lg p-4 mb-6">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-red-500 mt-0.5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                        </svg>
                        <div>
                            @foreach ($errors->all() as $error)
                                <p class="text-sm text-red-700">{{ $error }}</p>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif

                <!-- Message de succès -->
                @if (session('status'))
                <div class="success-message rounded-lg p-4 mb-6">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-green-500 mt-0.5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <div>
                            <p class="text-sm text-green-700">{{ session('status') }}</p>
                        </div>
                    </div>
                </div>
                @endif
                
                <form method="POST" action="{{ route('password.update') }}" class="space-y-6">
                    @csrf
                    
                    <!-- Token de réinitialisation -->
                    <input type="hidden" name="token" value="{{ $token ?? request('token') ?? '' }}">
                    
                    <!-- Email -->
                    <input type="hidden" name="email" value="{{ $email ?? request('email') ?? old('email') ?? '' }}">
                    
                    <div class="input-group">
                        <label for="email" class="block text-sm font-medium text-gray-700">Email
                            </label>
                            <div class="relative">
                                <input type="email" id="email" name="email" required
                                class="input-field w-full px-4 py-3 pr-12 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-800 @error('password') border-red-500 @enderror"
                                placeholder="Entrez votre Email">
                            </div>

                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                            Nouveau mot de passe
                        </label>
                        <div class="relative">
                            <input 
                                type="password" 
                                id="password" 
                                name="password" 
                                required 
                                class="input-field w-full px-4 py-3 pr-12 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-800 @error('password') border-red-500 @enderror"
                                placeholder="Entrez votre nouveau mot de passe"
                                autocomplete="new-password"
                            >
                            <button 
                                type="button" 
                                onclick="togglePassword('password')"
                                class="toggle-password"
                                tabindex="-1"
                                aria-label="Afficher le mot de passe"
                            >
                                <svg id="eye-icon-password" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="input-group">
                        <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                            Confirmer le mot de passe
                        </label>
                        <div class="relative">
                            <input 
                                type="password" 
                                id="password_confirmation" 
                                name="password_confirmation" 
                                required 
                                class="input-field w-full px-4 py-3 pr-12 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-800"
                                placeholder="Confirmez votre mot de passe"
                                autocomplete="new-password"
                            >
                            <button 
                                type="button" 
                                onclick="togglePassword('password_confirmation')"
                                class="toggle-password"
                                tabindex="-1"
                                aria-label="Afficher la confirmation"
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
                        <div id="strength-requirements" class="mt-2 text-xs text-gray-600">
                            <div class="grid grid-cols-2 gap-1">
                                <span id="req-length" class="flex items-center">
                                    <span class="w-2 h-2 rounded-full bg-gray-300 mr-1"></span>
                                    8+ caractères
                                </span>
                                <span id="req-uppercase" class="flex items-center">
                                    <span class="w-2 h-2 rounded-full bg-gray-300 mr-1"></span>
                                    Majuscule
                                </span>
                                <span id="req-lowercase" class="flex items-center">
                                    <span class="w-2 h-2 rounded-full bg-gray-300 mr-1"></span>
                                    Minuscule
                                </span>
                                <span id="req-number" class="flex items-center">
                                    <span class="w-2 h-2 rounded-full bg-gray-300 mr-1"></span>
                                    Chiffre
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <button 
                        type="submit" 
                        id="submitBtn"
                        class="btn-primary w-full text-white font-bold py-3 px-6 rounded-xl transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed"
                    >
                        <span id="submitText">Réinitialiser le mot de passe</span>
                        <span id="loadingText" style="display: none;" class="flex items-center justify-center">
                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Réinitialisation...
                        </span>
                    </button>
                    
                    <div class="text-center mt-6">
                        <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium transition-colors duration-300 flex items-center justify-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                            Retour à la connexion
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/reset-password.js') }}"></script>
    <script>
        // Toggle password visibility
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const icon = document.getElementById('eye-icon-' + (fieldId === 'password_confirmation' ? 'confirmation' : 'password'));
            
            if (field.type === 'password') {
                field.type = 'text';
                icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L8.464 8.464m1.414 1.414L21.707 21.707"></path>';
            } else {
                field.type = 'password';
                icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>';
            }
        }

        // Password strength checker
        document.getElementById('password').addEventListener('input', function(e) {
            const password = e.target.value;
            const strengthContainer = document.getElementById('password-strength');
            const strengthBar = document.getElementById('strength-bar');
            const strengthText = document.getElementById('strength-text');
            
            if (password.length === 0) {
                strengthContainer.style.display = 'none';
                return;
            }
            
            strengthContainer.style.display = 'block';
            
            // Check requirements
            const requirements = {
                length: password.length >= 8,
                uppercase: /[A-Z]/.test(password),
                lowercase: /[a-z]/.test(password),
                number: /[0-9]/.test(password)
            };
            
            // Update requirement indicators
            Object.keys(requirements).forEach(req => {
                const element = document.getElementById('req-' + req).querySelector('span');
                element.className = requirements[req] ? 
                    'w-2 h-2 rounded-full bg-green-500 mr-1' : 
                    'w-2 h-2 rounded-full bg-gray-300 mr-1';
            });
            
            // Calculate strength
            const score = Object.values(requirements).filter(Boolean).length;
            
            let strengthClass = '';
            let strengthLabel = '';
            
            switch(score) {
                case 1:
                    strengthClass = 'strength-weak';
                    strengthLabel = 'Faible';
                    break;
                case 2:
                    strengthClass = 'strength-fair';
                    strengthLabel = 'Acceptable';
                    break;
                case 3:
                    strengthClass = 'strength-good';
                    strengthLabel = 'Bonne';
                    break;
                case 4:
                    strengthClass = 'strength-strong';
                    strengthLabel = 'Forte';
                    break;
                default:
                    strengthClass = '';
                    strengthLabel = '';
            }
            
            strengthBar.className = `h-2 rounded-full transition-all duration-300 ${strengthClass}`;
            strengthText.textContent = strengthLabel;
            strengthText.className = `text-sm font-semibold ${
                score <= 1 ? 'text-red-500' : 
                score <= 2 ? 'text-yellow-500' : 
                'text-green-500'
            }`;
        });

        // Form submission with loading state
        document.getElementById('resetPasswordForm')?.addEventListener('submit', function(e) {
            const submitBtn = document.getElementById('submitBtn');
            const submitText = document.getElementById('submitText');
            const loadingText = document.getElementById('loadingText');
            
            // Show loading state
            submitBtn.disabled = true;
            submitText.style.display = 'none';
            loadingText.style.display = 'flex';
        });
    </script>
</body>
</html>