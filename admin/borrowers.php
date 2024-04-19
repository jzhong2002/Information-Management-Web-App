<?php
session_start();
require_once __DIR__ . '/../config/db.php';
require_once 'config/functions.php';

// Check if the action=delete parameter is present in the URL.
// If so, it retrieves the id value and performs the deletion using a DELETE query.
if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    $id = $_GET['borrower_id'];
    echo "Borrower ID to be deleted: " . $id; // Debug statement

    $query = "DELETE FROM borrowers WHERE borrower_id = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $success = "Record deleted successfully!";
    } else {
        $error = "Error deleting record: " . $stmt->error;
    }

    $stmt->close();
}

if (!isset($_SESSION['user_id']) || !isset($_SESSION['is_online'])) {
    header('Location: ../login/index.php');
    exit();
}

// Get the admin name and status
$admin_id = $_SESSION['user_id'];
$admin_name = $_SESSION['username'];
$admin_status_class = $_SESSION['is_online'] ? 'online' : 'offline';

// Filter logic
$where = '1=1'; // Default condition

// Check if the status filter is set
if (isset($_GET['status']) && !empty($_GET['status'])) {
    $status = $_GET['status'];
    $where .= " AND status = ?";
    $statusParam = $status;
} else {
    $statusParam = null;
}

// Check if the date filter is set
if (isset($_GET['date']) && !empty($_GET['date'])) {
    $date = $_GET['date'];
    $where .= " AND expiry_date = ?";
    $dateParam = date_create_from_format('Y-m-d', $date); // Create a DateTime object
} else {
    $dateParam = null;
}

// Build the SQL query with the filter conditions
$query = "SELECT * FROM borrowers WHERE $where";

// Prepare the statement and bind the parameters
$stmt = $con->prepare($query);
if ($statusParam !== null && $dateParam !== null) {
    $stmt->bind_param("ss", $statusParam, $dateParam->format('Y-m-d'));
} elseif ($statusParam !== null) {
    $stmt->bind_param("s", $statusParam);
} elseif ($dateParam !== null) {
    $stmt->bind_param("s", $dateParam->format('Y-m-d'));
}
// Execute the prepared statement
$stmt->execute();

// Get the result set
$result = $stmt->get_result();

// Close the prepared statement
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <title>Admin Area</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .card-body {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
        }

        .search-container {
            display: flex;
            align-items: center;
        }

        .search-btn {
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

        .alert {
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

        .link-image {
            width: 20px; /* Adjust the width as desired */
            height: 20px; /* Adjust the height as desired */
            margin-right: 5px; /* Add some spacing between the image and text */
        }

        .filter-container {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .filter-container select {
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

        .filter-form-container {
            display: flex;
            justify-content: flex-end;
        }

        .col-md-5 h4 {
            font-weight: bold;
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
            color: #333;
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

       function confirmDelete(borrowerId) {
           if (confirm("Are you sure you want to delete this record?")) {
               window.location.href = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>?action=delete&borrower_id=" + borrowerId;
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
   <?php include '../navigation/adminnavigation.php'; // This file will contain the navigation pane ?>
</div>

<div class="main">
       <div class="container">
           <div class="row mt-5 justify-content-center">
               <div class="col">
                   <div class="card mt-5">
                       <div class="card-header bg-primary text-white">
                           <h2 class="display-6 text-center">Member Records</h2>
                       </div>
                       <div class="card-body">
                           <div class="d-flex justify-content-end mb-3">
                           <form action="searchmember.php" method="get" class="search-container">
                                   <input type="text" name="search_term" class="form-control" placeholder="Search Member" required>
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
                                       <th>ID</th>
                                       <th>Title</th>
                                       <th>Firstname</th>
                                       <th>Surname</th>
                                       <th>Gender</th>
                                       <th>Phone No</th>
                                       <th>Email</th>
                                       <th>Date of Birth</th>
                                       <th>Address</th>
                                   </tr>
                               </thead>
                               <tbody>
                                   <?php while ($row = $result->fetch_assoc()): ?>
                                       <tr>
                                           <td><?php echo $row['borrower_id']; ?></td>
                                           <td><?php echo $row['title']; ?></td>
                                           <td><?php echo $row['firstname']; ?></td>
                                           <td><?php echo $row['surname']; ?></td>
                                           <td><?php echo $row['gender']; ?></td>
                                           <td><?php echo $row['phone']; ?></td>
                                           <td><?php echo $row['email']; ?></td>
                                           <td><?php echo $row['date_of_birth']; ?></td>
                                           <td><?php echo $row['address']; ?></td>
                                           <td>
                                               <a href="editborrowers.php?id=<?php echo $row['borrower_id']; ?>" class="btn btn-warning">Edit</a>
                                               <button class="btn btn-danger" onclick="confirmDelete(<?php echo $row['borrower_id']; ?>)">Delete</button>
                                           </td>
                                       </tr>
                                   <?php endwhile; ?>
                               </tbody>
                           </table>
                       </div>
                       <div class="card-footer">
                           <a href="addborrowers.php" class="btn btn-success">Add New Member</a>
                       </div>
                   </div>
               </div>
           </div>
       </div>
   </div>

   <script>
       <?php if (isset($success) && $success === true): ?>
           alert("Record deleted successfully!");
           window.location.href = "index.php";
       <?php endif; ?>
   </script>
</body>
</html>