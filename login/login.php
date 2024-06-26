<?php
session_start();
require_once 'conn.php';

function authenticateUser($username, $password, $job_role) {
    global $conn;
    $query = "SELECT * FROM users WHERE username = :username";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        if ($password == $user['password'] && $job_role == $user['job_role'] && $user['status'] == 'Authorised') {
            return $user;
        }
    }
    return false;
}

if (isset($_POST['staffLogin'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
	$job_role = $_POST['job_role'];

    $user = authenticateUser($username, $password, $job_role);
    if ($user) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['job_role'] = $user['job_role'];
        $_SESSION['is_online'] = true;

        header("Location: ../home.php");
        exit();
    } else {
        $_SESSION['message'] = [
            'alert' => 'danger',
            'text' => 'Invalid credentials or you have not yet been authorised. Contact the administrator'
        ];
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Staff Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="card-title">Staff Login</h4>
                    </div>
                    <div class="card-body">
                        <?php if (isset($_SESSION['message'])): ?>
                            <div class="alert alert-<?php echo $_SESSION['message']['alert']; ?>">
                                <?php echo $_SESSION['message']['text']; ?>
                            </div>
                            <?php unset($_SESSION['message']); ?>
                        <?php endif; ?>

                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
							<!-- automatically pass job role as staff-->
							<input type="hidden" name="job_role" value="Staff">
                            <button type="submit" class="btn btn-primary" name="staffLogin">Login</button>
                            <a href="../digitallibrary.php">Main Panel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>