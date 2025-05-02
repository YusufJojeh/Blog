<?php

namespace App\Http\Controllers\Author;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\POST;
use Illuminate\Support\Facades\Auth;
class AuthorController extends Controller {
    public function __construct()
    {
        $this->middleware('auth:author');
    }

    public function index()
    {
        $authorId = Auth::guard('author')->id();

        // Post statistics
        $totalPosts = Post::where('author_id', $authorId)->count();
        $published = Post::where('author_id', $authorId)->where('status', 'published')->count();
        $drafts = Post::where('author_id', $authorId)->where('status', 'draft')->count();

        // Engagement trends (last 7 days comments)
        $engagement = Comment::whereHas('post', function ($q) use ($authorId) {
            $q->where('author_id', $authorId);
        })
        ->where('created_at', '>=', now()->subDays(7))
        ->selectRaw('DATE(created_at) as date, count(*) as count')
        ->groupBy('date')
        ->orderBy('date')
        ->get();

        // Spam reports
        $spamCount = Comment::whereHas('post', function ($q) use ($authorId) {
            $q->where('author_id', $authorId);
        })->where('flagged', true)->count();

        return view('author.dashboard', compact('totalPosts', 'published', 'drafts', 'engagement', 'spamCount'));
    }
}
