<?php



namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Afficher la liste des utilisateurs.
     */
    public function index()
    {
        // Récupérer tous les utilisateurs avec pagination
        $users = User::latest()->paginate(10); // 10 utilisateurs par page
        return view('admin.users.index', compact('users'));
    }

    /**
     * Afficher les détails d'un utilisateur.
     */
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * Activer ou désactiver un utilisateur.
     */
    public function toggleStatus(User $user)
    {
        // Basculer le statut actif/inactif
        $user->update(['is_active' => !$user->is_active]);

        // Rediriger avec un message de succès
        return back()->with('success', 'Statut de l\'utilisateur mis à jour.');
    }

    /**
     * Supprimer un utilisateur.
     */
    public function destroy(User $user)
    {
        // Supprimer l'utilisateur
        $user->delete();

        // Rediriger avec un message de succès
        return back()->with('success', 'Utilisateur supprimé avec succès.');
    }
}