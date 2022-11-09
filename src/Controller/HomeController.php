<?php

namespace App\Controller;

/**
 * In case of access problem to a specific page,
 * try and check the authorized RedirectURI on the Dashboard of Spotify App
 */
class HomeController extends AbstractController
{
    /**
     * Display home page
     */
    public function index(): string
    {
        $spotify = new SpotifyAPIController();
        $spotify->connectToAPI();

        $trackList = [
            '3K4HG9evC7dg3N0R9cYqk4',
            '6n8TMVyFKoUmDc4apxceRD',
            '5rDkA2TFOImbiVenmnE9r4',
            '2VxeLyX666F8uXCJ0dZF8B'];
        $tracks = $spotify->getMultipleTracks($trackList);

        return $this->twig->render('Home/index.html.twig', ['tracks' => $tracks]);
    }
}
