<?php
try{
    include 'includes/DatabaseConnection.php';
    include 'includes/DatabaseFunctions.php';

    $jokes = allJokes($pdo);
    $title = 'Joke List';
    $totalJokes = totalJokes($pdo);

    ob_start();
    include 'templates/jokes.html.php';
    $output = ob_get_clean();
}catch (PDOException $e){
    $title = 'An error as occured';
    $output = 'Database error:' . $e->getMessage(); 
}
include 'templates/layout.html.php';
