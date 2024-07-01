<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AlbumController extends Controller
{
    public function show($id)
    {
        $albumResponse = Http::get("https://musicbrainz.org/ws/2/release-group/{$id}?inc=artist-credits+releases&fmt=json");

        if ($albumResponse->failed()) {
            return view('album')->with('error', 'Error fetching album information.');
        }

        $album = $albumResponse->json();
        $artistName = $album['artist-credit'][0]['name'];

        // Fetch songs
        $songsResponse = Http::get("https://musicbrainz.org/ws/2/recording", [
            'release' => $album['releases'][0]['id'],
            'fmt' => 'json'
        ]);

        $songs = $songsResponse->successful() ? $songsResponse->json()['recordings'] : [];

        return view('album', compact('album', 'artistName', 'songs'));
    }

    public function getDetails($id)
    {
        $albumResponse = Http::get("https://musicbrainz.org/ws/2/release-group/{$id}?inc=artist-credits+releases&fmt=json");

        return response()->json($albumResponse->json());
    }
}
