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
        /* Add your custom styles here */
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
                            <img src="<?php echo $admin['profile_picture']; ?>" alt="Profile Picture" class="rounded-circle" style="width: 150px; height: 150px;">
                            <br>
                            <a href="change_profile_picture.php" class="btn btn-primary mt-2">Change Profile Picture</a>
                        </div>
                        <h5>Firstname: <?php echo isset($admin['firstname']) ? $admin['firstname'] : ''; ?></h5>
                        <h5>Surname: <?php echo isset($admin['surname']) ? $admin['surname'] : ''; ?></h5>
                        <h5>Gender: <?php echo isset($admin['gender']) ? $admin['gender'] : ''; ?></h5>
                        <h5>Date of Birth: <?php echo isset($admin['date_of_birth']) ? $admin['date_of_birth'] : ''; ?></h5>
                        <h5>Username: <?php echo isset($admin['username']) ? $admin['username'] : ''; ?></h5>
                        <h5>Job Role: <?php echo isset($admin['job_role']) ? $admin['job_role'] : ''; ?></h5>
                        <h5>Password: <?php echo isset($admin['password']) ? $admin['password'] : ''; ?></h5>
                        <h5>job_role: <?php echo isset($admin['job_role']) ? $admin['job_role'] : ''; ?></h5>
                        <a href="edit.php?id=<?php echo $admin['id']; ?>" class="btn btn-primary">Edit Profile</a>
                        <a href="index.php" class="btn btn-secondary">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>