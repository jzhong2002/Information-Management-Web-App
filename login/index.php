<?php 

session_start(); 
$_SESSION['is_online'] = true;

?>
<?php
function authenticateUser($username, $password)
{
    global $con; // Access the $con variable from the global scope

    $query = "SELECT * FROM users WHERE username = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $user['password'])) {
            // Authentication successful
            return $user;
        }
    }

    return false; // Authentication failed
}
?>
<?php
if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $user = authenticateUser($username, $password);

    if ($user) {
        // User authentication successful
        session_start();
        $_SESSION['username'] = $user['username'] . ' ' . $user['username'];
        $_SESSION['is_online'] = true;

        // Redirect to the admin panel or desired page
        header("Location: index.php");
        exit();
    } else {
        // Authentication failed
        $error = "Invalid username or password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<link rel="stylesheet" type="text/css" href="css/bootstrap.css"/>
		<style>
			.link-container{
				display: flex;
				justify-content: space-between;
				align-items: center;
				margin-top: 10px;
			}
			.back-link {
				margin-right: 330px;
			}
		</style>
		<meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1"/>
	</head>
<body>
	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<a class="navbar-brand" href="https://sourcecodester.com">Sourcecodester</a>
		</div>
	</nav>
	<div class="col-md-3"></div>
	<div class="col-md-6 well">
		<h3 class="text-primary">Admin Area Login</h3>
		<h2 class="text-secondary">Username = username stored in the users table</h2>
		<h2 class="text-secondary">Password = password stored in the users table</h2>
		<hr style="border-top:1px dotted #ccc;"/>
		<div class="col-md-2"></div>
		<div class="col-md-8">
			<?php if(isset($_SESSION['message'])): ?>
				<div class="alert alert-<?php echo $_SESSION['message']['alert'] ?> msg"><?php echo $_SESSION['message']['text'] ?></div>
			<script>
				(function() {
					// removing the message 3 seconds after the page load
					setTimeout(function(){
						document.querySelector('.msg').remove();
					},3000)
				})();
			</script>

			<?php 
				endif;
				// clearing the message
				unset($_SESSION['message']);
			?>
			<form action="login_query.php" method="POST">	
				<h4 class="text-success">Login here...</h4>
				<hr style="border-top:1px groovy #000;">
				<div class="form-group">
					<label>Username</label>
					<input type="text" class="form-control" name="username" />
				</div>
				<div class="form-group">
					<label>Password</label>
					<input type="password" class="form-control" name="password" />
				</div>
				<br />
				<div class="form-group">
					<button class="btn btn-primary form-control" name="login">Login</button>
				</div>
				<div class="form-group">
				</div>
				<div class="link-container">
				<a href="registration.php">Registration</a>
				<a href="../home.php" class="back-link" name="back">Back</a>
			</div>
			</form>
		</div>
	</div>
</body>
</html>