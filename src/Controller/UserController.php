<?php

namespace App\Controller;

use App\Model\UserModel;

class UserController extends AbstractController
{
    public function showOneUser($id): string
    {
        $userModel = new UserModel();
        $user = $userModel->getOneUser($id);

        return $this->twig->render('Setting/profile.html.twig', ['user' => $user]);
    }

    public function editProfile(int $id): ?string
    {
        $userModel = new UserModel();
        $user = $userModel->getOneUser($id);

        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userUpdate = array_map('trim', $_POST);
            $userUpdate = array_map('htmlspecialchars', $_POST);

            if (!isset($_POST['username']) || trim($_POST['username'] === '')) {
                $errors[] = 'Username is require.';
            }
            if (strlen($_POST['username']) < 3) {
                $errors[] = 'Username must have 3 letters minimum.';
            }

            if (!empty($_POST['password']) and empty($userUpdate['new-password'])) {
                $errors[] = 'You must write your actual password and a new password to change it.';
            }

            if (!empty($userUpdate['new-password'])) {
                if (empty($userUpdate['password'])) {
                    $errors[] = 'You must write your actual password to change it.';
                }
                if ($userUpdate['password'] != $user['password']) {
                    $errors[] = 'Actual password is not correct.';
                } else {
                    $userUpdate['password'] = $_POST['new-password'];
                }
            } else {
                $userUpdate['password'] = $user['password'];
            }

            if (!empty($errors)) {
                return $this->twig->render('Setting/profile-update.html.twig', array(
                    'errors' => $errors,
                    'user' => $user));

            } else {
                $userModel->update($userUpdate);
                $success = "Your profile has been update with success !";
                $userUpdate['email'] = $user['email'];
                return $this->twig->render('Setting/profile.html.twig', array(
                    'success' => $success,
                    'user' => $userUpdate));
            }
        }

        return $this->twig->render('Setting/profile-update.html.twig', [
            'user' => $user,
        ]);
    }

    public function showDeletePage($id): string
    {
        $userModel = new UserModel();
        $user = $userModel->getOneUser($id);

        return $this->twig->render('Setting/profile-delete.html.twig', ['user' => $user]);
    }

    public function deleteUser(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = trim($_POST['delete']);
            $userModel = new UserModel();
            $userModel->delete($id);

            header('Location: /');
        }
    }

    public function login(): string
    {
        $userModel = new UserModel();

        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $_POST['email'] = htmlspecialchars($_POST['email']);
            $_POST['password'] = htmlspecialchars($_POST['password']);

            if (!isset($_POST['email']) || trim($_POST['email'] === '')) {
                $errors[] = 'Email is require.';
            }
            if (!isset($_POST['password']) || trim($_POST['password'] === '')) {
                $errors[] = 'Password is require.';
            }

            if (!empty($errors)) {
                return $this->twig->render('General/login.html.twig', ['errors' => $errors]);

            } else {
                $email = $_POST['email'];
                $password = $_POST['password'];

                $user = $userModel->login($email, $password);

                if ($user === False) {
                    $errors[] = "Email or password not correct";
                    return $this->twig->render('General/login.html.twig', ['errors' => $errors]);
                } else {
                    header('Location: /setting/profile?id=' . $user['ID_user']);
                }
            }
        }
        return $this->twig->render('General/login.html.twig',);

    }
}
