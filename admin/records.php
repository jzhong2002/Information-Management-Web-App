<?php
session_start();
require_once __DIR__ . '/../config/db.php';
require_once 'config/functions.php';

$_SESSION['is_online'] = true;

$admin_name = isset($_SESSION['admin_name']) ? $_SESSION['admin_name'] : 'Admin';
$admin_status_class = isset($_SESSION['is_online']) && $_SESSION['is_online'] ? 'online' : 'offline';

$result = display_data();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <title>Book Records</title>
	<style>
		body {
			font-family: Arial, sans-serif;
			margin: 0;
			padding: 0;
		}

        .card-body{
            display: flex;
            flex-direction: column;
            align-items: flex-end;
        }

        .search-container {
            display: flex;
            align-items: center;
        }

        .search-btn{
            margin-left: 8px;
        }

		.sidenav {
			height: 100%;
			width: 200px;
			position: fixed;
			z-index: 1;
			top: 0;
			left: 0;
			background-color: #FAF0DC;
			overflow-x: hidden;
			padding-top: 20px;
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
        .alert{ 
            display: none;
            background-color: red;
        }
        .image-link {
            display: inline-flex;
            align-items: center;
            text-decoration: none; /* Remove underline from link */
        }
        .link-image{
            width: 20px; /* Adjust the width as desired */
            height: 20px; /* Adjust the height as desired */
            margin-right: 5px; /* Add some spacing between the image and text */
        }
        .admin-profile {
            display: flex;
            align-items: center;
            padding: 10px;
        }

        .admin-profile-picture {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .admin-profile-details {
            display: flex;
            flex-direction: column;
            color:#333;
        }

        .admin-name {
            font-weight: bold;
        }

        .admin-status::before {
            content: '';
            display: inline-block;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            margin-right: 5px;
            vertical-align: middle;
        }

        .admin-status.online::before {
            background-color: lightgreen;
        }

        .admin-status.offline::before {
            background-color: red;
        }
	</style>
    <script>
    $("#searchButton").click(function(e) {
        if ($("#searchInput").val() === "") {
            e.preventDefault();
        }
    });
        function confirmDelete(bookId) {
            if (confirm("Are you sure you want to delete this book?")) {
                window.location.href = "index.php?action=delete&book_id=" + bookId;
            }
        }
    </script>
</head>
<body class="bg-dark">
<div class="sidenav">
    <a href="profile.php">
    <div class = "admin-profile">
        <img src="Basic_Ui__28186_29.jpg" alt="Admin Profile Picture" class="admin-profile-picture">
        <div class="admin-profile-details">
            <span class="admin-name"><?php echo $admin_name; ?></span>
            <span class="admin-status <?php echo $admin_status_class; ?>"><?php echo ($admin_status_class); ?></span>
        </div>
    </div>
    </a>
        <a href="index.php" class="image-link"><img src="../img/group.png" class="link-image"> Manage Staff</a>
		<a href="../home.php">🖥️ Staff Panel</a>
		<a href="../login/logout.php">🏃 Log Out</a>
	</div>

    <div class="main">
        <div class="container">
            <div class="row mt-5 justify-content-center">
                <div class="col">
                    <div class="card mt-5">
                        <div class="card-header bg-primary text-white">
                            <h2 class="display-6 text-center">Book Records</h2>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-end mb-3">
                            <form action="search.php" method="get" class="search-container">
                                    <input type="text" name="search_term" class="form-control" placeholder="Search book" required>
                                    <div class="input-group-append">
                                        <button class="btn btn-primary search-btn" type="submit" id="searchButton">Search</button>
                                    </div>
                                    </form>
                                </div>
                            </div>

                            <table class="table table-bordered table-striped mx-auto">
                                <p></p>
                                <p></p>
                                <p></p>
                                <thead>
                                    <tr>
                                        <th>Book ID</th>
                                        <th>Book Name</th>
                                        <th>Author</th>
                                        <th>Genre</th>
                                        <th>Price (£)</th>
                                        <th>Stock</th>
                                        <th>Publish Date</th>
                                        <th>Location</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                        <tr>
                                            <td><?php echo $row['book_id']; ?></td>
                                            <td><?php echo $row['name']; ?></td>
                                            <td><?php echo $row['author']; ?></td>
                                            <td><?php echo $row['genre']; ?></td>
                                            <td>£<?php echo number_format($row['price'], 2); ?></td>
                                            <td><?php echo $row['stock']; ?></td>
                                            <td><?php echo $row['publish_date']; ?></td>
                                            <td><?php echo $row['location']; ?></td>
                                            <td>
                                                <a href="edit.php?book_id=<?php echo $row['book_id']; ?>" class="btn btn-warning">Edit</a>
                                                <button class="btn btn-danger" onclick="confirmDelete(<?php echo $row['book_id']; ?>)">Delete</button>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer">
                            <a href="add.php" class="btn btn-primary">Add New Book</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
    if (isset($_GET['action']) && $_GET['action'] == 'delete') {
        $book_id = $_GET["book_id"];

        $query = "DELETE FROM records WHERE book_id = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param("i", $book_id);

        if ($stmt->execute()) {
            $success = true;
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }
    ?>

    <script>
        <?php if (isset($success) && $success === true): ?>
            alert("Book deleted successfully!");
            window.location.href = "index.php";
        <?php endif; ?>
    </script>
</body>
</html>
