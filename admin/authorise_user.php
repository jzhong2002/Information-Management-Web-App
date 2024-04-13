<?php
require_once 'config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['user_id'];
    $status = $_POST['status'];

    // Check if the user ID exists in the database
    $checkQuery = "SELECT id, status FROM users WHERE id = ?";
    $stmt = $con->prepare($checkQuery);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $existingStatus = $row['status'];

        // Check if the user is already authorized
        if ($existingStatus === 'authorised') {
            $message = "The user with ID $userId is already authorised.";
        } else {
            // Update the user's status
            $capitalizedStatus =ucfirst($status);
            $updateQuery = "UPDATE users SET status = ? WHERE id = ?";
            $stmt = $con->prepare($updateQuery);
            $stmt->bind_param("si", $capitalizedStatus, $userId);

            if ($stmt->execute()) {
                $message = "User with ID $userId has been $capitalizedStatus.";
            } else {
                $message = "Error updating user status: " . $stmt->error;
            }

            $stmt->close();
        }
    } else {
        $message = "User with ID $userId not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authorise User</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 500px;
            margin: 100px auto;
            padding: 20px;
            background-color: #f8f8f8;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .alert {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Authorise User</h2>
        <?php if (isset($message)) : ?>
            <div class="alert <?php echo ($message[0] === 'E' ? 'alert-danger' : 'alert-success'); ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="form-group">
                <label for="user_id">User ID:</label>
                <input type="text" class="form-control" id="user_id" name="user_id" required>
            </div>
            <div class="form-group">
                <label for="status">Status:</label>
                <select class="form-control" id="status" name="status" required>
                    <option value="">Select Status</option>
                    <option value="pending">Pending</option>
                    <option value="authorised">Authorised</option>
                    <option value="not authorised">Not Authorised</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success">Authorise</button>
            <a href="index.php" class="btn btn-danger">Cancel</a>
        </form>
    </div>
</body>
</html>