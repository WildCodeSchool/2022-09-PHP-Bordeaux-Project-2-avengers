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

//            // Send the user along and fetch some data!
//            // (redirection non nécessaire, appel de deux méthodes à la suite)
//            header('Location: /');
//            die();
        }
    }

    /* FONCTIONS CRUD - Récupérer les infos de */

    public function getTrackInfo(string $track): string
    {
        // On récupère le token dans notre variable session.
        // Il est possible de le stocker dans une BDD, sinon.
        $accessToken = $_SESSION['access-token'];

        $api = new SpotifyWebAPI\SpotifyWebAPI();
        $api->setAccessToken($accessToken);

        $track = $api->getTrack($track);

        // It's now possible to request data from the Spotify catalog
        return
            "Titre :<br>"
            . $track->name
            . "<br>Artiste :<br>"
            . $track->artists[0]->name
            . "<br>Album :<br>"
            . $track->album->name
            . "<br>Date de sortie :<br>"
            . $track->album->release_date
            . "<br>URL de l'image:<br>"
            . $track->album->images[1]->url;

//        Ex. pour Récupérer des infos sur une chanson dans le Controller
//        $track = '3K4HG9evC7dg3N0R9cYqk4';
//        echo $spotify->getTrackInfo($track);
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
