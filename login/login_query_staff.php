<?php
	session_start();
	
	require_once 'conn.php';
	
	if(ISSET($_POST['login'])){
		if($_POST['username'] != "" && $_POST['password'] != ""){
			$username = $_POST['username'];
			$password = $_POST['password'];
			$sql = "SELECT * FROM `users` WHERE `username`=? AND `password`=? ";
			$query = $conn->prepare($sql);
			$query->execute(array($username,$password));
			$row = $query->rowCount();
			$fetch = $query->fetch();
			if($row > 0) {
				$_SESSION['users'] = $fetch['id'];
				echo "
				<script>
					alert('Logged in successfully');
					window.location.href = '../home.php';
				</script>
				";
			} else{
				echo "
				<script>
					alert('Invalid username or password');
					window.location.href = 'index.php';
				</script>
				";
			}
		}else{
			echo "
			<script>
				alert('Please complete the required field!');
				window.location.href = 'index.php';
			</script>
			";
		}
	}
?>