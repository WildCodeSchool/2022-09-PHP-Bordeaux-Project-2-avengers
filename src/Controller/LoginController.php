<?php

namespace App\Controller;

use App\Model\UserManager;

class LoginController extends AbstractTwigController
{
    /**
     * Verify login then redirection
     */
    public function login(): string
    {
        $userModel = new UserManager();

        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $_POST['email'] = htmlspecialchars($_POST['email']);
            $_POST['password'] = htmlspecialchars($_POST['password']);

            if (!isset($_POST['email'])) {
                $errors[] = 'Email is require.';
            }
            if (!isset($_POST['password'])) {
                $errors[] = 'Password is require.';
            }
            if (!empty($errors)) {
                return $this->twig->render('Home/index.html.twig', ['errors' => $errors]);
            } else {
                $email = $_POST['email'];
                $password = $_POST['password'];

                $user = $userModel->login($email, $password);

                if ($user === false) {
                    $errors[] = "Email or password not correct";
                    return $this->twig->render('Home/index.html.twig', ['errors' => $errors]);
                } else {
                    $_SESSION['ID_user'] = $user['ID_user'];
                    header('Location: /');
                }
            }
        }
        return $this->twig->render('Home/index.html.twig');
    }
}
