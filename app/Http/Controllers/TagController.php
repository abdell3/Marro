<?php 


namespace App\Http\Controllers;

use App\Http\Requests\StoreTagRequest;
use App\Http\Requests\UpdateTagRequest;
use App\Services\TagService;
use Illuminate\Http\Request;

class TagController extends Controller
{
    protected $tagService;

    public function __construct(TagService $tagService)
    {
        $this->tagService = $tagService;
        $this->middleware('auth')->except(['index', 'show']);
        $this->middleware('can:admin')->except(['index', 'show']);
    }

    public function index()
    {
        $tags = $this->tagService->getAllTags();
        return view('tags.index', compact('tags'));
    }

    public function create()
    {
        return view('tags.create');
    }

    public function store(StoreTagRequest $request)
    {
        $this->tagService->createTag($request->validated());
        return redirect()->route('tags.index')->with('success', 'Tag created successfully.');
    }

    public function show($slug)
    {
        $tag = $this->tagService->getTagBySlug($slug);
        $posts = $this->tagService->getPostsByTag($tag->id);
        return view('tags.show', compact('tag', 'posts'));
    }

    public function edit($id)
    {
        $tag = $this->tagService->getTagById($id);
        return view('tags.edit', compact('tag'));
    }

    public function update(UpdateTagRequest $request, $id)
    {
        $this->tagService->updateTag($id, $request->validated());
        return redirect()->route('tags.index')->with('success', 'Tag updated successfully.');
    }

    public function destroy($id)
    {
        $this->tagService->deleteTag($id);
        return redirect()->route('tags.index')->with('success', 'Tag deleted successfully.');
    }
}