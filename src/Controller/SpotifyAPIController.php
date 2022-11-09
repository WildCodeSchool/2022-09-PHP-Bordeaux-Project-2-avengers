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

    public function getTrackInfo(string $track)
    {
        // On récupère le token dans notre variable session.
        // Il est possible de le stocker dans une BDD, sinon.
        $accessToken = $_SESSION['access-token'];

        $api = new SpotifyWebAPI\SpotifyWebAPI();
        $api->setAccessToken($accessToken);

        return $track = $api->getTrack($track);

    }

    public function getMultipleTracks(array $tracks)
    {
        // On récupère le token dans notre variable session.
        // Il est possible de le stocker dans une BDD, sinon.
        $accessToken = $_SESSION['access-token'];

        $api = new SpotifyWebAPI\SpotifyWebAPI();
        $api->setAccessToken($accessToken);

        return $tracks = $api->getTracks($tracks);
    }

    public function searchTracks($genre, $type)
    {
        // On récupère le token dans notre variable session.
        // Il est possible de le stocker dans une BDD, sinon.
        $accessToken = $_SESSION['access-token'];

        $api = new SpotifyWebAPI\SpotifyWebAPI();
        $api->setAccessToken($accessToken);

        return $api->search($genre, $type);
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
