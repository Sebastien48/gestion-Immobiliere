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
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class PasswordController extends Controller
{
    /**
     * Show the password reset form.
     */
    public function index()
    {
        return view('auth.password');
    }

     public function check(Request $request)
    {
        // Récupération des champs du formulaire
        $email = $request->input('email');
        $telephone = $request->input('telephone');

        // Recherche de l'utilisateur
        $user = User::where('email', $email)->where('telephone', $telephone)->first();

        if ($user) {
            // L'utilisateur existe, on peut l’aiguiller vers la suite
            return redirect()->route('password.request')->with([
                'success' => "Utilisateur trouvé, veuillez vérifier votre e-mail pour le lien de réinitialisation."
            ]);
        } else {
            // Aucune correspondance
            return back()->withErrors([
                'email' => "Aucun utilisateur correspondant n'a été trouvé avec cet e-mail et téléphone."
            ]);
        }
    }

    /**
     * Show the password reset form with token.
     */
    public function showResetForm(Request $request, $token = null)
    {
        $token = $token ?? $request->get('token');

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
     * Handle the password reset request.
     */
    public function reset(Request $request)
    {
        $key = 'password-reset:' . $request->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            return back()->withErrors([
                'email' => "Trop de tentatives. Réessayez dans {$seconds} secondes."
            ]);
        }

        $validator = Validator::make($request->all(), [
            'token'    => 'required|string',
            'email'    => 'required|email|exists:users,email',
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                PasswordRule::min(8)->mixedCase()->numbers()->symbols()->uncompromised()
            ],
        ], [
            'token.required'         => 'Le token de réinitialisation est requis.',
            'email.required'         => 'L\'adresse email est requise.',
            'email.email'            => 'Le format de l\'email n\'est pas valide.',
            'email.exists'           => 'Cette adresse email n\'existe pas dans notre système.',
            'password.required'      => 'Le mot de passe est requis.',
            'password.min'           => 'Le mot de passe doit contenir au moins 8 caractères.',
            'password.confirmed'     => 'Les mots de passe ne correspondent pas.',
            'password.mixed_case'    => 'Le mot de passe doit contenir des majuscules et des minuscules.',
            'password.numbers'       => 'Le mot de passe doit contenir au moins un chiffre.',
            'password.symbols'       => 'Le mot de passe doit contenir au moins un caractère spécial.',
            'password.uncompromised' => 'Ce mot de passe a été compromis dans une fuite de données. Veuillez en choisir un autre.',
        ]);

        if ($validator->fails()) {
            RateLimiter::hit($key);
            return back()
                ->withErrors($validator)
                ->withInput($request->except('password', 'password_confirmation'));
        }

        try {
            $status = Password::reset(
                $request->only('email', 'password', 'password_confirmation', 'token'),
                function ($user, $password) {
                    $this->updateUserPassword($user, $password);
                }
            );

            if ($status === Password::PASSWORD_RESET) {
                RateLimiter::clear($key);
                Log::info('Password reset successful', [
                    'email'      => $request->email,
                    'ip'         => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'timestamp'  => now(),
                ]);
                return redirect()->route('login')->with([
                    'success' => 'Votre mot de passe a été réinitialisé avec succès. Vous pouvez maintenant vous connecter avec votre nouveau mot de passe.',
                    'email'   => $request->email
                ]);
            }

            RateLimiter::hit($key);

            if ($status === Password::INVALID_TOKEN) {
                return back()->withErrors([
                    'token' => 'Ce lien de réinitialisation est invalide ou a expiré. Veuillez demander un nouveau lien.'
                ]);
            }
            if ($status === Password::INVALID_USER) {
                return back()->withErrors([
                    'email' => 'Aucun utilisateur trouvé avec cette adresse email.'
                ]);
            }

            return back()->withErrors([
                'email' => 'Une erreur est survenue lors de la réinitialisation. Veuillez réessayer.'
            ]);
        } catch (\Exception $e) {
            Log::error('Password reset error', [
                'email'    => $request->email,
                'error'    => $e->getMessage(),
                'trace'    => $e->getTraceAsString(),
                'ip'       => $request->ip(),
                'timestamp'=> now()
            ]);
            RateLimiter::hit($key);
            return back()->withErrors([
                'email' => 'Une erreur technique est survenue. Veuillez réessayer plus tard.'
            ]);
        }
    }

    /**
     * Update user password helper.
     */
    private function updateUserPassword($user, $password)
    {
        $user->forceFill([
            'password'            => Hash::make($password),
            'remember_token'      => Str::random(60),
            'password_changed_at' => now(), // Optional
        ])->save();

        // If the user uses Sanctum, revoke all tokens
        if (method_exists($user, 'tokens')) {
            $user->tokens()->delete();
        }

        event(new PasswordReset($user));

        Log::info('User password updated', [
            'user_id'   => $user->id,
            'email'     => $user->email,
            'timestamp' => now()
        ]);
    }

    /**
     * Show the reset link request form.
     */
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Send password reset link by email.
     */
    public function sendResetLinkEmail(Request $request)
    {
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
            'email.email'    => 'Le format de l\'email n\'est pas valide.',
            'email.exists'   => 'Cette adresse email n\'existe pas dans notre système.'
        ]);

        try {
            $status = Password::sendResetLink(
                $request->only('email')
            );

            if ($status === Password::RESET_LINK_SENT) {
                RateLimiter::hit($key, 300); // 5 min
                Log::info('Password reset link sent', [
                    'email'     => $request->email,
                    'ip'        => $request->ip(),
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
                'email'     => $request->email,
                'error'     => $e->getMessage(),
                'ip'        => $request->ip(),
                'timestamp' => now()
            ]);
            RateLimiter::hit($key);
            return back()->withErrors([
                'email' => 'Une erreur est survenue. Veuillez réessayer plus tard.'
            ]);
        }
    }

    /**
     * Validate a password reset token without consuming it.
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

        // Default Laravel table is 'password_resets'.
        $tokenRecord = DB::table('password_resets')
            ->where('email', $request->email)
            ->first();

        if (!$tokenRecord) {
            return response()->json(['valid' => false, 'message' => 'Token introuvable.']);
        }

        $expiry = config('auth.passwords.users.expire', 60);
        $isExpired = Carbon::parse($tokenRecord->created_at)
            ->addMinutes($expiry)
            ->isPast();

        if ($isExpired) {
            return response()->json(['valid' => false, 'message' => 'Token expiré.']);
        }

        $isValid = Hash::check($token, $tokenRecord->token);

        return response()->json([
            'valid'   => $isValid,
            'message' => $isValid ? 'Token valide.' : 'Token invalide.'
        ]);
    }

    /**
     * Clean expired tokens (run periodically with scheduler or admin).
     */
    public function cleanExpiredTokens()
    {
        $expiry = config('auth.passwords.users.expire', 60);

        $deletedCount = DB::table('password_resets')
            ->where('created_at', '<', now()->subMinutes($expiry))
            ->delete();

        Log::info('Expired password reset tokens cleaned', [
            'deleted_count' => $deletedCount,
            'timestamp'     => now()
        ]);

        return response()->json([
            'message' => "Nettoyage terminé. {$deletedCount} tokens expirés supprimés."
        ]);
    }
}