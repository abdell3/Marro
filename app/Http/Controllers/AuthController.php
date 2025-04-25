<?php

namespace App\Http\Controllers;

use App\Services\Interfaces\AuthServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * @var AuthServiceInterface
     */
    protected $authService;

    /**
     * AuthController constructor.
     * 
     * @param AuthServiceInterface $authService
     */
    public function __construct(AuthServiceInterface $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Show the login form.
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }
        return view('auth.login');
    }

    /**
     * Handle login request.
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->except('password'));
        }

        $result = $this->authService->login(
            $request->input('email'),
            $request->input('password')
        );

        if (!$result['success']) {
            return redirect()->back()
                ->withErrors(['email' => $result['message']])
                ->withInput($request->except('password'));
        }

        // Force regenerate session to make sure user is logged in
        $request->session()->regenerate();

        return redirect()->intended(route('home'));
    }

    /**
     * Show the registration form.
     */
    public function showRegistrationForm()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }
        return view('auth.register');
    }

    /**
     * Handle registration request.
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nom' => ['required', 'string', 'max:255'],
            'prenom' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->except('password', 'password_confirmation'));
        }

        $user = $this->authService->register([
            'nom' => $request->input('nom'),
            'prenom' => $request->input('prenom'),
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ]);

        // Force regenerate session to make sure user is logged in
        $request->session()->regenerate();

        return redirect()->route('home');
    }

    /**
     * Handle logout request.
     */
    public function logout(Request $request)
    {
        $this->authService->logout();
        
        // Invalidate session
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }

    /**
     * Verify email.
     */
    public function verifyEmail(Request $request, $token)
    {
        $result = $this->authService->verifyEmail($token);

        if (!$result) {
            return redirect()->route('login')
                ->with('error', 'Lien de vérification invalide.');
        }

        return redirect()->route('login')
            ->with('success', 'Votre adresse email a été vérifiée avec succès.');
    }

    /**
     * Show the password reset request form.
     */
    public function showForgotPasswordForm()
    {
        return view('auth.passwords.email');
    }

    /**
     * Handle password reset request.
     */
    public function sendPasswordResetLink(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $result = $this->authService->sendPasswordResetLink($request->input('email'));

        if (!$result) {
            return redirect()->back()
                ->withErrors(['email' => 'Impossible de trouver un utilisateur avec cette adresse email.']);
        }

        return redirect()->back()
            ->with('success', 'Nous avons envoyé votre lien de réinitialisation de mot de passe par email.');
    }

    /**
     * Show the password reset form.
     */
    public function showResetPasswordForm($token)
    {
        return view('auth.passwords.reset', ['token' => $token]);
    }

    /**
     * Handle password reset.
     */
    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->except('password', 'password_confirmation'));
        }

        $result = $this->authService->resetPassword([
            'token' => $request->input('token'),
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ]);

        if (!$result) {
            return redirect()->back()
                ->withErrors(['email' => 'Le token est invalide ou a expiré.']);
        }

        return redirect()->route('login')
            ->with('success', 'Votre mot de passe a été réinitialisé avec succès.');
    }
}