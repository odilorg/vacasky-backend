<?php

use Illuminate\Support\Facades\Route;

// Homepage Routes
Route::get('/', function () {
    return view('pages.home.index');
})->name('home');

Route::get('/home-v2', function () {
    return view('pages.home.index-2');
})->name('home.v2');

Route::get('/home-v3', function () {
    return view('pages.home.index-3');
})->name('home.v3');

// Tour Routes
Route::prefix('tours')->name('tours.')->group(function () {
    Route::get('/', [App\Http\Controllers\TourController::class, 'index'])->name('index');

    Route::get('/list', function () {
        return view('pages.tours.list');
    })->name('list');

    Route::get('/{slug}', [App\Http\Controllers\TourController::class, 'show'])->name('details');

    Route::get('/{slug}/booking', [App\Http\Controllers\TourController::class, 'booking'])->name('booking');
});

// Destination Routes
Route::prefix('destinations')->name('destinations.')->group(function () {
    Route::get('/', function () {
        return view('pages.destinations.index');
    })->name('index');

    Route::get('/{slug}', function () {
        return view('pages.destinations.details');
    })->name('details');
});

// Blog Routes
Route::prefix('blog')->name('blog.')->group(function () {
    Route::get('/', function () {
        return view('pages.blog.index');
    })->name('index');

    Route::get('/{slug}', function () {
        return view('pages.blog.details');
    })->name('details');
});

// Static Pages
Route::get('/about', function () {
    return view('pages.about');
})->name('about');

Route::get('/contact', function () {
    return view('pages.contact');
})->name('contact');

// Auth Routes (later will use Laravel Breeze/Fortify)
Route::get('/login', function () {
    return view('pages.auth.login');
})->name('login');

Route::get('/signup', function () {
    return view('pages.auth.signup');
})->name('signup');
