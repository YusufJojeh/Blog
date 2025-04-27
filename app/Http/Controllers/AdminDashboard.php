<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\Admin;
use App\Services\AdminDashboardService;

class AdminDashboard extends Controller {

    protected AdminDashboardService $service;

    public function __construct( AdminDashboardService $service ) {
        $this->service = $service;
    }

    public function dashboard() {
        $userStats        = $this->service->getUserStats();
        $postStats        = $this->service->getPostStats();
        $commentStats     = $this->service->getCommentStats();
        $newRegistrations = $this->service->getNewRegistrations();
        $recentPosts      = $this->service->getRecentPosts();
        $postsPerDay      = $this->service->getPostsPerDay();
        $userSignUps      = $this->service->getUserSignUps();

        return view( 'admin.dashboard', compact(
            'userStats',
            'postStats',
            'commentStats',
            'newRegistrations',
            'recentPosts',
            'postsPerDay',
            'userSignUps'
        ) );
    }

    public function profile() {

        $admin = Auth::guard( 'admin' )->user();
        return view( 'admin.profile', compact( 'admin' ) );
    }

    public function update( Request $request, $id ) {
        $authAdmin = Auth::guard( 'admin' )->user();

        if ( $authAdmin->id != $id ) {
            return redirect()->back()->with( 'error', 'Unauthorized action.' );
        }

        $admin = Admin::find( $id );
        if ( !$admin ) {
            return redirect()->back()->with( 'error', 'Admin not found.' );
        }

        $validatedData = $request->validate( [
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email,' . $admin->id,
        ] );

        $admin->name  = $validatedData[ 'name' ];
        $admin->email = $validatedData[ 'email' ];
        $admin->save();

        return redirect()->route( 'admin.profile' )->with( 'success', 'Profile updated successfully.' );
    }

    public function newPosts() {
        $newPosts = Post::where( 'status', 'pending' )->orderBy( 'created_at', 'desc' )->get();
        return view( 'admin.new-posts', compact( 'newPosts' ) );
    }

    public function approvePost( $id ) {
        $post = Post::findOrFail( $id );
        $post->status = 'approved';
        $post->save();

        return redirect()->route( 'admin.new-posts' )->with( 'success', 'Post approved successfully.' );
    }

    public function rejectPost( $id ) {

        $post = Post::findOrFail( $id );
        $post->status = 'rejected';
        $post->save();

        return redirect()->route( 'admin.new-posts' )->with( 'success', 'Post rejected successfully.' );
    }
}
