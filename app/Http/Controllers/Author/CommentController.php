<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function __construct()
    {
        // Apply auth middleware for the "author" guard
        $this->middleware('auth:author');
    }

    public function index()
    {
        
        $authorId = Auth::guard('author')->id();

        
        $comments = Comment::whereHas('post', function ($q) use ($authorId) {
            $q->where('author_id', $authorId);
        })->with(['post', 'user'])->paginate(10);

        return view('author.comments.index', compact('comments'));
    }

    public function approve(Comment $comment)
    {
        $authorId = Auth::guard('author')->id();
        
        abort_unless($comment->post->author_id === $authorId, 403);

        $comment->update(['approved' => true]);

        return back()->with('success', 'Comment approved.');
    }

    public function spam()
    {
        $authorId = Auth::guard('author')->id();

        
        $comments = Comment::whereHas('post', function ($q) use ($authorId) {
            $q->where('author_id', $authorId);
        })->where('flagged', true)
            ->with(['post', 'user'])->paginate(10);

        return view('author.comments.spam', compact('comments'));
    }
}