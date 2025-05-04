<?php

namespace App\Http\Controllers\Reader;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Post;

class SearchController extends Controller {
    public function search( Request $request ) {
        $q = $request->input( 'q' );

        $articles = Post::where( 'title', 'like', "%{$q}%" )
        ->orWhere( 'content', 'like', "%{$q}%" )
        ->paginate( 10 );

        return view( 'reader.search', compact( 'articles', 'q' ) );
    }

}