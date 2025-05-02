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
    /**
     * Only authenticated authors may access these methods.
     */
    public function __construct()
    {
        $this->middleware('auth:author');
    }

    /**
     * Show published posts belonging to the current author.
     */
    public function index()
    {
        $posts = Post::with('category')
            ->where('author_id', Auth::id())
            ->where('status', 'published')
            ->where(function($q) {
                // Only those whose published_at is now or in the past
                $q->whereNull('published_at')
                  ->orWhere('published_at', '<=', now());
            })
            ->latest('published_at')
            ->paginate(15);

        return view('author.posts.index', compact('posts'));
    }

    /**
     * Show drafts belonging to the current author.
     */
    public function drafts()
    {
        $posts = Post::with('category')
            ->where('author_id', Auth::id())
            ->where('status', 'draft')
            ->latest()
            ->paginate(15);

        return view('author.posts.drafts', compact('posts'));
    }

    /**
     * Show scheduled posts (published but with a future published_at).
     */
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

    /**
     * Show the form for creating a new post.
     */
    public function create()
    {
        $categories = Category::pluck('name', 'id');
        return view('author.posts.create', compact('categories'));
    }

    /**
     * Store a newly created post.
     */
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

        // Associate with current author
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

    /**
     * Show the form for editing an existing post.
     */
    public function edit(Post $post)
    {
        // Ensure this author owns the post
        abort_unless($post->author_id === Auth::id(), 403);

        $categories = Category::pluck('name', 'id');
        return view('author.posts.edit', compact('post', 'categories'));
    }

    /**
     * Update an existing post.
     */
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
            // delete old image if exists
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

    /**
     * Delete a post.
     */
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
