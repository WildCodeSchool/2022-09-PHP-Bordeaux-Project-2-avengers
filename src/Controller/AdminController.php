<?php

namespace App\Controller;

use App\Model\AdminManager;

class AdminController extends AbstractController
{
    public function showAllUsers(): string
    {
        $adminManager = new AdminManager();
        $users = $adminManager->getAllUsers();

      
        return $this->twig->render('Setting/Admin/admin.html.twig', ['users' => $users]);
    }

    public function showDeleteUser($id): string
    {
        $adminManager = new AdminManager();
        $admin = $adminManager->selectOneUser($id);

        
        return $this->twig->render('Setting/Admin/admin-delete.html.twig', ['admin' => $admin]);
    }

    public function deleteUser($id): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $id = trim($_GET['id']);



            $adminManager = new AdminManager();
            $adminManager->deleteOneUser($id);

            header('Location: /setting/admin');
        }
    }


    public function showAllMusics(): string
    {
        $musicManager = new AdminManager();
        $musics= $musicManager->getAllMusics();

        return $this->twig->render("Setting/Admin/manage-musics.html.twig", ['musics' => $musics]);
    }

}