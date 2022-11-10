<?php

namespace App\Controller;

use App\Model\UserManager;

class UserController extends AbstractController
{
    /**
     * Show all information for user connected
     */
    public function showOneUser()
    {
        if (!$this->user) {
            echo 'Unauthorized access';
            header('HTTP/1.1 401 Unauthorized');
        } else {
            return $this->twig->render('Setting/show_profile.html.twig');
        }
    }
}
