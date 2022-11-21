<?php

namespace App\Controller;

use App\Model\AdminManager;
use App\Model\SongManager;
use App\Model\UserManager;

class AdminController extends AbstractTwigController
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
        $id = intval($id);
        $adminManager = new AdminManager();
        $adminManager->deleteUsersLikes($id);

        $songManager = new SongManager();
        $songs = $songManager->getSongByUserId($id);

        foreach ($songs as $song) {
            if ($song['image_url'] !== null) {
                unlink($song['image_url']);
            }
            unlink($song['song_url']);
        }

        $adminManager->deleteUsersSongs($id); // Deletes users songs by user ID

        $userManager = new UserManager();
        $userManager->delete($id);

        header('Location: /setting/admin');
    }

    public function showAllMusics(): string
    {
        $musicManager = new AdminManager();
        $musics = $musicManager->getAllMusics();

        return $this->twig->render("Setting/Admin/manage-musics.html.twig", ['musics' => $musics]);
    }

    public function showOneMusic($id): string
    {
        $adminManager = new AdminManager();
        $music = $adminManager->getOneMusic($id);

        return $this->twig->render('Setting/Admin/admin-delete-music.html.twig', ['music' => $music]);
    }

    public function deleteMusic($id): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $id = trim($_GET['id']);
            $id = intval($id);
            $adminManager = new AdminManager();
            $adminManager->deleteOneMusic($id);

            header('Location: /setting/admin/manageMusics');
        }
    }
}
