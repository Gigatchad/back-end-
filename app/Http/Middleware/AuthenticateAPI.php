<?php



namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticateAPI
{
    public function handle(Request $request, Closure $next)
    {
        try {
            // Vérifier si le token JWT est présent dans l'en-tête Authorization
            $token = $request->header('Authorization');

            if (!$token) {
                throw new \Exception('Token non fourni');
            }

            // Extraire le token du format 'Bearer <token>'
            $token = str_replace('Bearer ', '', $token);

            // Vérifier la validité du token JWT
            $user = Auth::guard('api')->authenticate($token);

            if (!$user) {
                throw new \Exception('Token invalide');
            }

            // Authentification réussie, autoriser la requête à continuer
            return $next($request);
        } catch (\Exception $e) {
            // Token invalide ou non fourni, renvoyer une réponse non autorisée
            return response()->json(['message' => $e->getMessage()], 401);
        }
    }
}
