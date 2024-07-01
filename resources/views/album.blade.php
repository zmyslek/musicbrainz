<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Album Details</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
<nav>
    <div class="navbar-left">
        <a href="{{ route('home') }}"><i class="fa fa-home"></i></a>
    </div>
</nav>
<h1>Album Details</h1>
<div id="album-results"></div>
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
