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

    /**
     * treatment add music POST
     */
    public function addSongForm($post): array|null
    {
        $errors = [];

        if (empty($post['title'])) {
            $errors[] = 'Title is require.';
        }
        if (empty($post['artist'])) {
            $errors[] = 'Artist is require.';
        }
        if ($post['genre'] == 'select-genre') {
            $errors[] = 'Genre is require.';
        }

        return $errors;
    }

    /**
     * treatment add music FILE jacket
     */
    public function jacketTreatment($jacket): array|null
    {
        $errors = [];

        $extensionJacket = pathinfo($jacket['name'], PATHINFO_EXTENSION);
        $validJacketExt = ['jpg', 'jpeg', 'png'];
        $maxFileSize = 5000000;

        if ($jacket['error'] !== 4) {
            if (!in_array($extensionJacket, $validJacketExt)) {
                $errors[] = 'You must choose a jacket with .jpg or .jpeg or .png extension.';
            }

            if (filesize($jacket['tmp_name']) > $maxFileSize) {
                $errors[] = "Your jacket file must be less to 5M.";
            }
        }
        return $errors;
    }

    /**
     * treatment add music FILE track
     */
    public function trackTreatment($track, $song): array|null
    {
        $errors = [];

        $uploadDir = '../public/songs/' . $song['artist'] . '/';
        $uploadTrack = $uploadDir . basename($track['name']);
        $extensionTrack = pathinfo($track['name'], PATHINFO_EXTENSION);
        $validTrackExt = ['mp3', 'wav'];
        $maxFileSize = 5000000;

        if ($track['error'] == 4) {
            $errors[] = "You must select a track to upload.";
        } else {
            if (file_exists($uploadTrack)) {
                $errors[] = "This track file already exist.";
            } else {
                if ((!in_array($extensionTrack, $validTrackExt))) {
                    $errors[] = 'You must choose a file with .mp3 or .wav extension.';
                }

                if (filesize($track['tmp_name']) > $maxFileSize) {
                    $errors[] = "Your track file must be less to 5M.";
                }
            }
        }

        return $errors;
    }

    public function errorContact($post): array|null
    {
        $errors = [];

        if (empty($post['subject'])) {
            $errors[] = 'Subject is require.';
        }
        if (empty($post['message'])) {
            $errors[] = 'Message is require.';
        }
        if (!filter_var($post['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Email is not valid.';
        }
        return $errors;
    }
}
