<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller {
    public function index() {
        $posts = Post::with( [ 'category', 'author' ] )
        ->latest()
        ->paginate( 15 );

        return view( 'admin.posts.index', compact( 'posts' ) );
    }

    public function create() {
        $categories = Category::pluck( 'name', 'id' );
        $authors = User::pluck( 'name', 'id' );
        return view( 'admin.posts.create', compact( 'categories', 'authors' ) );
    }

    public function store( Request $request ) {
        $data = $request->validate( [
            'title' => 'required|string|max:255',
            'content' => 'required',
            'image' => 'nullable|image|max:2048',
            'category_id' => 'nullable|exists:categories,id',
            'author_id' => 'nullable|exists:users,id',
            'status' => 'required|in:draft,published',
            'published_at' => 'nullable|date',
        ] );

        if ( $request->hasFile( 'image' ) ) {
            $data[ 'image' ] = $request->file( 'image' )
            ->store( 'posts', 'public' );
        }

        Post::create( $data );

        return redirect()
        ->route( 'admin.posts.index' )
        ->with( 'success', 'Post created.' );
    }

    public function edit( Post $post ) {
        $categories = Category::pluck( 'name', 'id' );
        $authors = User::pluck( 'name', 'id' );
        return view( 'admin.posts.edit', compact( 'post', 'categories', 'authors' ) );
    }

    public function update( Request $request, Post $post ) {
        $data = $request->validate( [
            'title' => 'required|string|max:255',
            'content' => 'required',
            'image' => 'nullable|image|max:2048',
            'category_id' => 'nullable|exists:categories,id',
            'author_id' => 'nullable|exists:users,id',
            'status' => 'required|in:draft,published',
            'published_at' => 'nullable|date',
        ] );

        if ( $request->hasFile( 'image' ) ) {
            // delete old
            if ( $post->image ) {
                Storage::disk( 'public' )->delete( $post->image );
            }
            $data[ 'image' ] = $request->file( 'image' )
            ->store( 'posts', 'public' );
        }

        $post->update( $data );

        return redirect()
        ->route( 'admin.posts.index' )
        ->with( 'success', 'Post updated.' );
    }

    public function destroy( Post $post ) {
        if ( $post->image ) {
            Storage::disk( 'public' )->delete( $post->image );
        }
        $post->delete();
        return back()->with( 'success', 'Post deleted.' );
    }
}
