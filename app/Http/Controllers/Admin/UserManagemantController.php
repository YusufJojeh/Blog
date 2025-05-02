<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Services\AdminDashboardService;
use App\Models\Admin;
use App\Models\Author;
use App\Models\Reader;

class UserManagemantController extends Controller {
    protected AdminDashboardService $userService;

    public function __construct( AdminDashboardService $userService ) {
        $this->userService = $userService;
    }

    /**
    * Display a listing of users.
    */

    public function index() {
        $users = $this->userService->getAllUsers();

        return view( 'admin.usermang', compact( 'users' ) );
    }

    public function create() {
        return view( 'admin.usermang_create' );
    }

    /** POST /admin/users */

    public function store( Request $request ) {
        $data = $request->validate( [
            'name'     =>'required|string|max:255',
            'email'    =>'required|email|max:255|unique:admins|unique:authors|unique:readers',
            'password' =>'required|string|min:8|confirmed',
            'role'     =>'required|in:admin,author,reader',
        ] );

        $model = $this->getModel( $data[ 'role' ] );
        $model::create( [
            'name'     =>$data[ 'name' ],
            'email'    =>$data[ 'email' ],
            'password' =>bcrypt( $data[ 'password' ] ),
        ] );

        return redirect()->route( 'admin.users.index' )
        ->with( 'message', 'User created successfully.' );
    }

    /** GET  /admin/users/ {
    role}
    / {
    id}
    */

    public function show( $role, $id ) {
        $model = $this->getModel( $role );
        // Get model based on role
        $user = $model::findOrFail( $id );
        // Fetch the user by id

        return view( 'admin.usermang_show', compact( 'user', 'role' ) );
        // Pass both user and role
    }

    /** GET  /admin/users/ {
    role}
    / {
    id}
    /edit */

    public function edit( $role, $id ) {
        $model = $this->getModel( $role );
        $user  = $model::findOrFail( $id );
        return view( 'admin.usermang_edit', compact( 'user', 'role' ) );
    }

    /** PUT  /admin/users/ {
    role}
    / {
    id}
    */

    public function update( Request $request, $role, $id ) {
        $model = $this->getModel( $role );
        $user  = $model::findOrFail( $id );

        $data = $request->validate( [
            'name'     =>'required|string|max:255',
            'email'    =>"required|email|max:255|unique:{$user->getTable()},email,{$id}",
            'password' =>'nullable|string|min:8|confirmed',
        ] );

        $user->name  = $data[ 'name' ];
        $user->email = $data[ 'email' ];
        if ( !empty( $data[ 'password' ] ) ) {
            $user->password = bcrypt( $data[ 'password' ] );
        }
        $user->save();

        return redirect()->route( 'admin.users.index' )
        ->with( 'message', 'User updated successfully.' );
    }

    /** DELETE /admin/users/ {
    role}
    / {
    id}
    */

    public function destroy( $role, $id ) {
        $model = $this->getModel( $role );
        $model::destroy( $id );

        return redirect()->route( 'admin.users.index' )
        ->with( 'message', ucfirst( $role ).' deleted.' );
    }

    /** helper to map role → model */
    protected function getModel( string $role ): string {
        return match( $role ) {
            'admin'  => Admin::class,
            'author' => Author::class,
            'reader' => Reader::class,
            default  => throw new \InvalidArgumentException( "Invalid role {$role}" ),
        }
        ;
    }
}