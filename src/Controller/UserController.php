<?php

namespace App\Controller;

use App\Model\UserManager;

class UserController extends AbstractController
{
    /**
     * Show all information for user connected
     */
    public function showOneUser($id): string
    {
        $userModel = new UserManager();
        $user = $userModel->getOneUser($id);

        return $this->twig->render('Setting/show_profile.html.twig', ['user' => $user]);
    }
}
