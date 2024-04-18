<?php
session_start();
require_once 'conn.php';

if (ISSET($_POST['register'])) {
    if ($_POST['firstname'] != "" && $_POST['surname'] != "" && $_POST['gender'] != "" && $_POST['date_of_birth'] != "" && $_POST['username'] != "" && $_POST['password'] != "" && $_POST['job_role'] != "") {
        try {
            $firstname = $_POST['firstname'];
            $surname = $_POST['surname'];
            $gender = $_POST['gender'];
            $date_of_birth = $_POST['date_of_birth'];
            $username = $_POST['username'];
            $password = $_POST['password'];
            $job_role = $_POST['job_role'];

            // md5 encrypted
            // $password = md5($_POST['password']);

            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO `users` (firstname, surname, gender, date_of_birth, username, `password`, job_role) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$firstname, $surname, $gender, $date_of_birth, $username, $password, $job_role]);

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