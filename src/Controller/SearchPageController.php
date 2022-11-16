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
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // search on SPOTIFY (keyword "track" is important, instead "song" will be invalid)
            $songTitleFoSpotify = $_POST['search'];
            $spotifySearch = new SpotifyAPIController();
            $spotifySearch->connectToAPI();
            $spotifySongList = $spotifySearch->searchTracks($songTitleFoSpotify, 'track');
            $spotifySongList = $spotifySongList->tracks->items;

            // do a LOCAL search
            $fetchSongsManager = new FetchSongsManager();
            $songs = $fetchSongsManager->songSearch();
            $fetchSongsManagerImg = new FetchSongsManager();
            $rndSongCoverImg = $fetchSongsManagerImg->showImgDir();

            return $this->twig->render('/Home/General/searchPage.html.twig', [
                'songs' => $songs, 'rndSongCoverImg' => $rndSongCoverImg, 'spotifySongList' => $spotifySongList
            ]);
        }
    }
}
