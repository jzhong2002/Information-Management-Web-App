<?php
	$db_username = 'jz1290t';
	$db_password = 'jz1290t';
	$conn = new PDO('mysql:host=mysql.cms.gre.ac.uk; dbname=mdb_jz1290t; charset=utf8mb4', $db_username, $db_password);
	if(!$conn){
		die("Fatal Error: Connection Failed!");
	}
?>