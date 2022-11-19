<?php

namespace App\Controller;

use App\Model\FetchSongsManager;

class PlayPageController extends AbstractTwigController
{
    /**
     * Get songs by song ID and display Play page
     */
    public function getSongsForPlayPage(int $id): string
    {
        $fetchSongsManager = new FetchSongsManager();
        $song = $fetchSongsManager->selectSongById($id); // Get song one song for play page
        $artistSongs = $fetchSongsManager->getsongList($id); // Get list of songs by the artist for play page
        $rndSongCoverImg = $fetchSongsManager->showImgDir(); // Get images for song covers and background
        $likedController = new LikePageController();
        $likeId = $likedController->likeSong(); // Checks if songs are liked

        return $this->twig->render('/Home/General/playPage.html.twig', [
            'song' => $song,
            'artistSongs' => $artistSongs,
            'rndSongCoverImg' => $rndSongCoverImg,
            'likeId' => $likeId
        ]);
    }

    /**
     * Once you click on a track to play in the homepage, catch the sample info with "$_GET" to feed the music player
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function playSpotifySong()
    {
        // get the music sample from the homepage (then from SPOTIFY)
        $trackURL = $_GET['spotify-sample'];
        $trackArtist = $_GET['spotify-artist'];
        $trackTitle = $_GET['spotify-title'];
        $trackImg = $_GET['spotify-img'];
        //Get random image for play page bacjground
        $fetchSongsManagerImg = new FetchSongsManager();
        $rndSongCoverImg = $fetchSongsManagerImg->showImgDir();

        // if no sample is available, redirect toward homepage
        if ($trackURL === '') {
            header('Location: /');
        }
        return $this->twig->render(
            '/Home/General/spotifyPlayPage.html.twig',
            ['trackURL' => $trackURL,
            'trackArtist' => $trackArtist,
            'trackTitle' => $trackTitle,
            'trackImg' => $trackImg,
            'rndSongCoverImg' => $rndSongCoverImg]
        );
    }
}
