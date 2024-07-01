<?php
use App\Http\Controllers\ArtistController;
use App\Http\Controllers\AlbumController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
return view('index');
})->name('home');

Route::get('/artist/{name}', [ArtistController::class, 'show'])->name('artist.show');
Route::get('/artist/{id}/annotations', [ArtistController::class, 'getAnnotations'])->name('artist.annotations');
Route::get('/artist/{id}/albums', [ArtistController::class, 'getAlbums'])->name('artist.albums');

Route::get('/album/{id}', [AlbumController::class, 'show'])->name('album.show');
Route::get('/album/{id}/recordings', [AlbumController::class, 'getRecordings'])->name('album.recordings');

// routes/web.php

Route::get('/', [ArtistController::class, 'index'])->name('home');
Route::get('/artist/{name}', [ArtistController::class, 'show'])->name('artist.show');
Route::get('/album/{id}', [ArtistController::class, 'showAlbum'])->name('album.show');

