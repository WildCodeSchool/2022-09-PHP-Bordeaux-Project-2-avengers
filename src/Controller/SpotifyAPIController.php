<?php

namespace App\Controller;

class SpotifyAPIController
{
    private string $clientId;
    private string $clientSecret;
    private string $redirectUri;

    public function __construct
    (
        string $clientId = 'db9effd8139e4d699e186fea3d7f6bd1',
        string $clientSecret = '6e9f03008be7451b9f59d0704d2d392e',
        string $redirectUri = 'http://localhost:8888/public/index.php'
    )
    {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->redirectUri = $redirectUri;
    }

    /* FONCTION CRUD */

    public function connectToAPI()
    {
        $session = new SpotifyWebAPI\Session
        (
            $this->getClientId(),
            $this->getClientSecret(),
            $this->getRedirectUri()
        );

        $api = new SpotifyWebAPI\SpotifyWebAPI();
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
     * @param string $clientId
     */
    public function setClientId(string $clientId): void
    {
        $this->clientId = $clientId;
    }

    /**
     * @return string
     */
    public function getClientSecret(): string
    {
        return $this->clientSecret;
    }

    /**
     * @param string $clientSecret
     */
    public function setClientSecret(string $clientSecret): void
    {
        $this->clientSecret = $clientSecret;
    }

    /**
     * @return string
     */
    public function getRedirectUri(): string
    {
        return $this->redirectUri;
    }

    /**
     * @param string $redirectUri
     */
    public function setRedirectUri(string $redirectUri): void
    {
        $this->redirectUri = $redirectUri;
    }

}
