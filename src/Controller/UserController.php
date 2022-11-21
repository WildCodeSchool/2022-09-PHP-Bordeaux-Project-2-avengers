<?php

namespace App\Controller;

use App\Controller\Service\FormController;
use App\Model\UserManager;

class UserController extends AbstractTwigController
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
                $userUpdate = array_map('htmlspecialchars', $userUpdate);

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

    /**
     * Show delete page to confirm delete
     */
    public function showDeletePage()
    {
        if (!$this->user) {
            echo 'Unauthorized access';
            header('HTTP/1.1 401 Unauthorized');
        } else {
            return $this->twig->render('Setting/delete_profile.html.twig');
        }
    }

    /**
     * Delete all information for user connected
     */
    public function deleteUser(): void
    {
        if (!$this->user) {
            echo 'Unauthorized access';
            header('HTTP/1.1 401 Unauthorized');
        } else {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $id = trim($_POST['delete']);
                $userModel = new UserManager();
                $userModel->delete($id);

                header('Location: /');
            }
        }
    }

    /**
     * User registration
     */
    public function index()
    {
        $registrationManager = new UserManager();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // clean $_POST data
            $user = array_map('trim', $_POST);
            $errors = [];
            if (empty($_POST["username"])) {
                $errors[] = "Username is required";
            }
            if ((empty($_POST["email"])) || (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL))) {
                $errors[] = "A valid email is required";
            }
            if (empty($_POST["password"])) {
                $errors[] = "Password is required";
            }
        //TODO le coup de password doesn't match
            if ((empty($_POST["passwordConfirmation"])) || ($_POST["passwordConfirmation"] !== $_POST["password"])) {
                $errors[] = "Passwords doesn't match";
            }
            if (!empty($errors)) {
                return $this->twig->render('Registration/index.html.twig', ['errors' => $errors]);
            } else {
                $registrationManager->insert($user);
                header('Location: /');
            }
        }
        return $this->twig->render('Registration/index.html.twig');
    }
}
