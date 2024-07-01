<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AlbumController extends Controller
{
    public function show($id)
    {
        $response = Http::withHeaders([
            'User-Agent' => 'YourAppName/1.0 ( yourname@example.com )'
        ])->get("https://musicbrainz.org/ws/2/release-group/$id", [
            'fmt' => 'json'
        ]);

        $album = $response->json();
        return view('album', ['album' => $album]);
    }

    public function getRecordings($id)
    {
        $response = Http::withHeaders([
            'User-Agent' => 'YourAppName/1.0 ( yourname@example.com )'
        ])->get("https://musicbrainz.org/ws/2/recording", [
            'release' => $id,
            'fmt' => 'json'
        ]);

        return response()->json($response->json());
    }
}
