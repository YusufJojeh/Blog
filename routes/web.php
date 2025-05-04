<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ProfileController;

// Admin Controllers
use App\Http\Controllers\Admin\AdminDashboard;
use App\Http\Controllers\Admin\UserManagemantController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ModerationController;
use App\Http\Controllers\Admin\SiteSettingsController;

// Author Controllers
use App\Http\Controllers\Author\AuthorController;
use App\Http\Controllers\Author\PostController as AuthorPostController;
use App\Http\Controllers\Author\CommentController as AuthorCommentController;

// Reader Controllers
use App\Http\Controllers\Reader\ReaderController;
use App\Http\Controllers\Reader\ReaderFeedController;
use App\Http\Controllers\Reader\CommentController as ReaderCommentController;
use App\Http\Controllers\Reader\BookmarkController;
use App\Http\Controllers\Reader\SearchController;
use App\Http\Controllers\Reader\PreferenceController;

// Public route
Route::get('/', fn() => view('welcome'))->name('home');

// Authentication routes
Route::get ('admin/login',  [LoginController::class,'showLoginForm'])->name('admin.login');
Route::post('admin/login',  [LoginController::class,'login'])->name('admin.login.submit');
Route::get ('author/login', [LoginController::class,'showLoginForm'])->name('author.login');
Route::post('author/login', [LoginController::class,'login'])->name('author.login.submit');
Route::get ('reader/login', [LoginController::class,'showLoginForm'])->name('reader.login');
Route::post('reader/login', [LoginController::class,'login'])->name('reader.login.submit');
Route::get ('login',        [LoginController::class,'showLoginForm'])->name('login');
Route::post('login',        [LoginController::class,'login'])->name('login.submit');
Route::post('logout',       [LoginController::class,'logout'])->name('logout');

// ──────────────────────────────────────────────────────────────────────────────
// Admin routes
// ──────────────────────────────────────────────────────────────────────────────
Route::middleware('auth.guard:admin')
     ->prefix('admin')
     ->as('admin.')
     ->group(function () {
         Route::get('dashboard', [AdminDashboard::class,'dashboard'])->name('dashboard');

         // Profile
         Route::get('profile',  [ProfileController::class,'show'])->name('profile.show');
         Route::post('profile', [ProfileController::class,'update'])->name('profile.update');

         // User management
         Route::resource('users', UserManagemantController::class)
              ->except(['show','edit','update','destroy'])
              ->names('users');

        Route::get   ('users/{role}/{id}',             [UserManagemantController::class, 'show'])   ->name('users.show');
Route::get   ('users/{role}/{id}/edit',        [UserManagemantController::class, 'edit'])   ->name('users.edit');
Route::put   ('users/{role}/{id}',             [UserManagemantController::class, 'update']) ->name('users.update');
Route::delete('users/{role}/{id}',             [UserManagemantController::class, 'destroy'])->name('users.destroy');
         // Category management
         Route::resource('categories', CategoryController::class)
              ->except(['show'])
              ->names('categories');

         // Content moderation
         Route::get('moderation/reported-posts',                [ModerationController::class,'reportedPosts'])->name('moderation.reported-posts');
         Route::post('moderation/reported-posts/{post}/unflag', [ModerationController::class,'unflagPost'])->name('moderation.reported-posts.unflag');
         Route::delete('moderation/reported-posts/{post}',      [ModerationController::class,'deletePost'])->name('moderation.reported-posts.delete');

         Route::get('moderation/reported-comments',                [ModerationController::class,'reportedComments'])->name('moderation.reported-comments');
         Route::post('moderation/reported-comments/{comment}/unflag',[ModerationController::class,'unflagComment'])->name('moderation.reported-comments.unflag');
         Route::delete('moderation/reported-comments/{comment}',      [ModerationController::class,'deleteComment'])->name('moderation.reported-comments.delete');

         // Site settings
         Route::get('settings', [SiteSettingsController::class,'index'])->name('settings.index');
         Route::post('settings',[SiteSettingsController::class,'update'])->name('settings.update');
     });

// ──────────────────────────────────────────────────────────────────────────────
// Author routes
// ──────────────────────────────────────────────────────────────────────────────
Route::middleware('auth.guard:author')
     ->prefix('author')
     ->as('author.')
     ->group(function () {
         Route::get('dashboard', [AuthorController::class,'index'])->name('dashboard');

         // Profile
         Route::get('profile',  [ProfileController::class,'show'])->name('profile.show');
         Route::post('profile', [ProfileController::class,'update'])->name('profile.update');

         // Posts
         Route::get('posts/drafts',    [AuthorPostController::class,'drafts'])->name('posts.drafts');
         Route::get('posts/scheduled', [AuthorPostController::class,'scheduled'])->name('posts.scheduled');
         Route::resource('posts', AuthorPostController::class)
              ->except(['show'])
              ->names('posts');

         // Comments moderation
         Route::get('comments',               [AuthorCommentController::class,'index'])->name('comments.index');
         Route::post('comments/{comment}/approve',[AuthorCommentController::class,'approve'])->name('comments.approve');
         Route::get('comments/spam',          [AuthorCommentController::class,'spam'])->name('comments.spam');
     });

// ──────────────────────────────────────────────────────────────────────────────
// Reader routes
// ──────────────────────────────────────────────────────────────────────────────
Route::middleware('auth.guard:reader')
     ->prefix('reader')
     ->as('reader.')
     ->group(function () {
         // Dashboard
         Route::get('dashboard', [ReaderController::class,'index'])->name('dashboard');

         // Profile
         Route::get('profile',  [ProfileController::class,'show'])->name('profile.show');
         Route::post('profile', [ProfileController::class,'update'])->name('profile.update');

         // Feed (ensure this view exists)
         Route::get('feed',     [ReaderFeedController::class,'index'])->name('feed');
 Route::get('posts/{post}', [ReaderFeedController::class, 'show'])->name('posts.show');
         // Bookmarks
         Route::get('bookmarks',                [BookmarkController::class,'index'])->name('bookmarks.index');
         Route::post('bookmarks/{article}',     [BookmarkController::class,'store'])->name('bookmarks.store');
         Route::delete('bookmarks/{article}',   [BookmarkController::class,'destroy'])->name('bookmarks.destroy');

         // Reader comments
         Route::get('comments',                 [ReaderCommentController::class,'index'])->name('comments.index');
         Route::post('posts/{post}/comments',   [ReaderCommentController::class,'store'])->name('comments.store');
         Route::post('comments/{comment}/report',[ReaderCommentController::class,'report'])->name('comments.report');

         // Search articles
         Route::get('search', [SearchController::class,'search'])->name('search');

         // Preferences
         Route::get('preferences', [PreferenceController::class,'edit'])->name('preferences.edit');
         Route::post('preferences',[PreferenceController::class,'update'])->name('preferences.update');
     });
