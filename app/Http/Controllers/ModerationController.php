<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ModerationController extends Controller {
    // قائمة بالمقالات المبلّغ عنها

    public function reportedPosts() {
        $posts = Post::where( 'flagged', true )
        ->with( 'author' )
        ->latest()
        ->paginate( 10 );

        return view( 'admin.moderation.reported-posts', compact( 'posts' ) );
    }

    // إزالة علامة البلاغ عن المقال

    public function unflagPost( Post $post ) {
        $post->update( [ 'flagged' => false ] );
        return redirect()->route( 'admin.moderation.reported-posts' )
        ->with( 'success', 'Post unflagged.' );
    }

    // حذف المقال المبلّغ عنه

    public function deletePost( Post $post ) {
        if ( $post->image ) {
            Storage::disk( 'public' )->delete( $post->image );
        }
        $post->delete();
        return redirect()->route( 'admin.moderation.reported-posts' )
        ->with( 'success', 'Post deleted.' );
    }

    // قائمة بالتعليقات المبلّغ عنها

    public function reportedComments() {
        $comments = Comment::where( 'flagged', true )
        ->with( [ 'post', 'user' ] )
        ->latest()
        ->paginate( 10 );

        return view( 'admin.moderation.reported-comments', compact( 'comments' ) );
    }

    // إزالة علامة البلاغ عن التعليق

    public function unflagComment( Comment $comment ) {
        $comment->update( [ 'flagged' => false ] );
        return redirect()->route( 'admin.moderation.reported-comments' )
        ->with( 'success', 'Comment unflagged.' );
    }

    // حذف التعليق المبلّغ عنه

    public function deleteComment( Comment $comment ) {
        $comment->delete();
        return redirect()->route( 'admin.moderation.reported-comments' )
        ->with( 'success', 'Comment deleted.' );
    }
}