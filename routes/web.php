// routes/web.php
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArtistController;

Route::get('/', function () {
    return view('index');
})->name('home');

Route::get('/artist/{name}', [ArtistController::class, 'getArtist'])->name('artist');
Route::get('/artist/{id}/annotations', [ArtistController::class, 'getArtistAnnotations']);
Route::get('/artist/{id}/albums', [ArtistController::class, 'getArtistAlbums']);
