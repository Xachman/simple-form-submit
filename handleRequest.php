<?php

require 'vendor/autoload.php';

require './config.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

use App\Form;

$form = new Form();
$form->addInput('text', 'last_name', '', array('required'), 'Last Name', '', 'Your name is required.');
$form->addInput('text', 'email', '', array('required', 'email'), 'Email', '', 'Your email is required.');
$form->addInput('text', 'phone', '', array('required', 'phone'), 'Phone', '', 'Your Phone is required.');
$form->addInput('text', 'message', '', array('required'), 'message', '', 'Your Phone is required.');

if($form->validate()) {
    $mail = new PHPMailer;
    try {
        $mail->isSMTP();                        // Set mailer to use SMTP
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;

        $mail->Host       = SMTP_HOST;    // Specify main SMTP server
        if(SMTP_USER && SMTP_PASS) {
            $mail->SMTPAuth   = true;               // Enable SMTP authentication
            $mail->Username   = SMTP_USER;     // SMTP username
            $mail->Password   = SMTP_PASS;         // SMTP password
        }
        $mail->SMTPSecure = SMTP_SECURE;              // Enable TLS encryption, 'ssl' also accepted
        $mail->Port       = SMTP_PORT;                // TCP port to connect to
        
        $mail->setFrom(SMTP_FROM, SMTP_FROM_NAME);
        $mail->addAddress(SMTP_CONTACT_ADDRESS, "");
        $mail->Subject = 'Contact Message From '.$form->get('first_name').' '.$form->get('last_name');
        $mail->msgHTML(
        '<table>'.
        '<tr><td>Name</td><td>'.$form->get('first_name').' '.$form->get('last_name').'</td></tr>'. 
        '<tr><td>Email</td><td>'.$form->get('email').'</td></tr>'. 
        '<tr><td>Phone</td><td>'.$form->get('phone').'</td></tr>'. 
        '<tr><td>Message</td><td>'.$form->get('message').'</td></tr>'. 
        '</table>');
    

        $mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test

        $mail->send();
        echo "{\"status\":\"success\"}";
        die;
    } catch(Exception $e) {
        var_dump($mail);
        echo "{\"status\":\"error\"}";
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        die;
    }
}

echo $form->displayJSONErrors();
die;