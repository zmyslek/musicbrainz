<?php
// app/Http/Controllers/ArtistController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ArtistController extends Controller
{
public function index()
{
return view('index');
}

public function show($name)
{
$response = Http::get("https://musicbrainz.org/ws/2/artist/", [
'query' => 'artist:"' . $name . '"',
'fmt' => 'json',
]);

$data = $response->json();
$artist = $data['artists'][0] ?? null;

if ($artist) {
// Fetch albums
$albumsResponse = Http::get("https://musicbrainz.org/ws/2/release-group", [
'artist' => $artist['id'],
'type' => 'album|single',
'fmt' => 'json',
]);
$albumsData = $albumsResponse->json();

return view('artist', [
'artist' => $artist,
'albums' => $albumsData['release-groups'] ?? [],
]);
}

return view('artist', ['artist' => null, 'albums' => []]);
}

public function showAlbum($id)
{
$response = Http::get("https://musicbrainz.org/ws/2/release-group/{$id}", [
'fmt' => 'json',
]);

$album = $response->json();
$songsResponse = Http::get("https://musicbrainz.org/ws/2/recording", [
'release' => $id,
'fmt' => 'json',
]);

$songs = $songsResponse->json()['recordings'] ?? [];

return view('album', [
'album' => $album,
'songs' => $songs,
]);
}
}
