<?php

namespace App\Http\Controllers\Reader;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class CommentController extends Controller {
    public function __construct() {

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
        $request->validate( [
            'content' => 'required|string',
        ] );

        $post->comments()->create( [
            'content'  => $request->content,
            'reader_id'  => Auth::guard( 'reader' )->id(),
            'approved' => true,
            'flagged'  => false,
        ] );

        return back()->with( 'success', 'Your comment has been posted!' );
    }

    public function report( Comment $comment ) {
        $comment->update( [
            'flagged' => true,
        ] );

        return back()->with( 'success', 'Comment reported as spam.' );
    }
}