<?php

namespace App\Http\Controllers;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class PostController extends Controller {

    public function index() {
        $postFromDB = Post::all();
        return view( 'posts.index', [ 'posts'=>$postFromDB ] );
    }

    /**
    * Show the form for creating a new resource.
    */

    public function create() {
        $users = User::all();
        return view( 'posts.create', [ 'users'=>$users ] );
    }

    /**
    * Store a newly created resource in storage.
    */

    public function store() {
        $data = request()->all();
        // // return $data;
        $request = request();
        $request->validate( [
            'title' => [ 'required', 'min:3' ],
            'description' => [ 'required', 'min:5' ],
            'post_creator' => [ 'required', 'exists:users,id' ],
            'image'=> [ 'required', 'image' ]

        ] );

        $title = request()->title;
        $description = request()->description;
        $post_creator = request()->post_creator;
        $image = request()->image;
        $imagePath = request( 'image' )->store( 'uploads', 'public' );

        Post::create( [
            'title'=>$title,
            'description'=>$description,
            'user_id'=>$post_creator,
            'image'=>$imagePath,
        ] );
        return to_route( 'posts.index' );
    }

    /**
    * Display the specified resource.
    */

    public function show( Post $post ) {

        return view( 'posts.show', [ 'post'=>$post ] );
    }

    /**
    * Show the form for editing the specified resource.
    */

    public function edit( Post $post ) {
        $users = User::all();
        return view( 'posts.edit', [ 'users'=>$users, 'post'=>$post ] );
    }

    /**
    * Update the specified resource in storage.
    */

    public function update( Request $request, $postId ) {
        $title = request()->title;
        $description = request()->description;
        $post_creator = request()->post_creator;

        $singlePostFromDB = Post::find( $postId );
        $singlePostFromDB->update( [
            'title'=> $title,
            'description'=> $description,
            'user_id'=> $post_creator,
        ] );
        return to_route( 'posts.show', $postId );
    }

    /**
    * Remove the specified resource from storage.
    */

    public function destroy( $postId ) {
        Post::where( 'id', $postId )->delete();
        return to_route( 'posts.index' );
    }
}
