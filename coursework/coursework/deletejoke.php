<?php
try{
    include 'includes/DatabaseConnection.php';
    include 'includes/DataBaseFunctions.php';
   deleteJoke($pdo, $_POST['id']);
    header('location: jokes.php');
}catch (PDOException $e){
    $title = 'An error has ocurred';
    $output = 'Unable to connect to delete joke: ' .$e->getMessage();
}
include 'templates/layout.html.php';