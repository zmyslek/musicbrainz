<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $album['title'] ?? 'Album Not Found' }} - MusicBrainz API</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
</head>
<body>
<nav>
    <div class="navbar-left">
        <a href="{{ route('home') }}"><i class="fa fa-home"></i></a>
    </div>
</nav>
<div class="album-container">
    <div class="album-cover-container">
        <img src="https://coverartarchive.org/release-group/{{ $album['id'] }}/front-250" alt="{{ $album['title'] }}" class="album-cover">
    </div>
    <div class="album-info">
        <h1>{{ $album['title'] }}</h1>
        <h2>{{ $album['artist'] }}</h2>
        <h3>Tracklist</h3>
        <ul id="songs">
            @foreach ($songs as $song)
                <li>{{ $song['title'] }}</li>
            @endforeach
        </ul>
        <div class="album-year">{{ $album['year'] }}</div>
    </div>
</div>
</body>
</html>
