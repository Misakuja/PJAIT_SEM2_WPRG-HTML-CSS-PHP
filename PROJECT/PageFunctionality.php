<?php
require_once 'PageInterface.php';

class PageFunctionality implements PageInterface {

    public function sendMail(): void {

        $name = $_POST['contactFormName'];
        $mail = $_POST['contactFormMail'];
        $phone = $_POST['contactFormPhone'];
        $message = $_POST['contactFormMessage'];

        $headers = "From: $name <$mail>\r\n <$phone>\r\n";

        $message = wordwrap($message, 70);

        mail('contact@zoo.com', 'Contact Form Message', $message, $headers);
    }
}