<?php

namespace App\Controller;

//Import PHPMailer classes into the global namespace
use App\Controller\Service\FormController;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class ContactController extends AbstractTwigController
{
    public function sendEmail()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->user) {
                $_POST['email'] = $this->user['email'];
            } else {
                $_POST['email'] = $_POST['emailRandom'];
            }

            $contactData = array_map('trim', $_POST);
            $contactData = array_map('htmlspecialchars', $contactData);

            $formController = new FormController();
            $errors = $formController->errorContact($contactData);

            if (!empty($errors)) {
                return $this->twig->render('Home/contact.html.twig', ['errors' => $errors]);
            } else {
                $response = $this->mailer($contactData);
                return $this->twig->render('Home/contact_response.html.twig', ['response' => $response]);
            }
        }
        return $this->twig->render('Home/contact.html.twig');
    }

    public function mailer($mailpost): bool
    {
        $mail = new PHPMailer();

        $mail->isSMTP();

        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 465;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->SMTPAuth = true;

        $mail->Username = 'wildify.mailauto@gmail.com';
        $mail->Password = 'hoqcyetfovvlhtrg';

//Set who the message is to be sent from
//Note that with gmail you can only use your account address (same as `Username`)
//or predefined aliases that you have configured within your account.
//Do not use user-submitted addresses in here
        $mail->setFrom('wildify.mailauto@gmail.com', 'WILDIDY SUPPORT');

//Set an alternative reply-to address
//This is a good place to put user-submitted addresses
        $mail->addReplyTo($mailpost['email']);

//Set who the message is to be sent to
        $mail->addAddress('wildify.mailauto@gmail.com', 'WILDIDY SUPPORT');

//Set the subject line
        $mail->Subject = $mailpost['subject'];


//Replace the plain text body with one created manually
        $mail->Body = $mailpost['message'];

//send the message, check for errors
        if (!$mail->send()) {
            $sendResponse = false;
        } else {
            $sendResponse = true;
        }
        return $sendResponse;
    }
}
