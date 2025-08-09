<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password as PasswordRule;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class ResetController extends Controller
{
    /**
     * Afficher le formulaire de réinitialisation (méthode originale)
     */
    public function index()
    {
        return view('auth.reset-password');
    }

    /**
     * Afficher le formulaire de réinitialisation avec token
     */
    public function showResetForm(Request $request, $token = null)
    {
        // Si pas de token dans l'URL, essayer de le récupérer depuis la requête
        if (!$token) {
            $token = $request->get('token');
        }

        // Vérifier que le token est présent
        if (!$token) {
            return redirect()->route('login')->withErrors([
                'token' => 'Token de réinitialisation manquant ou expiré.'
            ]);
        }

        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->email ?? $request->get('email')
        ]);
    }

    /**
     * Traiter la réinitialisation du mot de passe
     */
    public function reset(Request $request)
    {
        // Rate limiting pour éviter les attaques par force brute
        $key = 'password-reset:' . $request->ip();
        
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            return back()->withErrors([
                'email' => "Trop de tentatives. Réessayez dans {$seconds} secondes."
            ]);
        }

        // Validation personnalisée des données
        $validator = Validator::make($request->all(), [
            'token' => 'required|string',
            'email' => 'required|email|exists:users,email',
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                PasswordRule::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised()
            ],
        ], [
            // Messages d'erreur personnalisés
            'token.required' => 'Le token de réinitialisation est requis.',
            'email.required' => 'L\'adresse email est requise.',
            'email.email' => 'Le format de l\'email n\'est pas valide.',
            'email.exists' => 'Cette adresse email n\'existe pas dans notre système.',
            'password.required' => 'Le mot de passe est requis.',
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
            'password.confirmed' => 'Les mots de passe ne correspondent pas.',
            'password.mixed_case' => 'Le mot de passe doit contenir des majuscules et des minuscules.',
            'password.numbers' => 'Le mot de passe doit contenir au moins un chiffre.',
            'password.symbols' => 'Le mot de passe doit contenir au moins un caractère spécial.',
            'password.uncompromised' => 'Ce mot de passe a été compromis dans une fuite de données. Veuillez en choisir un autre.',
        ]);

        // Si la validation échoue
        if ($validator->fails()) {
            RateLimiter::hit($key);
            return back()
                ->withErrors($validator)
                ->withInput($request->except('password', 'password_confirmation'));
        }

        try {
            // Tentative de réinitialisation du mot de passe
            $status = Password::reset(
                $request->only('email', 'password', 'password_confirmation', 'token'),
                function ($user, $password) {
                    $this->updateUserPassword($user, $password);
                }
            );

            // Gestion des différents résultats
            switch ($status) {
                case Password::PASSWORD_RESET:
                    // Succès - effacer le rate limiting
                    RateLimiter::clear($key);
                    
                    // Log de sécurité
                    Log::info('Password reset successful', [
                        'email' => $request->email,
                        'ip' => $request->ip(),
                        'user_agent' => $request->userAgent(),
                        'timestamp' => now()
                    ]);

                    return redirect()->route('login')->with([
                        'success' => 'Votre mot de passe a été réinitialisé avec succès. Vous pouvez maintenant vous connecter avec votre nouveau mot de passe.',
                        'email' => $request->email // Pré-remplir l'email sur la page de connexion
                    ]);

                case Password::INVALID_TOKEN:
                    RateLimiter::hit($key);
                    return back()->withErrors([
                        'token' => 'Ce lien de réinitialisation est invalide ou a expiré. Veuillez demander un nouveau lien.'
                    ]);

                case Password::INVALID_USER:
                    RateLimiter::hit($key);
                    return back()->withErrors([
                        'email' => 'Aucun utilisateur trouvé avec cette adresse email.'
                    ]);

                default:
                    RateLimiter::hit($key);
                    return back()->withErrors([
                        'email' => 'Une erreur est survenue lors de la réinitialisation. Veuillez réessayer.'
                    ]);
            }

        } catch (\Exception $e) {
            // Log de l'erreur
            Log::error('Password reset error', [
                'email' => $request->email,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'ip' => $request->ip(),
                'timestamp' => now()
            ]);

            RateLimiter::hit($key);
            
            return back()->withErrors([
                'email' => 'Une erreur technique est survenue. Veuillez réessayer plus tard.'
            ]);
        }
    }

    /**
     * Mettre à jour le mot de passe de l'utilisateur
     */
    private function updateUserPassword($user, $password)
    {
        $user->forceFill([
            'password' => Hash::make($password),
            'remember_token' => Str::random(60),
            'password_changed_at' => now(), // Optionnel: tracker quand le mot de passe a été changé
        ])->save();

        // Révoquer tous les tokens d'accès existants (si vous utilisez Sanctum)
        if (method_exists($user, 'tokens')) {
            $user->tokens()->delete();
        }

        // Déclencher l'événement de réinitialisation
        event(new PasswordReset($user));

        // Log de sécurité
        Log::info('User password updated', [
            'user_id' => $user->id,
            'email' => $user->email,
            'timestamp' => now()
        ]);
    }

    /**
     * Afficher le formulaire de demande de réinitialisation
     */
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Envoyer le lien de réinitialisation
     */
    public function sendResetLinkEmail(Request $request)
    {
        // Rate limiting
        $key = 'password-reset-email:' . $request->ip();
        
        if (RateLimiter::tooManyAttempts($key, 3)) {
            $seconds = RateLimiter::availableIn($key);
            return back()->withErrors([
                'email' => "Trop de demandes. Réessayez dans {$seconds} secondes."
            ]);
        }

        $request->validate([
            'email' => 'required|email|exists:users,email'
        ], [
            'email.required' => 'L\'adresse email est requise.',
            'email.email' => 'Le format de l\'email n\'est pas valide.',
            'email.exists' => 'Cette adresse email n\'existe pas dans notre système.'
        ]);

        try {
            // Envoyer le lien de réinitialisation
            $status = Password::sendResetLink(
                $request->only('email')
            );

            if ($status === Password::RESET_LINK_SENT) {
                RateLimiter::hit($key, 300); // 5 minutes
                
                Log::info('Password reset link sent', [
                    'email' => $request->email,
                    'ip' => $request->ip(),
                    'timestamp' => now()
                ]);

                return back()->with([
                    'status' => 'Un lien de réinitialisation a été envoyé à votre adresse email.'
                ]);
            }

            RateLimiter::hit($key);
            return back()->withErrors([
                'email' => 'Impossible d\'envoyer le lien de réinitialisation.'
            ]);

        } catch (\Exception $e) {
            Log::error('Password reset link error', [
                'email' => $request->email,
                'error' => $e->getMessage(),
                'ip' => $request->ip(),
                'timestamp' => now()
            ]);

            RateLimiter::hit($key);
            return back()->withErrors([
                'email' => 'Une erreur est survenue. Veuillez réessayer plus tard.'
            ]);
        }
    }

    /**
     * Vérifier la validité d'un token sans le consommer
     */
    public function validateToken(Request $request, $token)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['valid' => false, 'message' => 'Utilisateur introuvable.']);
        }

        $tokenRecord = \DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        if (!$tokenRecord) {
            return response()->json(['valid' => false, 'message' => 'Token introuvable.']);
        }

        // Vérifier si le token a expiré (par défaut 60 minutes)
        $expiry = config('auth.passwords.users.expire', 60);
        $isExpired = \Carbon\Carbon::parse($tokenRecord->created_at)
            ->addMinutes($expiry)
            ->isPast();

        if ($isExpired) {
            return response()->json(['valid' => false, 'message' => 'Token expiré.']);
        }

        // Vérifier si le token correspond
        $isValid = Hash::check($token, $tokenRecord->token);

        return response()->json([
            'valid' => $isValid,
            'message' => $isValid ? 'Token valide.' : 'Token invalide.'
        ]);
    }

    /**
     * Nettoyer les tokens expirés (à exécuter périodiquement)
     */
    public function cleanExpiredTokens()
    {
        $expiry = config('auth.passwords.users.expire', 60);
        
        $deletedCount = \DB::table('password_reset_tokens')
            ->where('created_at', '<', now()->subMinutes($expiry))
            ->delete();

        Log::info('Expired password reset tokens cleaned', [
            'deleted_count' => $deletedCount,
            'timestamp' => now()
        ]);

        return response()->json([
            'message' => "Nettoyage terminé. {$deletedCount} tokens expirés supprimés."
        ]);
    }
}