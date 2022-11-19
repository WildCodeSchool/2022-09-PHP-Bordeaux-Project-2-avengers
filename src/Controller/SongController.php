<?php

namespace App\Controller;

use App\Controller\Service\FormController;
use App\Model\FetchSongsManager;
use App\Model\SongManager;
use App\Model\UserManager;

class SongController extends AbstractTwigController
{
    /**
     *  Add music upload files
     */
    public function addSong(): string
    {
        if (!$this->user) {
            echo 'Unauthorized access';
            header('HTTP/1.1 401 Unauthorized');
        } else {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $service = new FormController();

                $song = array_map('trim', $_POST);
                $song = array_map('htmlspecialchars', $_POST);
                $fileJacket = $_FILES['jacket_file'];
                $fileTrack = $_FILES['track_file'];

                $errors = array_merge(
                    $service->addSongForm($song),
                    $service->jacketTreatment($fileJacket),
                    $service->trackTreatment($fileTrack, $song)
                );

                if (!empty($errors)) {
                    return $this->twig->render('Setting/add_music.html.twig', ['errors' => $errors]);
                } else {
                    if (!file_exists('../public/songs/' . $song['artist'])) {
                        mkdir('../public/songs/' . $song['artist']);
                    }

                    $uploadDir = '../public/songs/' . $song['artist'] . '/';
                    $uploadDirDb = 'songs/' . $song['artist'] . '/';
                    if ($fileJacket['error'] !== 4) {
                        $uploadJacket = $uploadDir . basename($fileJacket['name']);
                        move_uploaded_file($fileJacket['tmp_name'], $uploadJacket);
                        $fileJacket['name'] = $uploadDirDb . $fileJacket['name'];
                    } else {
                        $fileJacket['name'] = null;
                    }
                    $uploadTrack = $uploadDir . basename($fileTrack['name']);
                    move_uploaded_file($fileTrack['tmp_name'], $uploadTrack);
                    $fileTrack['name'] = $uploadDirDb . $fileTrack['name'];

                    $songManager = new SongManager();
                    $songManager->addSong($song, $fileJacket, $fileTrack);

                    $success = "Your song has been upload with success !";
                    return $this->twig->render('Setting/add_music.html.twig', ['success' => $success]);
                }
            }
        }
        return $this->twig->render('Setting/add_music.html.twig');
    }

    public function showSongById(): string
    {
        $fetchSongsManagerImg = new FetchSongsManager();
        $rndSongCoverImg = $fetchSongsManagerImg->showImgDir();
        $songManager = new SongManager();
        $songs = $songManager->getSongByUserId($this->user['ID_user']);

        return $this->twig->render('Setting/manage_music.html.twig', [
            'songs' => $songs,
            'rndSongCoverImg' => $rndSongCoverImg]);
    }
}
