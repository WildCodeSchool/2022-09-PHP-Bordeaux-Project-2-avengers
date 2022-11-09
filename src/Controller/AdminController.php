<?php

namespace App\Controller;

use App\Model\AdminManager;

class AdminController extends AbstractController
{
    public function showAllUsers(): string
    {
        $adminManager = new AdminManager();
        $users = $adminManager->getAllUsers();

        //var_dump($users);
       // die();
        return $this->twig->render('Setting/Admin/admin.html.twig', ['users' => $users]);
    }
}