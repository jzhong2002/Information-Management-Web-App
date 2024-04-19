<?php
session_start();
require_once 'conn.php';

if (ISSET($_POST['register'])) {
    if (!empty($_POST['title']) && $_POST['title'] != "Select" && !empty($_POST['firstname']) && !empty($_POST['surname']) && !empty($_POST['gender']) && $_POST['gender'] != "Select" && !empty($_POST['date_of_birth']) && !empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['job_role'])) {
        try {
            $title = ucfirst(strtolower($_POST['title']));
            $firstname = ucfirst(strtolower($_POST['firstname']));
            $surname = ucfirst(strtolower($_POST['surname']));
            $gender = ucfirst(strtolower($_POST['gender']));
            $date_of_birth = $_POST['date_of_birth'];
            $username = $_POST['username'];
            $password = $_POST['password'];
            $job_role = ucfirst(strtolower($_POST['job_role']));

            // md5 encrypted
            // $password = md5($_POST['password']);

            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO `users` (title, firstname, surname, gender, date_of_birth, username, `password`, job_role) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$title, $firstname, $surname, $gender, $date_of_birth, $username, $password, $job_role]);

            $_SESSION['message'] = array("text" => "User successfully created.", "alert" => "info");
            $conn = null;
            header('location: index.php');
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    } else {
        echo "<script>alert('Please fill up the required field!')</script>";
        echo "<script>window.location = 'registration.php'</script>";
    }
}
?>