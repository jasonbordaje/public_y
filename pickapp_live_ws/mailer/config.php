<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'Exception.php';
require 'PHPMailer.php';
require 'SMTP.php';

function sendMail($to, $subject, $message, $imgsig, $imghead){
    $mail = new PHPMailer();
    try{
            // Settings
    $mail->IsSMTP();
    $mail->CharSet = 'UTF-8';

    $mail->Host       = "mail1.gothong.com"; // SMTP server example
    $mail->SMTPDebug  = 0;                     // enables SMTP debug information (for testing)
    $mail->SMTPAuth   = true;                  // enable SMTP authentication
    $mail->Port       = 587;                    // set the SMTP port for the GMAIL server
    $mail->Username   = "noreply"; // SMTP account username example
    $mail->Password   = "GSn0reply1478";        // SMTP account password example

    //Recipients
    $mail->setFrom('bstsupport@gothong.com', 'Yello-X Delivery Report');
    $mail->addAddress($to);      
    // $mail->addCC('sonrheydeiparine2@gmail.com');
    
    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = $subject;
    $mail->AddEmbeddedImage($imgsig, 'signature');
    $mail->AddEmbeddedImage($imghead, 'drheader');
    $mail->Body = $message;

    $mail->send();

    echo "sdsd";
    }catch (phpmailerException $e) {
        echo $e->errorMessage(); //Pretty error messages from PHPMailer
      } catch (Exception $e) {
        echo $e->getMessage(); //Boring error messages from anything else!
      }
}   