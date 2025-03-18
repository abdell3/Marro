<?php 



namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Category;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * 
     */
    public function index()
    {
        
        $totalUsers = User::count();
        $totalPosts = Post::count();
        $totalComments = Comment::count();
        $totalCategories = Category::count();

        
        $recentUsers = User::latest()->take(5)->get();

        
        $recentPosts = Post::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalPosts',
            'totalComments',
            'totalCategories',
            'recentUsers',
            'recentPosts'
        ));
    }

    /**
     * 
     */
    public function users()
    {
        $users = User::latest()->paginate(10); 
        return view('admin.users.index', compact('users'));
    }

    /**
     *
     */
    public function showUser(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * 
     */
    public function toggleUserStatus(User $user)
    {
        $user->update(['is_active' => !$user->is_active]);
        return back()->with('success', 'Statut de l\'utilisateur mis à jour.');
    }

    /**
     * 
     */
    public function deleteUser(User $user)
    {
        $user->delete();
        return back()->with('success', 'Utilisateur supprimé avec succès.');
    }

    /**
     * 
     */
    public function posts()
    {
        $posts = Post::with('user', 'category')->latest()->paginate(10); 
        return view('admin.posts.index', compact('posts'));
    }

    /**
     * 
     */
    public function showPost(Post $post)
    {
        return view('admin.posts.show', compact('post'));
    }

    /**
     * 
     */
    public function deletePost(Post $post)
    {
        $post->delete();
        return back()->with('success', 'Post supprimé avec succès.');
    }

    /**
     * 
     */
    public function comments()
    {
        $comments = Comment::with('user', 'post')->latest()->paginate(10); 
        return view('admin.comments.index', compact('comments'));
    }

    /**
     * 
     */
    public function deleteComment(Comment $comment)
    {
        $comment->delete();
        return back()->with('success', 'Commentaire supprimé avec succès.');
    }

    /**
     *
     */
    public function categories()
    {
        $categories = Category::latest()->paginate(10); 
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * 
     */
    public function createCategory()
    {
        return view('admin.categories.create');
    }

    /**
     * 
     */
    public function storeCategory(Request $request)
    {
        

        Category::create($request->validated());
        return redirect()->route('admin.categories.index')->with('success', 'Catégorie créée avec succès.');
    }

    /**
     * 
     */
    public function editCategory(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * 
     */
    public function updateCategory(Request $request, Category $category)
    {

        $category->update($request->validated());
        return redirect()->route('admin.categories.index')->with('success', 'Catégorie mise à jour avec succès.');
    }

    /**
     * 
     */
    public function deleteCategory(Category $category)
    {
        $category->delete();
        return back()->with('success', 'Catégorie supprimée avec succès.');
    }
}

