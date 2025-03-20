<!-- <?php 

// namespace App\Http\Controllers\Admin;

// use App\Models\Category;
// use App\Models\Post;
// use App\Http\Requests\StorePostRequest;
// use App\Http\Requests\UpdatePostRequest;
// use App\Models\User;
// use App\Http\Controllers\Controller;

// class PostController extends Controller
// {
//     /**
//      * Display a listing of the resource.
//      */
//     public function index()
//     {
//         $posts = Post::with('user', 'category')->latest()->paginate(10); 
//         return view('admin.posts.index', compact('posts'));
//     }

//     /**
//      * Show the form for creating a new resource.
//      */
//     public function create()
//     {
//         $categories = Category::all();
//         $users = User::all();
//         return view('admin.posts.create', compact('categories', 'users'));
//     }

//     /**
//      * Store a newly created resource in storage.
//      */
//     public function store(StorePostRequest $request)
//     {
//         Post::create($request->validated());
//         return redirect()->route('admin.posts.index')->with('success', 'Post créé avec succès.');
//     }

//     /**
//      * Display the specified resource.
//      */
//     public function show(Post $post)
//     {
//         return view('admin.posts.show', compact('post'));
//     }

//     /**
//      * Show the form for editing the specified resource.
//      */
//     public function edit(Post $post)
//     {
//         $categories = Category::all();
//         $users = User::all();
//         return view('admin.posts.edit', compact('post', 'categories', 'users'));
//     }

//     /**
//      * Update the specified resource in storage.
//      */
//     public function update(UpdatePostRequest $request, Post $post)
//     {
//         $post->update($request->validated());
//         return redirect()->route('admin.posts.index')->with('success', 'Post mis à jour avec succès.');
//     }

//     /**
//      * Remove the specified resource from storage.
//      */
//     public function destroy(Post $post)
//     {
//         $post->delete();
//         return back()->with('success', 'Post supprimé avec succès.');
//     }
// }
