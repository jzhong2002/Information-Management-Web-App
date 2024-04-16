<?php 

require_once __DIR__ . '/../config/db.php';
require_once 'config/functions.php';

if (isset($_GET['search_term'])) {
    $searchTerm = $_GET['search_term'];

    $query = "SELECT * FROM issuedbooks WHERE firstname LIKE ?";
    $stmt = $con->prepare($query);
    $searchTerm = "%$searchTerm%"; // Fixed variable name from searchTerm to $searchTerm
    $stmt->bind_param("s", $searchTerm); // Fixed variable name from $search_term to $searchTerm
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) { // Check if no matching records found
        $error = "No matching records found.";
    }
} else {
    $result = display_data();
}
?>

<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <title>Member Records</title>
    <style>
        .card-body {
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
        .custom-btn {
            width: 70px; /* Adjust the width as desired */
            height: 33px; /* Adjust the height as desired */
        }
    </style>
    <script>
    $(document).ready(function() { // Added document.ready function
        $("#searchButton").click(function(e) {
            if ($("#searchInput").val() === "") {
                e.preventDefault();
                alert("Please enter a search term.");
            }
        });
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
                                <div class="search-container">
                                    <form action="searchmember.php" method="get" class="search-container">
                                    <input type="text" name="search_term" class="form-control" placeholder="Search member name" id="searchInput"> <!-- Added id="searchInput" -->
                                    <div class="input-group-append">
                                        <button class="btn btn-primary search-btn" type="submit" id="searchButton">Search</button>
                                    </div>
                                </div>
                            </div>
                            <table class="table table-bordered table-striped mx-auto mt-3">
                                <p></p>
                                <thead>
                                    <tr>
                                        <th>Issue ID</th>
                                        <th>Firstname</th>
                                        <th>Surname</th>
                                        <th>Phone No</th>
                                        <th>Email</th>
                                        <th>Book Name</th>
                                        <th>Expiry Date</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (isset($error)):?>
                                        <tr>
                                            <td><?php echo $error; ?></td>
                                        </tr>
                                    <?php else: ?>
                                    <?php while ($row = $result->fetch_assoc()): ?>
                                        <tr>
                                            <td><?php echo $row['id']; ?></td>
                                            <td><?php echo $row['firstname']; ?></td>
                                            <td><?php echo $row['surname']; ?></td>
                                            <td><?php echo $row['phone']; ?></td>
                                            <td><?php echo $row['email']; ?></td>
                                            <td><?php echo $row['book_name']; ?></td>
                                            <td><?php echo $row['expiry_date']; ?></td>
                                            <td><?php echo $row['status']; ?></td>
                                            <td>
                                                <button class="btn btn-danger" onclick="confirmDelete(<?php echo $row['id']; ?>)">Delete</button>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer">
                            <a href="issue.php" class="btn btn-success custom-btn">Issue</a>
                            <a href="return_book.php" class="btn btn-warning custom-btn">Return</a>
                            <a href="index.php" class="btn btn-primary custom-btn">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>