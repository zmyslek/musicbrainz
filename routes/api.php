<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MusicBrainzController;

Route::get('/artist/{name}', [MusicBrainzController::class, 'getArtist']);
Route::get('/artist/{id}/albums', [MusicBrainzController::class, 'getArtistAlbums']);
Route::get('/artist/{id}/annotations', [MusicBrainzController::class, 'getArtistAnnotations']);
Route::get('/album/{id}', [MusicBrainzController::class, 'getAlbum']);
Route::get('/album/{id}/tracks', [MusicBrainzController::class, 'getAlbumTracks']);
