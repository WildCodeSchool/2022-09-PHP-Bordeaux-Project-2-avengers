<?php

namespace App\Controller;

use App\Controller\Service\FormController;
use App\Model\SongManager;
use App\Model\UserManager;

class SongController extends AbstractController
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
                    $service->trackTreatment($fileTrack)
                );

                if (!empty($errors)) {
                    return $this->twig->render('Setting/add_music.html.twig', ['errors' => $errors]);
                } else {
                    $songManager = new SongManager();
                    $songManager->addSong($song, $fileJacket, $fileTrack);

                    $uploadDirJacket = '../public/jacket/';
                    $uploadJacket = $uploadDirJacket . basename($fileJacket['name']);
                    move_uploaded_file($fileJacket['tmp_name'], $uploadJacket);

                    $uploadDirTrack = '../public/track/';
                    $uploadTrack = $uploadDirTrack . basename($fileTrack['name']);
                    move_uploaded_file($fileTrack['tmp_name'], $uploadTrack);

                    $success = "Your song has been upload with success !";
                    return $this->twig->render('Setting/add_music.html.twig', ['success' => $success]);
                }
            }
        }
        return $this->twig->render('Setting/add_music.html.twig');
    }
}
