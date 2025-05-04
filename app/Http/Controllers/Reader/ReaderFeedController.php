<?php
namespace App\Http\Controllers\Reader;

use Illuminate\Support\Facades\Auth;
use App\Models\Post;

class ReaderFeedController extends Controller {
    public function index() {
        $reader = Auth::guard( 'reader' )->user();

        $Posts = Post::with( 'author' )
        ->latest()
        ->paginate( 10 );

        return view( 'reader.feed', compact( 'Posts' ) );
    }

    public function show( Post $post ) {
        $post->load( [
            'author',
            'category',
            'comments' => fn( $q ) => $q
            ->where( 'approved', true )
            ->latest()
            ->with( 'reader' ),
        ] );

        return view( 'reader.posts.show', compact( 'post' ) );
    }
}