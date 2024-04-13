<?php
	session_start();
	unset($_SESSION['admin_name']);
	unset($_SESSION['is_online']);
	session_destroy();
	$_SESSION['is_online'] = false;
?>

<!DOCTYPE html>
<html>
<head>
	<title>Logout</title>
	<style>
		body {
			display: flex;
			justify-content: center;
			align-items: center;
			height: 100vh;
			font-family: Arial, sans-serif;
			background-color: #f2f2f2;
		}

		.container {
			text-align: center;
			background-color: #fff;
			padding: 20px;
			border-radius: 5px;
			box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
		}

		h1 {
			color: #333;
		}

		p {
			color: #666;
		}

		button {
			padding: 10px 20px;
			background-color: #4CAF50;
			color: #fff;
			border: none;
			border-radius: 5px;
			cursor: pointer;
			transition: background-color 0.3s ease;
		}

		button:hover {
			background-color: #45a049;
		}
	</style>
</head>
<body>
	<div class="container">
		<h1>Logout Successful</h1>
		<p>You have been successfully logged out.</p>
		<button onclick="window.location.href = 'login.php';">Back to Login</button>
	</div>
</body>
</html>
