<?php

namespace App\Controller;

use SpotifyWebAPI;

class SpotifyAPIController
{
    private string $clientId;
    private string $clientSecret;

    public function __construct
    (
        string $clientId = 'db9effd8139e4d699e186fea3d7f6bd1',
        string $clientSecret = '6e9f03008be7451b9f59d0704d2d392e'
    )
    {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
    }

    /* FONCTION DE CONNEXION */

    /**
     * Manage connection to Spotify API
     *
     * A user must be a Spotify user to login and must be added to the list of authorized people before,
     * by Alexis (manager of the App on Spotify)
     *
     * @return void
     */
    public function connectToAPI(): void
    {
        // Processus de connexion sans devoir passer par l'authentification Spotify
        if (!isset($_SESSION['access-token'])) {
            $session = new SpotifyWebAPI\Session(
                $this->getClientId(),
                $this->getClientSecret());

            $session->requestCredentialsToken();
            $accessToken = $session->getAccessToken();

            // On place le token dans notre variable session.
            // Il est possible de le stocker dans une BDD, sinon.
            $_SESSION['access-token'] = $accessToken;

        }
    }

    /* FONCTIONS CRUD - Récupérer les infos des chansons */

    /**
     * Get the info of one track at a time
     *
     * @param string $track
     * @return array|object
     */
    public function getTrackInfo(string $track)
    {
        // On récupère le token dans notre variable session.
        // Il est possible de le stocker dans une BDD, sinon.
        $accessToken = $_SESSION['access-token'];

        $api = new SpotifyWebAPI\SpotifyWebAPI();
        $api->setAccessToken($accessToken);

        return $track = $api->getTrack($track);

    }

    /**
     * Get the info of multiple tracks, feeding the function an array of track IDs
     *
     * @param array $tracks
     * @return array|object
     */
    public function getMultipleTracks(array $tracks)
    {
        // On récupère le token dans notre variable session.
        // Il est possible de le stocker dans une BDD, sinon.
        $accessToken = $_SESSION['access-token'];

        $api = new SpotifyWebAPI\SpotifyWebAPI();
        $api->setAccessToken($accessToken);

        return $tracks = $api->getTracks($tracks);
    }

    /**
     * Function to artificially inject songs ID to the "get mutiple tracks" function
     * You need first to look for a song on Spotify and get its ID in the URL
     *
     * @return \string[][]
     */
    public function createTrackLists(): array
    {
        $metalMusic = [
            '3K4HG9evC7dg3N0R9cYqk4',
            '61mWefnWQOLf90gepjOCb3',
            '3IDOmkdbqgOiMORoyiQtyS',
            '0tljt9o0lVww8YPGq4S6Vf',
            '3QOgIKOmAGdcMqeGa3Yl5C',
            '6NwbeybX6TDtXlpXvnUOZC'
        ];
        $rockMusic = [
            '25H6P7a94WUr5102lC6TNI',
            '4gphxUgq0JSFv2BCLhNDiE',
            '3EYOJ48Et32uATr9ZmLnAo',
            '6kooDsorCpWVMGc994XjWN',
            '60VNmTr9ox1PaCIOCprfIa',
            '2Cdvbe2G4hZsnhNMKyGrie'
        ];
        $popMusic = [
            '4r6eNCsrZnQWJzzvFh4nlg',
            '0nucG9RsYTuv5Ztm5f4cnu',
            '6ZBJFWDYJSTQg54eDsqnkJ',
            '7qiZfU4dY1lWllzX7mPBI3',
            '7Lf7oSEVdzZqTA0kEDSlS5',
            '6I9VzXrHxO9rA9A5euc8Ak'
        ];
        $electroMusic = [
            '1pKYYY0dkg23sQQXi0Q5zN',
            '4wSmqFg31t6LsQWtzYAJob',
            '6VRhkROS2SZHGlp0pxndbJ',
            '0UAEHlFR79k9CJvknSGUNf',
            '3u5N55tHf7hXATSQrjBh2q',
            '0molLCkfeNcLxV3oNgGY9a'
        ];
        $countryMusic = [
            '5rDkA2TFOImbiVenmnE9r4',
            '3g5k04QYJJgcpwErTwMoaB',
            '6LahUh0U4umx6hDFfVWlGi',
            '0eZcFq1zvOh6buqrL4VBhP',
            '2SpEHTbUuebeLkgs9QB7Ue',
            '7cyBw7bpAOYhzyNv7yqW6y'
        ];

        return $tracks = [$metalMusic, $rockMusic, $popMusic, $electroMusic, $countryMusic];
    }

    /**
     * Search for a term of a given type
     * (ex. "The Queen", "Artist")
     * (ex. "Rock", "Playlist")
     *
     * @param $search
     * @param $type
     * @return array|object
     */
    public function searchTracks($search, $type)
    {
        // On récupère le token dans notre variable session.
        // Il est possible de le stocker dans une BDD, sinon.
        $accessToken = $_SESSION['access-token'];

        $api = new SpotifyWebAPI\SpotifyWebAPI();
        $api->setAccessToken($accessToken);

        return $api->search($search, $type);
    }

    /* GETTERS AND SETTERS */

    /**
     * @return string
     */
    public function getClientId(): string
    {
        return $this->clientId;
    }

    /**
     * @return string
     */
    public function getClientSecret(): string
    {
        return $this->clientSecret;
    }

}
