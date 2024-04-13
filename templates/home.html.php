<!DOCTYPE html>
<html>
<head>
<link href="https://fonts.googleapis.com/css2?family=Noto+Emoji&display=swap" rel="stylesheet">
    <title>Library Management System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
			background-image: url('../img/_DSC6315.jpg');
			background-repeat: no-repeat;
			background-size: cover;
        }

        .sidenav {
            height: 100%;
            width: 0px; /* Intially hide the navigation bar*/
            position: fixed;
            z-index: 1;
            top: 0;
            left: 0;
            background-color: #FAF0DC;
            overflow-x: hidden;
            padding-top: 20px;
			transition: width 0.5s;
        }

        .sidenav a {
            padding: 16px 8px 16px 16px;
            text-decoration: none;
            font-size: 18px;
            color: #818181;
            display: block;
            transition: 0.3s;
        }

        .sidenav a:hover {
            color: #f1f1f1;
            background-color: #964B00;
        }

        .main {
            margin-left: 200px;
            padding: 20px;
        }

        .image-link {
            display: inline-flex;
            align-items: center;
            text-decoration: none;
        }

        .link-image {
            width: 20px;
            height: 20px;
            margin-right: 5px;
        }

        .dashboard {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
        }

        .dashboard-card {
            background-color: #f1f1f1;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
            text-align: center;
            width: 200px;
            margin-bottom: 20px;
        }

		.dashboard-card:hover {
			transform: scale(1.05);
			background-color: #FAF0DC;
			color: #964B00;
			transition: transform 0.3s ease-in-out;
		}

        .dashboard-card h3 {
            margin-top: 0;
        }

        .dashboard-card p {
            font-size: 24px;
            font-weight: bold;
            margin: 10px 0;
        }

		.emoji {
			position: absolute;
			bottom: 5px;
			right: 10px;
			font-size: 24px;
			font-family: 'Noto Emoji', sans-serif;
		}

		.menu-icon {
			cursor: pointer;
			position: fixed;
			left: 470px;
			top: 43px;
			z-index: 2;
		}

		.menu-icon span {
			display: block;
			width: 25px;
			height: 3px;
			margin-bottom: 5px;
			position: relative;
			background: #f1f1f1;
			border-radius: 3px;
			z-index: 1;
			transform-origin: 4px 0px;
			transition: transform 0.5s cubic-bezier(0.77, 0.2, 0.05, 1.0), 
						background 0.5s cubic-bezier(0.77, 0.2, 0.05, 1.0), 
						opacity 0.55s ease;
		}

		.menu-icon.open span:nth-child(1) {
			transform: rotate(45deg) translate(-2px, -1px);
		}

		.menu-icon.open span:nth-child(2) {
			opacity: 0;
			transform: translate(15);
		}
		
		.menu-icon.open span:nth-child(3) {
			transform: rotate(-45deg) translate(-4px, 2px);
		}
		.welcome-sign {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            color: white;
            font-size: 24px;
            font-weight: bold;
            padding: 20px;
            border: 2px solid white;
        }

        .inner-rect {
            padding: 10px;
            border: 1px solid white;
        }
    </style>
</head>
<body>
<div class="menu-icon">
	<span></span>
	<span></span>
	<span></span>
</div>
<div class="sidenav">
    <a href="home.php">🏠 Home</a>
    <a href="records/index.php">📖 Book Records</a>
    <a href="issuelist/index.php" class="image-link"><img src="../img/group.png" class="link-image"> Members</a>
    <a href="../penalty/index.php">💵 Penalty List</a>
    <a href="../login/index.php">🖥️ Admin Panel</a>
    <a href="../login/logout.php">🏃 Log Out</a>
    <a href="contact.php">📬 Contact Us</a>
</div>

<div class="main">
	<h2 style="color:#FAF0DC">Dashboard Overview</h2>
	<br>
	<div class="welcome-sign">
		<div class="inner-rect">Welcome to the Digital Library System!<br>[Stockwell Street Library]<br></div>

	</div>
    <div class="dashboard">
        <?php
        // Database connection
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "book";

        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Fetching data from the database
        $total_books_query = "SELECT COUNT(*) AS total_books FROM records";
        $total_employees_query = "SELECT COUNT(*) AS total_staff FROM users";
		$issued_books_query = "SELECT COUNT(*) AS issued_books FROM issuedbooks WHERE status = 'issued'";
		$returned_books_query = "SELECT COUNT(*) AS returned_books FROM issuedbooks WHERE status = 'returned'";

        $total_books_result = $conn->query($total_books_query);
        $total_employees_result = $conn->query($total_employees_query);
        $issued_books_result = $conn->query($issued_books_query);
        $returned_books_result = $conn->query($returned_books_query);

        // Displaying data
        if ($total_books_result && $total_employees_result && $issued_books_result && $returned_books_result) {
            $total_books_row = $total_books_result->fetch_assoc();
            $total_employees_row = $total_employees_result->fetch_assoc();
            $issued_books_row = $issued_books_result->fetch_assoc();
            $returned_books_row = $returned_books_result->fetch_assoc();
            ?>

            <div class="dashboard-card">
                <h3>Total Books</h3>
                <p><?php echo $total_books_row['total_books']; ?></p>
				<span class="emoji">📚</span>
            </div>

            <div class="dashboard-card">
                <h3>Total Staff</h3>
                <p><?php echo $total_employees_row['total_staff']; ?></p>
				<span class="emoji">👩‍💼</span>
            </div>

            <div class="dashboard-card">
                <h3>Total Issued Books</h3>
                <p><?php echo $issued_books_row['issued_books']; ?></p>
				<span class="emoji">📖</span>
            </div>

            <div class="dashboard-card">
                <h3>Total Returned Books</h3>
                <p><?php echo $returned_books_row['returned_books']; ?></p>
				<span class="emoji">🔙</span>
            </div>

            <?php
        } else {
            echo "Error fetching data";
        }

        $conn->close();
        ?>
    </div>
</div>
<scrip>
<script>
    const menuIcon = document.querySelector('.menu-icon');
    const sideNav = document.querySelector('.sidenav');

    menuIcon.addEventListener('click', () => {
        menuIcon.classList.toggle('open');
        sideNav.style.width = sideNav.style.width === '200px' ? '0' : '200px';
    });
</script>
</scrip>
</body>
</html>