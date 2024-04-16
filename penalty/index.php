<?php
require_once __DIR__ . '/../config/db.php';
require_once 'config/functions.php';

// Filter logic
$where = '1=1'; // Default condition

// Check if the status filter is set
if (isset($_GET['status']) && !empty($_GET['status'])) {
    $status = $_GET['status'];
    if ($status === 'paid'){
        $where .= " AND status = 'paid'";
    }elseif ($status === 'not paid'){
        $where .= " AND status = 'not paid'";
    }
}

// Check if the date filter is set
if (isset($_GET['date']) && !empty($_GET['date'])) {
    $date = $_GET['date'];
    $where .= " AND expiry_date = '$date'";
}

// Build the SQL query with the filter conditions
$query = "SELECT * FROM penalty  WHERE $where";
$result = mysqli_query($con, $query);

// Check if the query was successful
if (!$result) {
    die("Query failed: " . mysqli_error($con));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <title>Penalty Section</title>
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
        .custom-btn {
            width: 70px; /* Adjust the width as desired */
            height: 33px; /* Adjust the height as desired */
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
        .filter-container{
            display: flex;
            align-items: center;
            gap: 10px; 
        }
        .filter-container select{
            appearance: none; /* Remove default select appearance */
            -webkit-appearance: none; /* Remove default select appearance for WebKit browsers */
            padding: 6px 12px; /* Add padding to match the date input field */
            font-size: 14px; /* Adjust the font size as needed */
            line-height: 1.5; /* Adjust the line height as needed */
            border: 1px solid #ced4da; /* Add a border to match the date input field */
            border-radius: 4px; /* Add border radius to match the date input field */
            background-color: #fff; /* Set the background color to match the date input field */
            background-image: url('data:image/svg+xml;charset=UTF-8,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2212%22%20height%3D%2212%22%20viewBox%3D%220%200%2012%2012%22%3E%3Cpath%20fill%3D%22%23333%22%20d%3D%22M6%209l4-5H2z%22%2F%3E%3C%2Fsvg%3E'); /* Add a custom arrow icon */
            background-repeat: no-repeat;
            background-position: right 8px center;
            background-size: 12px 12px;
        }
        .filter-container > div {
            margin-bottom: 0;
        }
        .filter-form-container{
            display: flex;
            justify-content: flex-end;
        }
        .col-md-5 h4{
            font-weight: bold;
        }
    </style>
    <script>
        $("#searchButton").click(function(e) {
            if ($("#searchInput").val() === "") {
                e.preventDefault();
            }
        });

        // Check if the action=delete parameter is present in the URL.
        // If so, it retrieves the id value and performs the deletion using a DELETE query.
        <?php
        if (isset($_GET['action']) && $_GET['action'] == 'delete') {
            $id = $_GET['id'];

            $query = "DELETE FROM penalty WHERE id = ?";
            $stmt = $con->prepare($query);
            $stmt->bind_param("i", $id);

            if ($stmt->execute()) {
                $success = "Record deleted successfully!";
            } else {
                $error = "Error deleting record: " . $stmt->error;
            }

            $stmt->close();
        }
        ?>
    </script>
</head>
<body class="bg-dark">
<div class="sidenav">
    <?php include '../navigation/navigation.php'; // This file will contain the navigation pane ?>
</div>

<div class="main">
    <div class="container">
        <div class="row mt-5 justify-content-center">
            <div class="col">
                <div class="card mt-5">
                    <div class="card-header bg-primary text-white">
                        <h2 class="display-6 text-center">Penalty List</h2>
                    </div>
                    <br>
                    <br>
                    <div class="col-md-5"> 
                        <h4>Penalty List </h4>
                    </div>
                    <div class="filter-form-container">
                        <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="GET">
                            <div class="filter-container">
                                <div class="col-md-5">
                                    <input type="date" class="form-control" value="<?php echo isset($_GET['date']) ? $_GET['date'] : ''; ?> ">
                                </div>
                                <div class="col-mt">
                                <select name="status" class="form-select"  >
                                <option value="">Select status</option>
                                <option 
                                value="paid" <?php echo isset($_GET['status']) && $_GET['status'] == 'paid' ? 'selected' : '';?>>Paid</option>
                                <option 
                                value="not paid" <?php echo isset($_GET['status'])  && $_GET['status'] == 'not paid' ? 'selected' : '';?>>Not Paid</option>
                            </select>
                                </div>
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-primary">Filter</button>
                                    <a href="<?php echo $_SERVER['PHP_SELF'];?>" class="btn btn-danger">Reset</a>
                                </div>
                            </div>
                        </form>
                    </div>
                    <br>
                    <br>
                    <div class="card-body">
                        <div class="d-flex justify-content-end mb-3">
                            <form action="search.php" method="get" class="search-container">
                                <input type="text" name="search_term" class="form-control" placeholder="Search member" required>
                                <div class="input-group-append">
                                    <button class="btn btn-primary search-btn" type="submit" id="searchButton">Search</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <p>
                    <table class="table table-bordered table-striped mx-auto">
                        <thead>
                            <tr>
                                <th>Member ID</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Gender</th>
                                <th>Phone No</th>
                                <th>Email</th>
                                <th>Book Borrowed</th>
                                <th>Amount Due (£)</th>
                                <th>Expiry Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                <tr>
                                    <td><?php echo $row['id']; ?></td>
                                    <td><?php echo $row['firstname']; ?></td>
                                    <td><?php echo $row['surname']; ?></td>
                                    <td><?php echo $row['gender']; ?></td>
                                    <td><?php echo $row['phone']; ?></td>
                                    <td><?php echo $row['email']; ?></td>
                                    <td><?php echo $row['book_borrowed']; ?></td>
                                    <td>£<?php echo number_format($row['amount_due'], 2); ?></td>
                                    <td><?php echo $row['expiry_date']; ?></td>
                                    <td><?php echo $row['status']; ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                    <div class="card-footer">
                        <a href="fine.php" class="btn btn-success">Issue Fine</a>
                        <?php
                        $showReturnButton = false;
                        mysqli_data_seek($result, 0); // Reset the result pointer
                        while ($row = mysqli_fetch_assoc($result)) {
                            if ($row['status'] == 'fine') {
                                $showReturnButton = true;
                                break;
                            }
                        }
                        if ($showReturnButton) {
                            echo '<a href="return_book.php" class="btn btn-warning custom-btn">Return</a>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    <?php
    if (isset($_GET['action']) && $_GET['action'] == 'return') {
        $id = $_GET["id"];

        $query = "UPDATE FROM issuedbooks WHERE id = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            $success = true;
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }
    ?>
    <!-- Alert/confirmation pop up message for the delete function  -->
        <?php if (isset($success)): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php endif; ?>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
</body>
</html>
