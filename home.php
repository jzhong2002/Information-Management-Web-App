<?php
$title = 'Stockwell Digital Library';
ob_start();
$output = ob_get_clean();
include 'templates/home.html.php';
