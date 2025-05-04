<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
 
    public function __construct()
    {
        $this->middleware('auth:author');
    }

  
    public function index()
    {
        $posts = Post::with('category')
            ->where('author_id', Auth::id())
            ->where('status', 'published')
            ->where(function($q) {
                
                $q->whereNull('published_at')
                  ->orWhere('published_at', '<=', now());
            })
            ->latest('published_at')
            ->paginate(15);

        return view('author.posts.index', compact('posts'));
    }

   
    public function drafts()
    {
        $posts = Post::with('category')
            ->where('author_id', Auth::id())
            ->where('status', 'draft')
            ->latest()
            ->paginate(15);

        return view('author.posts.drafts', compact('posts'));
    }


    public function scheduled()
    {
        $posts = Post::with('category')
            ->where('author_id', Auth::id())
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '>', now())
            ->orderBy('published_at', 'asc')
            ->paginate(15);

        return view('author.posts.scheduled', compact('posts'));
    }

  
    public function create()
    {
        $categories = Category::pluck('name', 'id');
        return view('author.posts.create', compact('categories'));
    }

    
    public function store(Request $request)
    {
        $data = $request->validate([
            'title'        => 'required|string|max:255',
            'content'      => 'required',
            'image'        => 'nullable|image|max:2048',
            'category_id'  => 'nullable|exists:categories,id',
            'status'       => 'required|in:draft,published',
            'published_at' => 'nullable|date',
        ]);

        $data['author_id'] = Auth::id();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')
                                  ->store('posts', 'public');
        }

        Post::create($data);

        return redirect()
            ->route('author.posts.index')
            ->with('success', 'Post created successfully.');
    }

    
    public function edit(Post $post)
    {
        
        abort_unless($post->author_id === Auth::id(), 403);

        $categories = Category::pluck('name', 'id');
        return view('author.posts.edit', compact('post', 'categories'));
    }

   
    public function update(Request $request, Post $post)
    {
        abort_unless($post->author_id === Auth::id(), 403);

        $data = $request->validate([
            'title'        => 'required|string|max:255',
            'content'      => 'required',
            'image'        => 'nullable|image|max:2048',
            'category_id'  => 'nullable|exists:categories,id',
            'status'       => 'required|in:draft,published',
            'published_at' => 'nullable|date',
        ]);

        if ($request->hasFile('image')) {
            
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            $data['image'] = $request->file('image')
                                  ->store('posts', 'public');
        }

        $post->update($data);

        return redirect()
            ->route('author.posts.index')
            ->with('success', 'Post updated successfully.');
    }


    public function destroy(Post $post)
    {
        abort_unless($post->author_id === Auth::id(), 403);

        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }
        $post->delete();

        return back()->with('success', 'Post deleted successfully.');
    }
}