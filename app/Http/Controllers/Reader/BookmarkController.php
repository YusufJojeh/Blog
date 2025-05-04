<?php

namespace App\Http\Controllers\Reader;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\Bookmark;

class BookmarkController extends Controller {
    public function index() {
        $readerId = Auth::guard( 'reader' )->id();
        $posts = Bookmark::where( 'reader_id', $readerId )
        ->with( 'post' )
        ->latest()
        ->paginate( 10 );

        return view( 'reader.bookmarks', [
            'posts' => $posts
        ] );
    }

    public function store( Post $post ) {
        $readerId = Auth::guard( 'reader' )->id();

        Bookmark::firstOrCreate(
            [ 'reader_id' => $readerId, 'post_id' => $post->id ],
            []
        );

        return back()->with( 'success', 'Post bookmarked.' );
    }

    public function destroy( Post $post ) {
        $readerId = Auth::guard( 'reader' )->id();

        Bookmark::where( 'reader_id', $readerId )
        ->where( 'post_id', $post->id )
        ->delete();

        return back()->with( 'success', 'Bookmark removed.' );
    }
}