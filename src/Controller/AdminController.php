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

    public function deleteUser($id): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $id = trim($_GET['id']);

        //var_dump($id);
      //  die();


            $adminManager = new AdminManager();
            $adminManager->deleteOneUser($id);

            header('Location: /setting/admin');
        }
    }

    public function showDeleteUser($id): string 
    {
        $adminManager = new AdminManager();
        $admin = $adminManager->selectOneUser($id);

        //var_dump($admin);
        //die();

        return $this->twig->render('Setting/Admin/admin-delete.html.twig', ['admin' => $admin]);
    }
}
