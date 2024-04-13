<?php
if (isset($_POST['message'])) {
    $title = "contact us" ;
    $message = $_POST['message'] ;
    /*int_set is required for the uni servers - it sepcifies which email account the message will get sent to*/
    ini_set("SMTP", "jz1290t@gre.ac.uk");
    ini_set("sendmail_from", "jz1290t@gre.ac.uk");
    mail("jz1290t@gre.ac.uk", "mail test", $message);
    $output = "Thank you for your email we will get back to you shortly";
}else{
    $title = "Contact Us";
    ob_start();
    include 'templates/mail.html.php';
    $output = ob_get_clean();
}
include 'templates/layout.html.php';