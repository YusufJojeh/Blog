<?php

namespace App\Http\Controllers\Reader;

use Illuminate\Support\Facades\Auth;
use App\Models\Post;

class ReaderFeedController extends Controller {
    public function index() {
        $reader = Auth::guard( 'reader' )->user();
        // simple: fetch latest 10 Posts
        $Posts = Post::latest()->paginate( 10 );
        return view( 'reader.feed', compact( 'Posts' ) );
    }
}