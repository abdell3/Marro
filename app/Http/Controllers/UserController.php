<?php

namespace App\Http\Controllers;

use App\Services\Interfaces\AuthServiceInterface;
use App\Services\Interfaces\PostServiceInterface;
use App\Services\Interfaces\UserServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * @var UserServiceInterface
     */
    protected $userService;

    /**
     * @var AuthServiceInterface
     */
    protected $authService;

    /**
     * @var PostServiceInterface
     */
    protected $postService;

    /**
     * UserController constructor.
     */
    public function __construct(
        UserServiceInterface $userService,
        AuthServiceInterface $authService,
        PostServiceInterface $postService
    ) {
        $this->userService = $userService;
        $this->authService = $authService;
        $this->postService = $postService;
        
        // Apply auth middleware for all actions
        $this->middleware('auth');
    }

    /**
     * Display the user dashboard.
     */
    public function dashboard()
    {
        $user = $this->authService->user();
        $posts = $this->postService->getPostsByUser($user->id);
        $savedPosts = $this->userService->getSavedPosts($user->id);

        return view('users.dashboard', [
            'user' => $user,
            'posts' => $posts,
            'savedPosts' => $savedPosts
        ]);
    }

    /**
     * Display the user profile.
     */
    public function profile()
    {
        $user = $this->authService->user();

        return view('users.profile', [
            'user' => $user
        ]);
    }
    
    /**
     * Display the edit profile page.
     */
    public function editProfile()
    {
        $user = $this->authService->user();

        return view('users.edit-profile', [
            'user' => $user
        ]);
    }
    
    /**
     * Display the user settings page.
     */
    public function settings()
    {
        $user = $this->authService->user();

        return view('users.settings', [
            'user' => $user
        ]);
    }

    /**
     * Update the user profile.
     */
    public function updateProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nom' => ['required', 'string', 'max:255'],
            'prenom' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.auth()->id()],
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = $this->authService->user();
        
        $this->userService->updateUser($user->id, [
            'nom' => $request->input('nom'),
            'prenom' => $request->input('prenom'),
            'email' => $request->input('email'),
        ]);

        return redirect()->route('profile')
            ->with('success', 'Profil mis à jour avec succès.');
    }

    /**
     * Show the change password form.
     */
    public function showChangePasswordForm()
    {
        return view('users.change-password');
    }

    /**
     * Change the user password.
     */
    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => ['required', 'password'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator);
        }

        $user = $this->authService->user();
        
        $this->userService->updateUser($user->id, [
            'password' => $request->input('password'),
        ]);

        return redirect()->route('profile')
            ->with('success', 'Mot de passe changé avec succès.');
    }

    /**
     * Display the saved posts.
     */
    public function savedPosts()
    {
        $user = $this->authService->user();
        $savedPosts = $this->userService->getSavedPosts($user->id);

        return view('users.saved-posts', [
            'savedPosts' => $savedPosts
        ]);
    }

    /**
     * Display the user's communities.
     */
    public function communities()
    {
        $user = $this->authService->user();

        return view('users.communities', [
            'communities' => $user->communities
        ]);
    }
    
    /**
     * Display the user's subscribed communities.
     */
    public function myCommunities()
    {
        $user = $this->authService->user();
        $subscribedCommunities = $user->communities;

        return view('users.my-communities', [
            'communities' => $subscribedCommunities
        ]);
    }
    
    /**
     * Update user avatar.
     */
    public function updateAvatar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'avatar' => ['required', 'image', 'max:2048'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator);
        }

        $user = $this->authService->user();
        
        if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
            try {
                // Vérifier si le lien symbolique du stockage existe
                $publicStoragePath = public_path('storage');
                if (!file_exists($publicStoragePath) || !is_link($publicStoragePath)) {
                    // Créer ou réparer le lien symbolique
                    $this->repairStorageLink();
                }
                
                // Assurer que le dossier avatars existe avec les bonnes permissions
                $avatarsPath = storage_path('app/public/avatars');
                if (!file_exists($avatarsPath)) {
                    mkdir($avatarsPath, 0755, true);
                }
                
                // Supprimer l'ancien avatar s'il existe
                if ($user->avatar) {
                    $oldAvatarPath = storage_path('app/public/' . $user->avatar);
                    if (file_exists($oldAvatarPath)) {
                        @unlink($oldAvatarPath);
                    }
                }
                
                // Générer un nom de fichier unique
                $file = $request->file('avatar');
                $extension = $file->getClientOriginalExtension();
                $fileName = time() . '_' . uniqid() . '.' . $extension;
                
                // Déplacer le fichier vers le stockage
                $file->move(storage_path('app/public/avatars'), $fileName);
                $avatarPath = 'avatars/' . $fileName;
                
                // Définir les permissions du fichier
                chmod(storage_path('app/public/avatars/' . $fileName), 0644);
                
                // Mettre à jour l'utilisateur
                $this->userService->updateUser($user->id, [
                    'avatar' => $avatarPath,
                ]);
                
                // Effacer le cache
                \Illuminate\Support\Facades\Artisan::call('cache:clear');
                
                return redirect()->route('profile.edit')
                    ->with('success', 'Avatar mis à jour avec succès.');
            } catch (\Exception $e) {
                return redirect()->route('profile.edit')
                    ->with('error', 'Erreur lors de la mise à jour de l\'avatar: ' . $e->getMessage());
            }
        }

        return redirect()->route('profile.edit')
            ->with('error', 'Aucun fichier d\'image valide n\'a été téléchargé.');
    }
    
    /**
     * Helper function to repair storage link
     */
    private function repairStorageLink()
    {
        $publicStoragePath = public_path('storage');
        $storageAppPublicPath = storage_path('app/public');
        
        // Supprimer l'ancien lien s'il existe
        if (file_exists($publicStoragePath)) {
            if (is_link($publicStoragePath)) {
                @unlink($publicStoragePath);
            } elseif (is_dir($publicStoragePath)) {
                // Supprimer le dossier récursivement si c'est un dossier
                $this->rrmdir($publicStoragePath);
            }
        }
        
        // Créer le lien symbolique
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            // Sur Windows, utiliser artisan
            \Illuminate\Support\Facades\Artisan::call('storage:link');
        } else {
            // Sur Unix/Linux
            symlink($storageAppPublicPath, $publicStoragePath);
        }
        
        return file_exists($publicStoragePath);
    }
    
    /**
     * Helper function to recursively remove directories
     */
    private function rrmdir($dir) {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (is_dir($dir . "/" . $object)) {
                        $this->rrmdir($dir . "/" . $object);
                    } else {
                        @unlink($dir . "/" . $object);
                    }
                }
            }
            @rmdir($dir);
        }
    }
    
    /**
     * Update notification settings.
     */
    public function updateNotificationSettings(Request $request)
    {
        $user = $this->authService->user();
        
        $preferences = $user->preferences ?? [];
        $preferences['email_notifications'] = $request->has('email_notifications');
        $preferences['mention_notifications'] = $request->has('mention_notifications');
        $preferences['reply_notifications'] = $request->has('reply_notifications');
        
        $this->userService->updateUser($user->id, [
            'preferences' => $preferences,
        ]);

        return redirect()->route('settings')
            ->with('success', 'Préférences de notifications mises à jour avec succès.');
    }
    
    /**
     * Update privacy settings.
     */
    public function updatePrivacySettings(Request $request)
    {
        $user = $this->authService->user();
        
        $preferences = $user->preferences ?? [];
        $preferences['public_profile'] = $request->has('public_profile');
        $preferences['show_post_history'] = $request->has('show_post_history');
        
        $this->userService->updateUser($user->id, [
            'preferences' => $preferences,
        ]);

        return redirect()->route('settings')
            ->with('success', 'Paramètres de confidentialité mis à jour avec succès.');
    }
    
    /**
     * Delete user account.
     */
    public function deleteAccount()
    {
        $user = $this->authService->user();
        
        // Log the user out first
        $this->authService->logout();
        
        // Then delete the account
        $this->userService->deleteUser($user->id);

        return redirect()->route('home')
            ->with('success', 'Votre compte a été supprimé avec succès.');
    }
}
