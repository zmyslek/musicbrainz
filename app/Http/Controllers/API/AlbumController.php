<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class AlbumController extends Controller
{
    public function show($id)
    {
        try {
            $response = Http::get("https://musicbrainz.org/ws/2/release-group/$id", [
                'inc' => 'artist-credits+releases',
                'fmt' => 'json'
            ]);
            return $response->json();
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch album details'], 500);
        }
    }

    public function getReleases($id)
    {
        try {
            $response = Http::get("https://musicbrainz.org/ws/2/release", [
                'release-group' => $id,
                'fmt' => 'json'
            ]);
            return $response->json();
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch album releases'], 500);
        }
    }
}
