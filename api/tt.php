<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once "../vendor/autoload.php";

//PHPMailer Object
$mail = new PHPMailer(true); //Argument true in constructor enables exceptions

$mail->IsSMTP();
$mail->Host = "smtp.gmail.com";
$mail->Port=587;

// optional
// used only when SMTP requires authentication  
$mail->SMTPAuth = true;
$mail->SMTPSecure = "tls";



$mail->Username = '';
$mail->Password = '';

//From email address and name
$mail->From = "jabaek92@gmail.com";
$mail->FromName = "MoniWeb";

//To address and name
$mail->addAddress("jabaek92@naver.com", "Customer");
//$mail->addAddress("recepient1@example.com"); //Recipient name is optional

//Address to which recipient will reply
$mail->addReplyTo("admin@moniweb.com.au", "Reply");

//CC and BCC
//$mail->addCC("cc@example.com");
//$mail->addBCC("bcc@example.com");

//Send HTML or Plain Text email
$mail->isHTML(true);

$mail->Subject = "This is title";
//$mail->Body = "<i>Mail body in HTML</i>";
$mail->Body = "Hello World This is an email from MoniWeb "; 
$mail->AltBody = "This is the plain text version of the email content";

try {
    $mail->send();
    echo "Message has been sent successfully";
} catch (Exception $e) {
    echo "Mailer Error: " . $mail->ErrorInfo;
}