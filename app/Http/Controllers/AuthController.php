<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Validation des données du formulaire de connexion
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Tentative de connexion de l'utilisateur
        if (Auth::attempt($credentials)) {
            // Authentification réussie, générer un token JWT et le renvoyer au client
            $token = Auth::user()->createToken('authToken')->plainTextToken;
            return response()->json(['token' => $token], 200);
        } else {
            // Authentification échouée
            return response()->json(['error' => 'Email ou mot de passe incorrect'], 401);
        }
    }

    public function register(Request $request)
    {
        // Validation des données du formulaire d'inscription
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        // Création d'un nouvel utilisateur
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        // Authentification automatique de l'utilisateur après son inscription
        Auth::login($user);

        // Génération d'un token JWT et envoi au client
        $token = $user->createToken('authToken')->plainTextToken;
        return response()->json(['token' => $token], 201);
    }

    public function logout(Request $request)
    {
        // Déconnexion de l'utilisateur et révocation du token
        $request->user()->currentAccessToken()->delete();

        // Déconnexion de l'utilisateur
        Auth::logout();

        return response()->json(['message' => 'Déconnexion réussie'], 200);
    }
}

