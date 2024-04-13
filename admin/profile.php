<?php
require_once 'config/db.php';
require_once 'config/functions.php';

session_start();

if (isset($SESSION['admin_id'])) {
    $admin_id = $_SESSION['admin_id'];
}

$admin_id = $_SESSION['admin_id'];

// If the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = $_POST["firstname"];
    $surname = $_POST["surname"];
    $gender = $_POST["gender"];
    $date_of_birth = $_POST["date_of_birth"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $job_role = $_POST["job_role"];

    $query = "UPDATE users SET firstname = ?, surname = ?, gender = ?, date_of_birth = ?, username = ?, password = ?, job_role = ? WHERE id = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("sssssssi", $firstname, $surname, $gender, $date_of_birth, $username, $password, $job_role, $admin_id);

    if ($stmt->execute()) {
        $success = true;
    } else {
        $error = "Error: " . $stmt->error;
    }

    $stmt->close();
} else {
    $query = "SELECT * FROM users WHERE id = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $admin_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $admin = $result->fetch_assoc();
    $stmt->close();
}
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
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                            <div class="form-group">
                                <label for="firstname">Firstname</label>
                                <input type="text" class="form-control" id="firstname" name="firstname" value="<?php echo $admin['firstname']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="surname">Surname</label>
                                <input type="text" class="form-control" id="surname" name="surname" value="<?php echo $admin['surname']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="gender">Gender</label>
                                <input type="text" class="form-control" id="gender" name="gender" value="<?php echo $admin['gender']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="date_of_birth">Date of Birth</label>
                                <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" value="<?php echo $admin['date_of_birth']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" id="username" name="username" value="<?php echo $admin['username']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="text" class="form-control" id="password" name="password" value="<?php echo $admin['password']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="job_role">Job Role</label>
                                <input type="text" class="form-control" id="job_role" name="job_role" value="<?php echo $admin['job_role']; ?>" required>
                            </div>
                            <button type="submit" class="btn btn-success">Update Profile</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>