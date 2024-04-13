<?php
$message = $_REQUEST['message'] ;
ini_set("SMTP", "jz1290t@gre.ac.uk");
ini_set("sendmail_from", "jz1290t@gre.ac.uk") ;
mail ("jz1290t@gre.ac.uk", "the subject - testing email connection", $message) ;
echo "Email Connection works well!" ;
?>