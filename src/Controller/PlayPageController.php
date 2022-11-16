<?php

namespace App\Controller;

use App\Model\FetchSongsManager;

class PlayPageController extends AbstractController
{
    /**
     * Get songs by song ID and display Play page
     */
    public function getSongsForPlayPage(int $id): string
    {
            $fetchSongsManager = new FetchSongsManager();
            $song = $fetchSongsManager->selectSongById($id);
            $fetchSongs = new FetchSongsManager();
            $artistSongs = $fetchSongs->getsongList($id);
            $fetchSongsManagerImg = new FetchSongsManager();
            $rndSongCoverImg = $fetchSongsManagerImg->showImgDir();
    
            return $this->twig->render('/Home/General/playPage.html.twig', ['song' => $song, 'artistSongs' => $artistSongs, 'rndSongCoverImg' =>$rndSongCoverImg]);
    }
}