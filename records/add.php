<?php
require_once 'config/db.php';
require_once 'config/functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $author = $_POST["author"];
    $genre = $_POST["genre"];
    $price = $_POST["price"];
    $stock = $_POST["stock"];
    $publish_date = $_POST["publish_date"];
    $location = $_POST["location"];

    $query = "INSERT INTO records (name, author, genre, price, stock, publish_date, location) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $con->prepare($query);
    $stmt->bind_param("sssisis", $name, $author, $genre, $price, $stock, $publish_date, $location);

    if ($stmt->execute()) {
        $success = true;
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
if (isset($_GET['publish_date']) && !empty($_GET['publish_date'])) {
    $publish_date = $_GET['[publish_date]'];
    $where .= " AND publish_date = ?";
    $dateParam = date_create_from_format('Y-m-d', $publish_date); // Create a DateTime object
} else {
    $dateParam = null;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <title>Add New Book</title>
    <script>
        <?php if (isset($success) && $success === true): ?>
            window.onload = function() {
                alert("Book added successfully!");
                window.location.href = "index.php";
            }
        <?php endif; ?>
    </script>
    <script>
    function goBack() {
        window.history.back();
    }

    <?php if (isset($success) && $success === true): ?>
        window.onload = function() {
            window.location.href = "index.php";
        }
    <?php endif; ?>
    </script>
</head>
<body class="bg-dark">
    <div class="container">
        <div class="row mt-5">
            <div class="col">
                <div class="card mt-5">
                    <div class="card-header bg-primary text-white">
                        <h2 class="display-6 text-center">Add New Book</h2>
                    </div>
                    <div class="card-body">
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                            <div class="form-group">
                                <label for="name">Book Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="form-group">
                                <label for="author">Author</label>
                                <input type="text" class="form-control" id="author" name="author" required>
                            </div>
                            <div class="form-group">
                                <label for="genre">Genre</label>
                                <input type="text" class="form-control" id="genre" name="genre" required>
                            </div>
                            <div class="form-group">
                                <label for="price">Price</label>
                                <input type="number" class="form-control" id="price" name="price" required>
                            </div>
                            <div class="form-group">
                                <label for="stock">Stock</label>
                                <input type="number" class="form-control" id="stock" name="stock" required>
                            </div>
                            <div class="form-group">
                                <label for="publish_date">Publish Date</label>
                                <input type="date" class="form-control" id="publish_date" name="publish_date" required>
                            </div>
                            <div class="form-group">
                                <label for="location">Location</label>
                                <input type="text" class="form-control" id="location" name="location" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Add Book</button>
                            <button type="button" class="btn btn-danger" onclick="goBack()">Cancel</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>