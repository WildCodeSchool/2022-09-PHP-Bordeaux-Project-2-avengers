<?php

namespace App\Controller;

use App\Controller\Service\FormController;
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

    /**
     * Edit information for user connected
     */
    public function editProfile(): ?string
    {
        if (!$this->user) {
            echo 'Unauthorized access';
            header('HTTP/1.1 401 Unauthorized');
        } else {
            $userManager = new UserManager();

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $service = new FormController();

                $userUpdate = array_map('trim', $_POST);
                $userUpdate = array_map('htmlspecialchars', $_POST);

                $errors = $service->emptyForm($userUpdate);

                if (!empty($userUpdate['new-password'])) {
                    if (empty($userUpdate['password'])) {
                        $errors[] = 'You must write your actual password to change it.';
                    }
                    if ($userUpdate['password'] != $this->user['password']) {
                        $errors[] = 'Actual password is not correct.';
                    } else {
                        $userUpdate['password'] = $_POST['new-password'];
                    }
                } else {
                    $userUpdate['password'] = $this->user['password'];
                }

                if (!empty($errors)) {
                    return $this->twig->render('Setting/update_profile.html.twig', ['errors' => $errors]);
                } else {
                    $userManager->update($userUpdate);
                    $success = "Your profile has been update with success !";
                    $userUpdate['email'] = $this->user['email'];
                    return $this->twig->render('Setting/show_profile.html.twig', array(
                        'success' => $success,
                        'user' => $userUpdate));
                }
            }
        }
        return $this->twig->render('Setting/update_profile.html.twig');
    }
}
