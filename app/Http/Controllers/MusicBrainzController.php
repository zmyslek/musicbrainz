<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MusicBrainzController extends Controller
{
    private $baseUrl = "https://musicbrainz.org/ws/2/";

    public function getArtist($name)
    {
        $response = Http::get("{$this->baseUrl}artist/", [
            'query' => $name,
            'fmt' => 'json'
        ]);

        if ($response->successful()) {
            return $response->json();
        } else {
            return response()->json(['error' => 'Failed to fetch artist details'], 500);
        }
    }

    public function getArtistAlbums($id)
    {
        $response = Http::get("{$this->baseUrl}release-group/", [
            'artist' => $id,
            'type' => 'album|single',
            'fmt' => 'json'
        ]);

        if ($response->successful()) {
            return $response->json();
        } else {
            return response()->json(['error' => 'Failed to fetch artist albums'], 500);
        }
    }

    public function getArtistAnnotations($id)
    {
        $response = Http::get("{$this->baseUrl}artist/{$id}", [
            'inc' => 'annotation',
            'fmt' => 'json'
        ]);

        if ($response->successful()) {
            return $response->json();
        } else {
            return response()->json(['error' => 'Failed to fetch artist annotations'], 500);
        }
    }

    public function getAlbum($id)
    {
        $response = Http::get("{$this->baseUrl}release-group/{$id}", [
            'fmt' => 'json'
        ]);

        if ($response->successful()) {
            return $response->json();
        } else {
            return response()->json(['error' => 'Failed to fetch album details'], 500);
        }
    }

    public function getAlbumTracks($id)
    {
        $response = Http::get("{$this->baseUrl}release/{$id}", [
            'inc' => 'recordings',
            'fmt' => 'json'
        ]);

        if ($response->successful()) {
            return $response->json();
        } else {
            return response()->json(['error' => 'Failed to fetch album tracks'], 500);
        }
    }
}
