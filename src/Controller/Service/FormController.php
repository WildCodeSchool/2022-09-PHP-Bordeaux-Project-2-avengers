<?php

namespace App\Controller\Service;

class FormController
{
    /**
     * treatment to update form
     */
    public function emptyForm($post): array | null
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
}
