<?php

use Illuminate\Support\Facades\Route;
use Laravel\WorkOS\Http\Middleware\ValidateSessionWithWorkOS;
use App\Http\Controllers\BlogController;

Route::view('/', 'welcome')->name('home');

Route::middleware([
    'auth',
    ValidateSessionWithWorkOS::class,
])->group(function () {
    Route::get('dashboard', [BlogController::class, 'dashboard'])->name('dashboard');
    
    // Blog routes
    Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
    Route::get('/blog/create', [BlogController::class, 'create'])->name('blog.create');
    Route::get('/blog/drafts', [BlogController::class, 'drafts'])->name('blog.drafts');
    Route::get('/blog/likes', [BlogController::class, 'likes'])->name('blog.likes');
    Route::get('/blog/comments', [BlogController::class, 'comments'])->name('blog.comments');
    Route::post('/blog', [BlogController::class, 'store'])->name('blog.store');
    Route::get('/blog/categories', [BlogController::class, 'categories'])->name('blog.categories');
    Route::get('/blog/statistics', [BlogController::class, 'statistics'])->name('blog.statistics');
    Route::get('/blog/followers', [BlogController::class, 'followers'])->name('blog.followers');
    Route::get('/blog/profile/{user}', [BlogController::class, 'profile'])->name('blog.profile');
    Route::post('/blog/profile/{user}/follow', [BlogController::class, 'follow'])->name('blog.follow');
    Route::post('/blog/preview', [BlogController::class, 'preview'])->name('blog.preview');
    Route::post('/blog/like/{post}', [BlogController::class, 'like'])->name('blog.like');
    Route::post('/blog/comment/{post}', [BlogController::class, 'comment'])->name('blog.comment');
    Route::get('/blog/{post}', [BlogController::class, 'show'])->name('blog.show');
    Route::get('/blog/{post}/edit', [BlogController::class, 'edit'])->name('blog.edit');
    Route::put('/blog/{post}', [BlogController::class, 'update'])->name('blog.update');
    Route::delete('/blog/{post}', [BlogController::class, 'destroy'])->name('blog.destroy');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
