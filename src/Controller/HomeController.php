<?php

namespace App\Controller;

class HomeController extends AbstractController
{
    /**
     * Display home page
     */
    public function index(): string
    {
        $spotify = new SpotifyAPIController();
        $spotify->connectToAPI();
        $track = '3K4HG9evC7dg3N0R9cYqk4';
        $spotify->getTrackInfo($track);
        return $this->twig->render('Home/index.html.twig');
    }
}
