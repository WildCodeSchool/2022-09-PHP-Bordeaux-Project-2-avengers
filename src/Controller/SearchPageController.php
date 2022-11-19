<?php

namespace App\Controller;

use App\Model\FetchSongsManager;

class SearchPageController extends AbstractTwigController
{
    /**
     * Displays search page
     */
    public function searchSongs()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            if (empty($_GET['search'])) {
                return $this->twig->render('/Home/General/searchPage.html.twig');
            }

            // search on SPOTIFY (keyword "track" is important, instead "song" will be invalid)
            $songTitleFoSpotify = $_GET['search'];
            $spotifySearch = new SpotifyAPIController();
            $spotifySearch->connectToAPI();
            $spotifySongList = $spotifySearch->searchTracks($songTitleFoSpotify, 'track');
            $spotifySongList = $spotifySongList->tracks->items;

            // do a LOCAL search
            $fetchSongsManager = new FetchSongsManager();
            $songs = $fetchSongsManager->songSearch(); // Gets song by search value
            $rndSongCoverImg = $fetchSongsManager->showImgDir(); // Get images for song covers and background

            return $this->twig->render('/Home/General/searchPage.html.twig', [
                'songs' => $songs,
                'rndSongCoverImg' => $rndSongCoverImg,
                'spotifySongList' => $spotifySongList
            ]);
        }
    }
}
