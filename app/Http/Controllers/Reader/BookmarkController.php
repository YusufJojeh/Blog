<?php

namespace App\Http\Controllers\Reader;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;

class BookmarkController extends Controller {
    public function index() {
        $reader = Auth::guard( 'reader' )->user();
        $posts = $reader->bookmarks()->with( 'Post' )->paginate( 10 );
        return view( 'reader.bookmarks', compact( 'Posts' ) );
    }

    public function store( Post $post ) {
        $reader = Auth::guard( 'reader' )->user();
        $reader->bookmarks()->syncWithoutDetaching( [ $post->id ] );
        return back();
    }

    public function destroy( Post $post ) {
        $reader = Auth::guard( 'reader' )->user();
        $reader->bookmarks()->detach( ost->id );
        return back();
    }
}