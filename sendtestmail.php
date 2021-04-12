<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'mailer/Exception.php';
require 'mailer/PHPMailer.php';
require 'mailer/SMTP.php';

$mail = new PHPMailer();

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
 $mail->setFrom('from@example.com', 'Mailer');
 $mail->addAddress('sonrheydeiparine2@gmail.com');      
 $mail->addCC('cc@example.com');
 $mail->addBCC('bcc@example.com');
 
// Content
$mail->isHTML(true);                                  // Set email format to HTML
$mail->Subject = 'Here is the subject';
$mail->Body    = 'This is the HTML message body <b>in bold!</b>';
$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

$mail->send();