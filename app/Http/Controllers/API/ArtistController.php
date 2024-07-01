<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class ArtistController extends Controller
{
    public function show($name)
    {
        try {
            $response = Http::get('https://musicbrainz.org/ws/2/artist/', [
                'query' => "artist:$name",
                'fmt' => 'json'
            ]);
            return $response->json();
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch artist details'], 500);
        }
    }

    public function getAlbums($id)
    {
        try {
            $response = Http::get('https://musicbrainz.org/ws/2/release-group', [
                'artist' => $id,
                'type' => 'album|single',
                'fmt' => 'json'
            ]);
            return $response->json();
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch artist albums'], 500);
        }
    }

    public function getReleases($id)
    {
        try {
            $response = Http::get('https://musicbrainz.org/ws/2/release', [
                'artist' => $id,
                'fmt' => 'json'
            ]);
            return $response->json();
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch artist releases'], 500);
        }
    }
}
