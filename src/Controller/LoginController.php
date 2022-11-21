<?php

namespace App\Controller;

use App\Model\UserManager;

class LoginController extends AbstractTwigController
{
    /**
     * Verify login then redirection
     */
    public function login()
    {
        $userModel = new UserManager();

        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $_POST = array_map('trim', $_POST);
            $_POST = array_map('htmlspecialchars', $_POST);

            if (empty($_POST['email'])) {
                $errors[] = 'Email is require.';
            }
            if (empty($_POST['password'])) {
                $errors[] = 'Password is require.';
            }
            if (!empty($errors)) {
                header('Location: /');
            } else {
                $user = $userModel->login($_POST['email'], $_POST['password']);

                if ($user) {
                    $_SESSION['ID_user'] = $user['ID_user'];
                }

                header('Location: /');
            }
        }
    }
}
