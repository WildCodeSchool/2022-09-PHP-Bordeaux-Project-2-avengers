<?php

namespace App\Controller;

use App\Model\GeneralManager;

class GeneralController extends AbstractController
{

    /**
     * Displays search page
     */
    public function searchSongs()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $GeneralManager = new GeneralManager();
            $songs = $GeneralManager->songSearch();
            $GeneralManagerImg = new GeneralManager();
            $rndSongCoverImg = $GeneralManagerImg->showImgDir();
    
            return $this->twig->render('/Home/General/searchPage.html.twig', ['songs' => $songs, 'rndSongCoverImg' => $rndSongCoverImg]);
        }
    }

    /**
     * Get songs by song ID and display Play page
     */
    public function getSongsForPlayPage(int $id): string
    {

            $GeneralManager = new GeneralManager();
            $song = $GeneralManager->selectSongById($id);
            $GeneralManagerSongs = new GeneralManager();
            $artistSongs = $GeneralManagerSongs->getsongList($id);
            $GeneralManagerImg = new GeneralManager();
            $rndSongCoverImg = $GeneralManagerImg->showImgDir();
    
            return $this->twig->render('/Home/General/playPage.html.twig', ['song' => $song, 'artistSongs' => $artistSongs, 'rndSongCoverImg' =>$rndSongCoverImg]);
    }

}