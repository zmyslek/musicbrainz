<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MusicBrainz API</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>
<nav>
    <div class="navbar-left">
        <a href="{{ route('home') }}"><i class="fa fa-home"></i></a>
    </div>
</nav>
<h1>My top 10 favorite artists</h1>
<ol>
    <li><a href="{{ route('artist.show', ['name' => 'boywithuke']) }}">boywithuke</a></li>
    <li><a href="{{ route('artist.show', ['name' => 'Alec Benjamin']) }}">Alec Benjamin</a></li>
    <li><a href="{{ route('artist.show', ['name' => 'Mata']) }}">Mata</a></li>
    <li><a href="{{ route('artist.show', ['name' => 'Chivas']) }}">Chivas</a></li>
    <li><a href="{{ route('artist.show', ['name' => 'One Republic']) }}">One Republic</a></li>
    <li><a href="{{ route('artist.show', ['name' => 'Billie Eilish']) }}">Billie Eilish</a></li>
    <li><a href="{{ route('artist.show', ['name' => 'Stellar']) }}">Stellar</a></li>
    <li><a href="{{ route('artist.show', ['name' => 'Eminem']) }}">Eminem</a></li>
    <li><a href="{{ route('artist.show', ['name' => 'YUNGBLUD']) }}">YUNGBLUD</a></li>
    <li><a href="{{ route('artist.show', ['name' => 'Lin-Manuel Miranda']) }}">Lin-Manuel Miranda</a></li>
</ol>
</body>
</html>
