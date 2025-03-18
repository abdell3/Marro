<?php 


namespace App\Http\Controllers;

use App\Services\TagService;
use Illuminate\Http\Request;

class TagController extends Controller
{
    protected $tagService;

    public function __construct(TagService $tagService)
    {
        $this->tagService = $tagService;
    }

    public function index()
    {
        $tags = $this->tagService->getAllTags();
        return view('tags.index', compact('tags'));
    }

    public function show($id)
    {
        $tag = $this->tagService->getTagById($id);
        return view('tags.show', compact('tag'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:tags',
            'description' => 'nullable|string',
        ]);

        $this->tagService->createTag($data);
        return redirect()->route('tags.index');
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:tags,slug,' . $id,
            'description' => 'nullable|string',
        ]);

        $this->tagService->updateTag($id, $data);
        return redirect()->route('tags.index');
    }

    public function destroy($id)
    {
        $this->tagService->deleteTag($id);
        return redirect()->route('tags.index');
    }
}