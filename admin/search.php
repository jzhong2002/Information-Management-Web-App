<?php
require_once __DIR__ . '/../config/db.php';
require_once 'config/functions.php';

session_start();

$search_term = isset($_GET['search_term']) ? '%' . $_GET['search_term'] . '%' : '';

$query = "SELECT * FROM users WHERE firstname LIKE ? OR surname LIKE ?";
$stmt = $con->prepare($query);
$stmt->bind_param("ss", $search_term, $search_term);
$stmt->execute();
$result = $stmt->get_result();

// Initialize $member_found to false
$member_found = false;

// Check if any members were found
if ($result->num_rows > 0) {
    $member_found = true;
}
?>

<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <title>Staff Records</title>
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
    </style>
    <script>
        $("#searchButton").click(function(e) {
            if ($("#searchInput").val() === "") {
                e.preventDefault();
                alert("Please enter a search term.");
            }
        });
    </script>
</head>
<body class="bg-dark">
    <div class="main">
        <div class="container">
            <div class="row mt-5 justify-content-center">
                <div class="col">
                    <div class="card mt-5">
                        <div class="card-header bg-primary text-white">
                            <h2 class="display-6 text-center">Staff Records</h2>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-end mb-3">
                                <div class="search-container">
                                    <input type="text" name="search_term" class="form-control" placeholder="Search staff name">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary search-btn" type="submit" id="searchButton">Search</button>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="container">
                            <?php if (!$member_found): ?>
                                    <div class="alert alert-danger" role="alert">
                                        No members found matching the search term. Please try again!
                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php if ($member_found): ?>
                                <table class="table table-bordered table-striped mx-auto mt-3">
                                    <thead>
                                        <tr>
                                            <th>Staff ID</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Gender</th>
                                            <th>Date of Birth</th>
                                            <th>Username</th>
                                            <th>Password</th>
                                            <th>Job Role</th>
                                            <th>Authorization Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($row = $result->fetch_assoc()): ?>
                                            <tr>
                                                <td><?php echo $row['id']; ?></td>
                                                <td><?php echo $row['firstname']; ?></td>
                                                <td><?php echo $row['surname']; ?></td>
                                                <td><?php echo $row['gender']; ?></td>
                                                <td><?php echo $row['date_of_birth']; ?></td>
                                                <td><?php echo $row['username']; ?></td>
                                                <td><?php echo $row['password']; ?></td>
                                                <td><?php echo $row['job_role']; ?></td>
                                                <td><?php echo ucfirst($row['status']); ?></td>
                                            </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            <?php endif; ?>
                        </div>
                        <div class="card-footer">
                            <a href="index.php" class="btn btn-primary">Go Back</a>
                            <a href="authorise_user.php" class="btn btn-success">Authorise User</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>