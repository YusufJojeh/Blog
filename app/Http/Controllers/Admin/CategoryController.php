<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller {

    public function index() {
        $categories = Category::select( 'id', 'name', 'image', 'created_at', 'updated_at' )
        ->orderBy( 'created_at', 'desc' )
        ->paginate( 10 );

        return view( 'admin.categories.index', compact( 'categories' ) );
    }

    public function create() {
        return view( 'admin.categories.create' );
    }

    public function store( Request $request ) {
        $data = $request->validate( [
            'name'  => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
        ] );

        if ( $request->hasFile( 'image' ) ) {
            $data[ 'image' ] = $request->file( 'image' )
            ->store( 'categories', 'public' );
        }

        Category::create( $data );

        return redirect()->route( 'admin.categories.index' )
        ->with( 'success', 'Category created.' );
    }

    public function edit( Category $category ) {
        return view( 'admin.categories.edit', compact( 'category' ) );
    }

    public function update( Request $request, Category $category ) {
        $data = $request->validate( [
            'name'  => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
        ] );

        if ( $request->hasFile( 'image' ) ) {

            if ( $category->image ) {
                Storage::disk( 'public' )->delete( $category->image );
            }
            $data[ 'image' ] = $request->file( 'image' )
            ->store( 'categories', 'public' );
        }

        $category->update( $data );

        return redirect()->route( 'admin.categories.index' )
        ->with( 'success', 'Category updated.' );
    }

    public function destroy( Category $category ) {
        if ( $category->image ) {
            Storage::disk( 'public' )->delete( $category->image );
        }
        $category->delete();

        return redirect()->route( 'admin.categories.index' )
        ->with( 'success', 'Category deleted.' );
    }
}