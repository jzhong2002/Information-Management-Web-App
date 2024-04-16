<?php

$subject = $_POST["subject"];
$email = $_POST["email"];
$message = $_POST["message"];

require "vendor/autoload.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

$mail = new PHPMailer(true);

$mail->SMTPDebug = SMTP::DEBUG_SERVER;

$mail->isSMTP();
$mail->SMTPAuth = true;

$mail->Host = "smtp.gmail.com";
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->Port = 587;

$mail->Username = "jonathanzhong60@gmail.com";
$mail->Password = "evbbncstxspllfru";

$mail->setFrom('jonathanzhong60@gmail.com');
$mail->addAddress("jonathanzhong70@gmail.com", "Dave");

$mail->Subject = $subject;
$mail->Body = $message;

$mail->send();

echo
" 
<script> 
 alert('Message was sent successfully!');
 document.location.href = 'fine.php';
</script>
";
?>