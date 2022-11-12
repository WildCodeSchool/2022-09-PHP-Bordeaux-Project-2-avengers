<?php

namespace App\Controller\Service;

class FormController
{
    /**
     * treatment to update form
     */
    public function emptyForm($post): array|null
    {
        $errors = [];


        if (empty($post['username'])) {
            $errors[] = 'Username is require.';
        }
        if (strlen($post['username']) < 3) {
            $errors[] = 'Username must have 3 letters minimum.';
        }

        if (!empty($post['password']) and empty($post['new-password'])) {
            $errors[] = 'You must write your actual password and a new password to change it.';
        }

        return $errors;
    }

    public function addSongForm($post): array|null
    {
        $errors = [];

        if (empty($post['title'])) {
            $errors[] = 'Title is require.';
        }
        if (empty($post['artist'])) {
            $errors[] = 'Artist is require.';
        }
        if (empty($post['genre']) == 'select-genre') {
            $errors[] = 'Genre is require.';
        }

        return $errors;
    }

    public function jacketTreatment($jacket): array|null
    {
        $errors = [];

        $uploadDirJacket = '../public/jacket/';
        $uploadJacket = $uploadDirJacket . basename($jacket['name']);
        $extensionJacket = pathinfo($jacket['name'], PATHINFO_EXTENSION);
        $validJacketExt = ['jpg', 'jpeg', 'png'];
        $maxFileSize = 5000000;

        if (!in_array($extensionJacket, $validJacketExt)) {
            $errors[] = 'You must choose a picture with .jpg or .jpeg or .png extension.';
        }

        if (filesize($jacket['tmp_name']) > $maxFileSize) {
            $errors[] = "Your file must be less to 5M.";
        }

        if (file_exists($uploadJacket)) {
            $errors[] = "This jacket file already exist.";
        }

        return $errors;
    }

    public function trackTreatment($track): array|null
    {
        $errors = [];

        $uploadDirTrack = '../public/track/';
        $uploadTrack = $uploadDirTrack . basename($track['name']);
        $extensionTrack = pathinfo($track['name'], PATHINFO_EXTENSION);
        $validTrackExt = ['mp3', 'wav'];
        $maxFileSize = 5000000;

        if ((!in_array($extensionTrack, $validTrackExt))) {
            $errors[] = 'You must choose a file with .mp3 or .wav extension.';
        }

        if (filesize($track['tmp_name']) > $maxFileSize) {
            $errors[] = "Your file must be less to 5M.";
        }

        if (file_exists($uploadTrack)) {
            $errors[] = "This track file already exist.";
        }

        return $errors;
    }
}