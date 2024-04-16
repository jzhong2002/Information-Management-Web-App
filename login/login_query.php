<?php
session_start();
require_once 'conn.php';


function authenticateUser($username, $password)
{
	echo "authenticateUser has been called.";
    global $conn; // Access the $conn variable from the global scope

    $query = "SELECT * FROM users WHERE username = :username";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
	echo "User: ";
	print_r($user);

    if ($user) {
		echo "User exists.";
        // Verify the password
        // if (password_verify($password, $user['password'])) {
        //     // Authentication successful
		// 	echo "Authentication successful.";
        //     return $user;
        // }
		if ($password == $user['password']) {
			// Authentication successful
			echo "Authentication successful.";
			return $user;
		}
    }

    return false; // Authentication failed
}

if (isset($_POST['adminLogin'])) {
	echo "Form has been submitted.";
    $username = $_POST['username'];
    $password = $_POST['password'];
	//echo username and password together as a sentence
	if (isset($_POST['username'], $_POST['password'])) {
		echo "Username and password are set.";
	} else {
		echo "Username and password are not set.";
	}
	echo "Username: " . $username . " Password: " . $password;
    $user = authenticateUser($username, $password);

    if ($user) {
        // User authentication successful
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['is_online'] = true;

        // Redirect to the admin panel or desired page
		echo "Redirecting to admin panel.";
        header("Location: ../admin/index.php");
        exit();
    } else {
        // Authentication failed
        $_SESSION['message'] = [
            'alert' => 'danger',
            'text' => 'Invalid username or password.'
        ];
    }
}
?>