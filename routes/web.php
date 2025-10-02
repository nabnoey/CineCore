<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\Admin\MovieController as AdminMovieController;
;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\Auth\RegisterController;
use App\Models\Movie;
use App\Models\Category;

/*
|--------------------------------------------------------------------------
| หน้าแรก
|--------------------------------------------------------------------------
*/
Route::get('/', [MovieController::class, 'home'])->name('home');


/*
|--------------------------------------------------------------------------
| Auth / Register
|--------------------------------------------------------------------------
*/
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);

Auth::routes(); // รวม login / logout / reset password

/*
|--------------------------------------------------------------------------
| Movies (ทั่วไป)
|--------------------------------------------------------------------------
*/
Route::prefix('movies')->group(function () {
    Route::get('/', function () {
        $movies = Movie::all(); 
        return view('movies.index', compact('movies'));
    })->name('movies.list');

    Route::get('/{id}', [MovieController::class, 'show'])->name('movies.show');
});

/*
|--------------------------------------------------------------------------
| Categories
|--------------------------------------------------------------------------
*/
Route::prefix('categories')->group(function () {
    Route::get('/', function () {
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    })->name('categories.list');

    Route::get('/{id}', function ($id) {
        $category = Category::findOrFail($id);
        $movies = $category->movies;
        return view('categories.show', compact('category', 'movies'));
    })->name('categories.show');
});

/*
|--------------------------------------------------------------------------
| Favorite
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::post('/movies/{movie}/favorite', [FavoriteController::class, 'store'])->name('movies.favorite');
    Route::delete('/movies/{movie}/favorite', [FavoriteController::class, 'destroy'])->name('movies.unfavorite');
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->middleware('auth')->name('admin.')->group(function() {
    Route::resource('movies', MovieController::class);
});

/*
|--------------------------------------------------------------------------
| Routes สำหรับผู้ใช้ที่ต้อง login
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    // Comment Routes
    Route::post('/comments', [CommentController::class,'store'])->name('comments.store');
    Route::get('/comments/{comment}/edit', [CommentController::class, 'edit'])->name('comments.edit');
    Route::put('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

    // Like comment
    Route::post('/comments/{comment}/like', [CommentController::class, 'like'])->name('comments.like');

    // Profile Routes
    Route::get('/profile/edit', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
});

// Public movies
Route::get('/movies', [MovieController::class, 'index'])->name('movies.list');
Route::get('/movies/{id}', [MovieController::class, 'show'])->name('movies.show');
Route::get('/movies/{id}/trailer', [MovieController::class, 'trailer'])->name('movies.trailer');

// API for live search
Route::get('/api/movies/search', [MovieController::class, 'search'])->name('movies.search');

// Admin movies (ต้อง login)
Route::prefix('admin')->middleware('auth')->name('admin.')->group(function () {
    Route::resource('movies', AdminMovieController::class)->except(['show']);
});