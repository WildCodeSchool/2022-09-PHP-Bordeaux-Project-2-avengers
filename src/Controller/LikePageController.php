<?php

namespace App\Controller;

use App\Model\FetchSongsManager;
use App\Model\SongManager;

class LikePageController extends AbstractTwigController
{
    /**
     * Get liked songs by user ID and display like page
     */
    public function getSongsForLikePage(int $id): string
    {
        $fetchSongsManager = new FetchSongsManager();
        $likedSongs = $fetchSongsManager->getLikedSongsById($id); // Gets liked songs by user ID
        $rndSongCoverImg = $fetchSongsManager->showImgDir(); // Get images for song covers and background

        return $this->twig->render('/Home/General/likePage.html.twig', [
            'likedSongs' => $likedSongs,
            'rndSongCoverImg' => $rndSongCoverImg]);
    }

    /**
     * Get song by song ID and get liked songs by user ID
     */
    public function getSongToPlayLikedSong(int $id, int $userid)
    {
        $fetchSongsManager = new FetchSongsManager();
        $playLikedSong = $fetchSongsManager->selectSongById($id); // Gets song by song ID
        $likedSongs = $fetchSongsManager->getLikedSongsByUserId($userid); // Gets list of liked songs by user ID
        $rndSongCoverImg = $fetchSongsManager->showImgDir(); // Get images for song covers and background
        $likeId = $this->likeSong(); // Checks if songs are liked

        return $this->twig->render('/Home/General/likePlayPage.html.twig', [
            'playLikedSong' => $playLikedSong,
            'likedSongs' => $likedSongs,
            'rndSongCoverImg' => $rndSongCoverImg,
            'likeId' => $likeId]);
    }

    public function likeSong(): array
    {
        $songManager = new SongManager();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idUser = $this->user['ID_user'];
            $idSong = $_POST['ID_song'];

            $likedSong = $songManager->checkSongLiked($idUser, $idSong);

            if ($likedSong) {
                $songManager->deleteLikedSong($idUser, $idSong);
            } else {
                $songManager->addLikedSong($idUser, $idSong);
            }
        }

        $likes = $songManager->getLikeByUserId($this->user['ID_user']);
        $likeId = [];
        foreach ($likes as $like) {
            foreach ($like as $id) {
                $likeId[] = $id;
            }
        }
        return $likeId;
    }
}
