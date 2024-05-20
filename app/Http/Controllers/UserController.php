<?php




namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function addAdmin(Request $request, $userId)
    {
        // Vérifier si l'utilisateur actuel est un administrateur
        if (!$request->user()->isAdmin()) {
            return response()->json(['message' => 'Vous n\'êtes pas autorisé à effectuer cette action.'], 403);
        }

        // Récupérer l'utilisateur à promouvoir en tant qu'administrateur
        $user = User::findOrFail($userId);

        // Ajouter le rôle d'administrateur à l'utilisateur
        $user->is_admin = true;
        $user->save();

        return response()->json(['message' => 'L\'utilisateur a été ajouté en tant qu\'administrateur avec succès.']);
    }

    public function removeAdmin(Request $request, $userId)
    {
        // Vérifier si l'utilisateur actuel est un administrateur
        if (!$request->user()->isAdmin()) {
            return response()->json(['message' => 'Vous n\'êtes pas autorisé à effectuer cette action.'], 403);
        }

        // Récupérer l'utilisateur à supprimer de la liste des administrateurs
        $user = User::findOrFail($userId);

        // Supprimer le rôle d'administrateur de l'utilisateur
        $user->is_admin = false;
        $user->save();

        return response()->json(['message' => 'L\'utilisateur a été supprimé de la liste des administrateurs avec succès.']);
    }
}
