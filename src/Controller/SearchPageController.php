<?php

namespace App\Controller;

use App\Model\FetchSongsManager;

class SearchPageController extends AbstractController
{
    /**
     * Displays search page
     */
    public function searchSongs()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $fetchSongsManager = new FetchSongsManager();
            $songs = $fetchSongsManager->songSearch();
            $fetchSongsManagerImg = new FetchSongsManager();
            $rndSongCoverImg = $fetchSongsManagerImg->showImgDir();
    
            return $this->twig->render('/Home/General/searchPage.html.twig', ['songs' => $songs, 'rndSongCoverImg' => $rndSongCoverImg]);
        }
    }
}