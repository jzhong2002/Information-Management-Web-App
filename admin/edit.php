<?php
require_once __DIR__ . '/../config/db.php';
require_once 'config/functions.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $users_id = $_POST["id"];
    $firstname = $_POST["firstname"];
    $surname = $_POST["surname"];
    $gender = $_POST["gender"];
    $date_of_birth = $_POST["date_of_birth"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $job_role = $_POST["job_role"];
    $status = $_POST["status"];

    $query = "UPDATE users SET firstname = ?, surname = ?, gender = ?, date_of_birth = ?, username = ?, password = ?, job_role = ?, status = ? WHERE id = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("ssssssssi", $firstname, $surname, $gender, $date_of_birth, $username, $password, $job_role, $status, $users_id);

    if ($stmt->execute()) {
        $success = true;
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
} else {
    $id = $_GET["id"];
    $query = "SELECT * FROM users WHERE id = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $users = $result->fetch_assoc();
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
    <title>Edit Records</title>
    <script>
    <?php if (isset($success) && $success === true): ?>
        window.onload = function() {
            alert("Staff details updated successfully!");
            window.location.href = "index.php";
        }
    <?php endif; ?>
</script>
<script>
    function goBack() {
        window.history.back();
    }

    <?php if (isset($success) && $success === true): ?>
        window.onload = function() {
            window.location.href = "index.php";
        }
    <?php endif; ?>
</script>
</head>
<body class="bg-dark">
    <div class="container">
        <div class="row mt-5">
            <div class="col">
                <div class="card mt-5">
                    <div class="card-header bg-primary text-white">
                        <h2 class="display-6 text-center">Edit Record</h2>
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
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                            <input type="hidden" name="id" value="<?php echo $users['id']; ?>">
                            <div class="form-group">
                                <label for="name">Firstname</label>
                                <input type="text" class="form-control" id="firstname" name="firstname" value="<?php echo $users['firstname']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="surname">Surname</label>
                                <input type="text" class="form-control" id="surname" name="surname" value="<?php echo $users['surname']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="gender">Gender</label>
                                <input type="text" class="form-control" id="gender" name="gender" value="<?php echo $users['gender']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="price">Date of Birth</label>
                                <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" value="<?php echo $users['date_of_birth']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" id="username" name="username" value="<?php echo $users['username']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="text" class="form-control" id="password" name="password" value="<?php echo $users['password']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="job_role">Job Role</label>
                                <input type="text" class="form-control" id="job_role" name="job_role" value="<?php echo $users['job_role']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select class="form-control" id="status" name="status" required>
                                    <option value="pending" <?php if ($users['status'] == 'pending') echo 'selected'; ?>>Pending</option>
                                    <option value="authorised" <?php if ($users['status'] == 'authorised') echo 'selected'; ?>>Authorised</option>
                                    <option value="unauthorised" <?php if ($users['status'] == 'unauthorised') echo 'selected'; ?>>Unauthorised</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-success">Update Record</button>
                            <button type="return" class="btn btn-danger" onclick="goBack()">Cancel</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>