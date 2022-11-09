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

        $trackList = $spotify->createTrackLists();

        $metalMusic = $trackList[0];
        $rockMusic = $trackList[1];
        $popMusic = $trackList[2];
        $electroMusic = $trackList[3];
        $countryMusic = $trackList[4];

        $tracksMetal = $spotify->getMultipleTracks($metalMusic);
        $tracksRock = $spotify->getMultipleTracks($rockMusic);
        $tracksPop = $spotify->getMultipleTracks($popMusic);
        $tracksElectro = $spotify->getMultipleTracks($electroMusic);
        $tracksCountry = $spotify->getMultipleTracks($countryMusic);

        return $this->twig->render('Home/index.html.twig',
            [
                'metal' => $tracksMetal,
                'rock' => $tracksRock,
                'pop' => $tracksPop,
                'electro' => $tracksElectro,
                'country' => $tracksCountry,
            ]);
    }
}
