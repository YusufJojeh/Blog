<?php

namespace App\Http\Controllers\Reader;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class CommentController extends Controller {
    public function __construct() {
        // Apply auth middleware for the 'reader' guard
        $this->middleware( 'auth:reader' );
    }

    public function index() {
        $readerId = Auth::guard( 'reader' )->id();
        $comments = Comment::where( 'user_id', $readerId )
        ->latest()
        ->paginate( 10 );
        return view( 'reader.comments', compact( 'comments' ) );
    }

    public function store( Request $request, Post $post ) {
        // Validate input
        $request->validate( [
            'content' => 'required|string'
        ] );

        // Create comment as the authenticated reader
        $post->comments()->create( [
            'content' => $request->content,
            'user_id' => Auth::guard( 'reader' )->id(),
            'approved' => false,
        ] );

        return back()->with( 'success', 'Comment submitted for approval.' );
    }

    public function report( Comment $comment ) {
        // Flag comment as spam
        $comment->update( [
            'flagged' => true,
        ] );

        return back()->with( 'success', 'Comment reported as spam.' );
    }
}