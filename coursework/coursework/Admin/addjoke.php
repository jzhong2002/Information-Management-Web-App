<?php
if(isset($_POST['joketext'])){
try{
    include '../includes/DatabaseConnection.php';
    include '../includes/DatabaseFunctions.php';

    $sql ='INSERT INTO joke SET
    joketext = :joketext,
    jokedate = CURDATE(),
    authorid = :authorid,
    categoryid = :categoryid';
    //$stmt = $pdo->prepare($sql);
    //$stmt->bindvalue(':joketext', $_POST['joketext']);
    //$stmt->bindvalue(':authorid', $_POST['authors']);
    //$stmt->bindvalue(':categoryid', $_POST['categories']);
    //$stmt->execute();
    insertJoke($pdo, $_POST['joketext'], $_POST['authors'], $_POST['categories']);
    header('location: jokes.php');
}catch (PDOException $e){
    $title = 'An error has occured';
    $output = 'Database error: ' . $e->getMessage();
   
}
}else{
    include '../includes/DatabaseConnection.php';
    include '../includes/DatabaseFunctions.php';

    $title = 'Add a new joke';
    $authors =allAuthors($pdo);
    $categories = allCategories($pdo);
    ob_start();
    include '../admintemplates/addjoke.html.php';
    $output = ob_get_clean();
}

include '../templates/admin.layout.html.php';