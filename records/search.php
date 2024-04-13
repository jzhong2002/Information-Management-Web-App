<?php 

require_once 'config/db.php';
require_once 'config/functions.php';

$search_term = isset($_GET['search_term']) ? '%' . $_GET['search_term'] . '%' : '';

$query = "SELECT * FROM records WHERE name LIKE ?";
$stmt = $con->prepare($query);
$stmt->bind_param("s", $search_term);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <title>Book Records</title>
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
                            <h2 class="display-6 text-center">Book Records</h2>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-end mb-3">
                                <div class="search-container">
                                    <input type="text" name="search_term" class="form-control" placeholder="Search book name">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary search-btn" type="submit" id="searchButton">Search</button>
                                    </div>
                                </div>
                            </div>
                            <table class="table table-bordered table-striped mx-auto mt-3">
                                <p></p>
                                <thead>
                                    <tr>
                                        <th>Book ID</th>
                                        <th>Book Name</th>
                                        <th>Author</th>
                                        <th>Genre</th>
                                        <th>Price</th>
                                        <th>Stock</th>
                                        <th>Publish Date</th>
                                        <th>Location</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = $result->fetch_assoc()): ?>
                                        <tr>
                                            <td><?php echo $row['book_id']; ?></td>
                                            <td><?php echo $row['name']; ?></td>
                                            <td><?php echo $row['author']; ?></td>
                                            <td><?php echo $row['genre']; ?></td>
                                            <td><?php echo $row['price']; ?></td>
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
                            <a href="index.php" class="btn btn-primary">Go Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>