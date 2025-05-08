<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\TopicController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('auth/Login');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/topics', [TopicController::class, 'index'])->name('topics.index');
    Route::get('/topics/create', [TopicController::class, 'create'])->name('topics.create');
    Route::post('/topics', [TopicController::class, 'store'])->name('topics.store');

    Route::get('/topics/{topic}', [TopicController::class, 'show'])->name('topics.show');
    Route::post('/topics/{topic}/comments', [CommentController::class, 'store'])->name('comments.store');

    Route::get('/topics/{topic}/edit', [TopicController::class, 'edit'])->name('topics.edit');
    Route::put('/topics/{topic}', [TopicController::class, 'update'])->name('topics.update');

    Route::delete('/topics/{topic}', [TopicController::class, 'destroy'])->name('topics.destroy');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
