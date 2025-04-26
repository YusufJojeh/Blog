<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ReaderController;
use App\Http\Controllers\UserManagemantController;

// ---------------------------
// 🌐 Public (guests & auth’d)
// ---------------------------

Route::get('/', fn() => view('welcome'));

Route::get('login',  [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout',[LoginController::class, 'logout'])->name('logout');

Route::get('posts',        [PostController::class, 'index'])->name('posts.index');
Route::get('posts/{post}', [PostController::class, 'show'] )->name('posts.show');


// ---------------------------
// 🛡️ Admin routes
// ---------------------------

Route::middleware('auth.guard:admin')
     ->prefix('admin')
     ->as('admin.')
     ->group(function () {

    // Dashboard
    Route::get('dashboard', [AdminController::class, 'index'])
         ->name('dashboard');

    // ── User Management ───────────────────────────────────────────
    Route::get   ('users',               [UserManagemantController::class,'index'])
         ->name('users.index');
    Route::get   ('users/create',        [UserManagemantController::class,'create'])
         ->name('users.create');
    Route::post  ('users',               [UserManagemantController::class,'store'])
         ->name('users.store');

    Route::get   ('users/{role}/{id}',   [UserManagemantController::class,'show'])
         ->whereIn('role',['admin','author','reader'])
         ->name('users.show');
    Route::get   ('users/{role}/{id}/edit',[UserManagemantController::class,'edit'])
         ->whereIn('role',['admin','author','reader'])
         ->name('users.edit');
    Route::put   ('users/{role}/{id}',   [UserManagemantController::class,'update'])
         ->whereIn('role',['admin','author','reader'])
         ->name('users.update');
    Route::delete('users/{role}/{id}',   [UserManagemantController::class,'destroy'])
         ->whereIn('role',['admin','author','reader'])
         ->name('users.destroy');

    // ── Posts Management ─────────────────────────────────────────
    // Admin can CRUD posts:
  Route::get   ('posts',              [PostController::class,'index'])  ->name('posts.index');
    Route::get   ('posts/create',       [PostController::class,'create']) ->name('posts.create');
    Route::post  ('posts',              [PostController::class,'store'])  ->name('posts.store');
    Route::get   ('posts/{post}/edit',  [PostController::class,'edit'])   ->name('posts.edit');
    Route::put   ('posts/{post}',       [PostController::class,'update']) ->name('posts.update');
    Route::delete('posts/{post}',       [PostController::class,'destroy'])->name('posts.destroy');
});


// ---------------------------
// ✍️ Author routes
// ---------------------------

Route::middleware('auth.guard:author')
     ->prefix('author')
     ->as('author.')
     ->group(function () {
    Route::get('dashboard', [AuthorController::class, 'index'])
         ->name('dashboard');

    Route::resource('posts', PostController::class)
         ->only(['create','store','edit','update'])
         ->names('posts');
});


// ---------------------------
// 👓 Reader routes
// ---------------------------

Route::middleware('auth.guard:reader')
     ->prefix('reader')
     ->as('reader.')
     ->group(function () {
    Route::get('dashboard', [ReaderController::class, 'index'])
         ->name('dashboard');

    // add other reader‐specific resources here...
});