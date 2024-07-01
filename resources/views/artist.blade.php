<!-- resources/views/artist.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $name }} - MusicBrainz API</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
</head>
<body>
<nav>
    <div class="navbar-left">
        <a href="{{ route('home') }}"><i class="fa fa-home"></i></a>
    </div>
</nav>
<h1 id="artist-name">{{ $name }}</h1>
<div class="artist-details">
    <div class="albums">
        <h2>Albums</h2>
        <div id="albums">Loading albums...</div>
    </div>
    <div class="about">
        <h2>About the artist</h2>
        <p id="about">Loading artist bio...</p>
        <div class="singles">
            <h2>Singles</h2>
            <ul id="singles">Loading singles...</ul>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        const artistName = '{{ $name }}';
        $('#artist-name').text(artistName);

        $.ajax({
            url: `/artist/${artistName}`,
            method: 'GET',
            success: function(data) {
                if (data.artists && data.artists.length > 0) {
                    const artist = data.artists[0];
                    const artistId = artist.id;

                    // Display artist details
                    $('#artist-name').text(artist.name);

                    // Fetch artist annotations
                    $.ajax({
                        url: `/artist/${artistId}/annotations`,
                        method: 'GET',
                        success: function(annotationData) {
                            const annotation = annotationData.annotation;
                            $('#about').text(annotation ? annotation : 'No additional information available.');
                        },
                        error: function(error) {
                            console.error('Error fetching artist annotations:', error);
                            $('#about').text('Error fetching artist annotations.');
                        }
                    });

                    // Fetch artist albums
                    $.ajax({
                        url: `/artist/${artistId}/albums`,
                        method: 'GET',
                        success: function(albumData) {
                            const albums = albumData['release-groups'];
                            const $albumsContainer = $('#albums');
                            $albumsContainer.empty();

                            albums.forEach(album => {
                                if (album['primary-type'] === 'Album') {
                                    const albumDiv = `
                                        <div class="album">
                                            <img src="https://coverartarchive.org/release-group/${album.id}/front-250" alt="${album.title}" class="album-cover">
                                            <div class="album-title">${album.title}</div>
                                        </div>
                                    `;
                                    $albumsContainer.append(albumDiv);
                                }
                            });

                            // Fetch artist singles
                            const $singlesContainer = $('#singles');
                            $singlesContainer.empty();

                            albums.forEach(single => {
                                if (single['primary-type'] === 'Single') {
                                    const singleItem = `
                                        <li class="single">
                                            <i class="fa fa-music"></i> ${single.title}
                                        </li>
                                    `;
                                    $singlesContainer.append(singleItem);
                                }
                            });
                        },
                        error: function(error) {
                            console.error('Error fetching artist albums:', error);
                        }
                    });
                } else {
                    $('#artist-name').text('Artist not found.');
                    $('#about').text('');
                    $('#albums').text('No albums found.');
                    $('#singles').text('No singles found.');
                }
            },
            error: function(error) {
                console.error('Error fetching artist information:', error);
                $('#about').text('Error fetching artist information.');
            }
        });
    });
</script>
</body>
</html>
