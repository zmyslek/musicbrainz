<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ArtistController extends Controller
{
    public function getArtist($name)
    {
        $response = Http::withHeaders([
            'User-Agent' => 'YourAppName/1.0 (yourname@example.com)'
        ])->get("https://musicbrainz.org/ws/2/artist/", [
            'query' => "artist:$name",
            'fmt' => 'json'
        ]);

        $artist = $response->json();
        return view('artist', ['name' => $name, 'artist' => $artist]);
    }

    public function getArtistAnnotations($id)
    {
        $response = Http::withHeaders([
            'User-Agent' => 'YourAppName/1.0 (yourname@example.com)'
        ])->get("https://musicbrainz.org/ws/2/annotation/", [
            'query' => "artist:$id",
            'fmt' => 'json'
        ]);

        return response()->json($response->json());
    }

    public function getArtistAlbums($id)
    {
        $response = Http::withHeaders([
            'User-Agent' => 'YourAppName/1.0 (yourname@example.com)'
        ])->get("https://musicbrainz.org/ws/2/release-group", [
            'artist' => $id,
            'type' => 'album|single',
            'fmt' => 'json'
        ]);

        return response()->json($response->json());
    }
}
