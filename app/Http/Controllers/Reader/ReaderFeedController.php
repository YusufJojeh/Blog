<?php

namespace App\Http\Controllers\Reader;

use Illuminate\Support\Facades\Auth;
use App\Models\Post;

class ReaderFeedController extends Controller {
    public function index() {
        $reader = Auth::guard( 'reader' )->user();
        // simple: fetch latest 10 Posts
        $Posts = Post::with( 'author' )    // ← eager-load!
        ->latest()
        ->paginate( 10 );
        return view( 'reader.feed', compact( 'Posts' ) );
    }

    public function show( Post $post ) {
        // Optional: Add visibility check if needed ( e.g., only published posts )
        return view( 'reader.Posts.show', compact( 'post' ) );
    }
}
