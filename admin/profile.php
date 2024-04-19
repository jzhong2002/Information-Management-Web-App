<?php
session_start();
require_once __DIR__ . '/../config/db.php';
require_once 'config/functions.php';

if(!isset($_SESSION['user_id']) || !isset($_SESSION['is_online'])){
    echo "Session variables are not set";
    header('Location: ../login/index.php');
    exit();
}

$role = null;

$admin_id = $_SESSION['user_id'];

//Fetch the admin details
$query = "SELECT * FROM users WHERE id = ?";
$stmt = $con->prepare($query);
$stmt->bind_param('i', $admin_id); // Bind the integer parameter
$stmt->execute();
$result = $stmt->get_result(); // Get the result set from the prepared statement
$admin = $result->fetch_assoc(); // Fetch associative array directly
$stmt->close(); // Close the statement
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <title>Admin Profile</title>
    <style>
        body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f8f9fa;
}

.sidenav {
    height: 100%;
    width: 200px;
    position: fixed;
    z-index: 1;
    top: 0;
    left: 0;
    background-color: #343a40;
    overflow-x: hidden;
    padding-top: 20px;
}

.sidenav a {
    padding: 16px 8px 16px 16px;
    text-decoration: none;
    font-size: 18px;
    color: #d1d1d1;
    display: block;
    transition: 0.3s;
}

.sidenav a:hover {
    color: #f1f1f1;
    background-color: #495057;
}

.main {
    margin-left: 200px;
    padding: 20px;
}

.card {
    border: none;
    border-radius: 5px;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
}

.card-header {
    background-color: #343a40;
    color: #fff;
    border-top-left-radius: 5px;
    border-top-right-radius: 5px;
}

.card-body {
    padding: 1.5rem;
}

.search-container {
    display: flex;
    align-items: center;
    margin-bottom: 1rem;
}

.search-btn {
    margin-left: 0.5rem;
}

.table {
    background-color: #fff;
    border-radius: 5px;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
}

.table th,
.table td {
    padding: 0.75rem;
    vertical-align: middle;
}

.btn {
    font-weight: 500;
}

.btn-primary {
    background-color: #007bff;
    border-color: #007bff;
}

.btn-primary:hover {
    background-color: #0069d9;
    border-color: #0062cc;
}

.btn-danger {
    background-color: #dc3545;
    border-color: #dc3545;
}

.btn-danger:hover {
    background-color: #c82333;
    border-color: #bd2130;
}

.btn-warning {
    background-color: #ffc107;
    border-color: #ffc107;
    color: #212529;
}

.btn-warning:hover {
    background-color: #e0a800;
    border-color: #d39e00;
}

.admin-profile {
    display: flex;
    align-items: center;
    padding: 10px;
    color: #fff;
}

.admin-profile-picture {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    margin-right: 10px;
}

.admin-profile-details {
    display: flex;
    flex-direction: column;
}

.admin-name {
    font-weight: bold;
}

.admin-status::before {
    content: '';
    display: inline-block;
    width: 8px;
    height: 8px;
    border-radius: 50%;
    margin-right: 5px;
    vertical-align: middle;
}

.admin-status.online::before {
    background-color: #28a745;
}

.admin-status.offline::before {
    background-color: #dc3545;
}

    </style>
</head>
<body class="bg-dark">
    <div class="container">
        <div class="row mt-5">
            <div class="col">
                <div class="card mt-5">
                    <div class="card-header bg-primary text-white">
                        <h2 class="display-6 text-center">Admin Profile</h2>
                    </div>
                    <div class="card-body">
                        <?php if (isset($success) && $success === true): ?>
                            <div class="alert alert-success" role="alert">
                                Profile details updated successfully!
                            </div>
                        <?php elseif (isset($error)): ?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo $error; ?>
                            </div>
                        <?php endif; ?>
                        <div class="text-center mb-3">
                            <img src="Basic_Ui__28186_29.jpg" alt="Profile Picture" class="rounded-circle" style="width: 150px; height: 150px;">
                            <br>
                            <a href="change_profile_picture.php" class="btn btn-primary mt-2">Change Profile Picture</a>
                        </div>
                        <div class="main">
                        <div class="container card-container">
                            <div class="row justify-content-center">
                                <div class="col">
                                    <div class="card mt-5">
                        <h5>Title: <?php echo isset($admin['title']) ? $admin['title'] : ''; ?></h5>
                        <h5>Firstname: <?php echo isset($admin['firstname']) ? $admin['firstname'] : ''; ?></h5>
                        <h5>Surname: <?php echo isset($admin['surname']) ? $admin['surname'] : ''; ?></h5>
                        <h5>Gender: <?php echo isset($admin['gender']) ? $admin['gender'] : ''; ?></h5>
                        <h5>Date of Birth: <?php echo isset($admin['date_of_birth']) ? $admin['date_of_birth'] : ''; ?></h5>
                        <h5>Username: <?php echo isset($admin['username']) ? $admin['username'] : ''; ?></h5>
                        <h5>Password: <?php echo isset($admin['password']) ? $admin['password'] : ''; ?></h5>   
                        <h5>Job Role: <?php echo isset($admin['job_role']) ? $admin['job_role'] : ''; ?></h5>
                        <a href="edit.php?id=<?php echo $admin['id']; ?>" class="btn btn-primary">Edit Profile</a>
                        <a href="index.php" class="btn btn-secondary">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>