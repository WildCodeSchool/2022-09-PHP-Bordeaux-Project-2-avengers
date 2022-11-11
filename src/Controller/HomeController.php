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
        // on crée une connexion à l'API de Spotify
        $spotify = new SpotifyAPIController();
        $spotify->connectToAPI();

        // on charge un array à deux dimensions avec des IDs de musiques
        $trackList = $spotify->createTrackLists();

        // on distribue les arrays d'IDs dans des variables qu'on passera individuellement à la vue
        $metalMusic = $trackList[0];
        $rockMusic = $trackList[1];
        $popMusic = $trackList[2];
        $electroMusic = $trackList[3];
        $countryMusic = $trackList[4];

        // on passe les IDs en paramètre dans la méthode de l'APIController (objet $spotify, ici)
        $tracksMetal = $spotify->getMultipleTracks($metalMusic);
        $tracksRock = $spotify->getMultipleTracks($rockMusic);
        $tracksPop = $spotify->getMultipleTracks($popMusic);
        $tracksElectro = $spotify->getMultipleTracks($electroMusic);
        $tracksCountry = $spotify->getMultipleTracks($countryMusic);

        // on retourne la vue twig avec les arrays de musiques qu'on a chargées
        return $this->twig->render('Home/index.html.twig',
            [
                'metal' => $tracksMetal,
                'rock' => $tracksRock,
                'pop' => $tracksPop,
                'electro' => $tracksElectro,
                'country' => $tracksCountry,
            ]);
    }

    public function play(): string
    {
        $trackURL = $_GET['track-id'];
        if ($trackURL === '') {
            header('Location: /');
            die();
        }
        return $this->twig->render('Home/play.html.twig', ['trackURL' => $trackURL]);
    }
}
