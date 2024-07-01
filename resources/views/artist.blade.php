<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $artist['name'] ?? 'Artist Not Found' }} - MusicBrainz API</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
</head>
<body>
<nav>
    <div class="navbar-left">
        <a href="{{ route('home') }}"><i class="fa fa-home"></i></a>
    </div>
</nav>
<h1 id="artist-name">{{ $artist['name'] ?? 'Artist Not Found' }}</h1>
<div class="artist-details">
    <div class="about">
        <h2>About the artist</h2>
        @if ($artist)
            <p>Country: {{ $artist['country'] ?? 'N/A' }}</p>
            <p>Gender: {{ $artist['gender'] ?? 'N/A' }}</p>
            <p>Tags: {{ implode(', ', array_column($artist['tags'], 'name')) ?? 'N/A' }}</p>
        @else
            <p>No additional information available.</p>
        @endif
    </div>
    <div class="albums">
        <h2>Albums</h2>
        @if ($albums)
            @foreach ($albums as $album)
                @if ($album['primary-type'] === 'Album')
                    <div class="album">
                        <img src="https://coverartarchive.org/release-group/{{ $album['id'] }}/front-250" alt="{{ $album['title'] }}" class="album-cover">
                    </div>
                @endif
            @endforeach
        @else
            <p>No albums found.</p>
        @endif
    </div>
    <div class="singles">
        <h2>Singles</h2>
        <ul id="singles">
            @if ($albums)
                @foreach ($albums as $single)
                    @if ($single['primary-type'] === 'Single')
                        <li class="single">
                            <i class="fa fa-music"></i> {{ $single['title'] }}
                        </li>
                    @endif
                @endforeach
            @else
                <p>No singles found.</p>
            @endif
        </ul>
    </div>
</div>
<script>
    $(document).ready(function() {
        const artistName = {{$artist['name']}};
        $('#artist-name').text(artistName);

        $.ajax({
            url: `{{ route('artist.show', ['name' => $artist['name']]) }}`,
            method: 'GET',
            success: function(data) {
                if (data.artists && data.artists.length > 0) {
                    const artist = data.artists[0];
                    const artistId = artist.id;

                    // Fetch artist annotations
                    $.ajax({
                        url: `{{ route('artist.annotations', ['id' => ':id']) }}`.replace(':id', artistId),
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
                        url: `{{ route('artist.albums', ['id' => ':id']) }}`.replace(':id', artistId),
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

                            if ($albumsContainer.is(':empty')) {
                                $albumsContainer.text('No albums found.');
                            }
                            if ($singlesContainer.is(':empty')) {
                                $singlesContainer.text('No singles found.');
                            }
                        },
                        error: function(error) {
                            console.error('Error fetching artist albums:', error);
                            $('#albums').text('Error fetching artist albums.');
                            $('#singles').text('Error fetching artist singles.');
                        }
                    });
                } else {
                    $('#artist-name').text('Artist not found');
                    $('#about').text('No additional information available.');
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

<script>
    document.addEventListener('DOMContentLoaded', async function() {
        const params = new URLSearchParams(window.location.search);
        const artistName = params.get('name');
        document.getElementById('artist-name').textContent = artistName;

        try {
            const response = await fetch(`/artist/${encodeURIComponent(artistName)}`);
            if (!response.ok) throw new Error('Failed to fetch artist details');
            const artistData = await response.json();
            console.log('Artist Data:', artistData);

            if (artistData.artists && artistData.artists.length > 0) {
                const artist = artistData.artists[0];
                const artistId = artist.id;

                try {
                    const annotationsResponse = await fetch(`/artist/${artistId}/annotations`);
                    if (!annotationsResponse.ok) throw new Error('Failed to fetch artist annotations');
                    const annotationsData = await annotationsResponse.json();
                    console.log('Annotations Data:', annotationsData);

                    const aboutText = annotationsData.annotation ? annotationsData.annotation : 'No additional information available.';
                    document.getElementById('about').textContent = aboutText;

                    const albumsResponse = await fetch(`/artist/${artistId}/albums`);
                    if (!albumsResponse.ok) throw new Error('Failed to fetch artist albums');
                    const albumsData = await albumsResponse.json();
                    console.log('Albums Data:', albumsData);

                    const albumsContainer = document.getElementById('albums');
                    albumsContainer.innerHTML = '';
                    for (const album of albumsData['release-groups']) {
                        const albumDiv = document.createElement('div');
                        const coverArtUrl = `https://coverartarchive.org/release-group/${album.id}/front-250`;
                        albumDiv.className = 'album';
                        albumDiv.innerHTML = `
                            <a href="album.html?id=${album.id}">
                                <img src="${coverArtUrl}" alt="${album.title}" class="album-cover">
                            </a>
                        `;
                        albumsContainer.appendChild(albumDiv);
                    }

                    const releasesResponse = await fetch(`/artist/${artistId}/releases`);
                    if (!releasesResponse.ok) throw new Error('Failed to fetch artist releases');
                    const releasesData = await releasesResponse.json();
                    console.log('Releases Data:', releasesData);

                    const singlesContainer = document.getElementById('singles');
                    singlesContainer.innerHTML = '';
                    for (const release of releasesData.releases) {
                        if (release['release-group'] && release['release-group']['primary-type'] === 'Single') {
                            const singleItem = document.createElement('li');
                            singleItem.className = 'single';
                            singleItem.textContent = release.title;
                            singlesContainer.appendChild(singleItem);
                        }
                    }
                } catch (annotationError) {
                    console.error('Error fetching artist annotations:', annotationError);
                    document.getElementById('about').textContent = 'Error fetching artist information.';
                }
            } else {
                document.getElementById('about').textContent = 'No artist details found.';
            }
        } catch (error) {
            console.error('Error fetching artist data:', error);
            document.getElementById('about').textContent = 'Error fetching artist information.';
        }
    });
</script>
</body>
</html>
