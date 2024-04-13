<?php

$con = mysqli_connect("localhost", "root", "", "book");
if(!$con)
{
    die("Connection failed: " . mysqli_connect_error());
}
?>
