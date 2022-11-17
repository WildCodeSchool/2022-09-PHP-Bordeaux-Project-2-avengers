<?php

namespace App\Controller;

use App\Model\FetchSongsManager;

class LikePageController extends AbstractTwigController
{
    /**
     * Get liked songs by user ID and display like page
     */
    public function getSongsForLikePage(int $id): string
    {
        $fetchSongs = new FetchSongsManager();
        $likedSongs = $fetchSongs->getLikedSongsById($id);
        $fetchSongsImgs = new FetchSongsManager();
        $rndSongCoverImg = $fetchSongsImgs->showImgDir();

        return $this->twig->render('/Home/General/likePage.html.twig', ['likedSongs' => $likedSongs, 'rndSongCoverImg' => $rndSongCoverImg]);
    }

    /**
     * Get song by song ID and get liked songs by user ID
     */
    public function getSongToPlayLikedSong(int $id, int $userid)
    {
        $fetchSong = new FetchSongsManager();
        $playLikedSong = $fetchSong->selectSongById($id);
        $fetchSongs = new FetchSongsManager();
        $likedSongs = $fetchSongs->getLikedSongsByUserId($userid);
        $fetchSongsImgs = new FetchSongsManager();
        $rndSongCoverImg = $fetchSongsImgs->showImgDir();

        return $this->twig->render('/Home/General/likePlayPage.html.twig', ['playLikedSong' => $playLikedSong, 'likedSongs' => $likedSongs, 'rndSongCoverImg' => $rndSongCoverImg]);
    }
}
