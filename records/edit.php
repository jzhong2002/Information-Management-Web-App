<?php
require_once __DIR__ . '/../config/db.php';
require_once 'config/functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $book_id = $_POST["book_id"];
    $name = $_POST["name"];
    $author = $_POST["author"];
    $genre = $_POST["genre"];
    $price = $_POST["price"];
    $stock = $_POST["stock"];
    $publish_date = $_POST["publish_date"];
    $location = $_POST["location"];

    $query = "UPDATE records SET name = ?, author = ?, genre = ?, price = ?, stock = ?, publish_date = ?, location = ? WHERE book_id = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("sssiissi", $name, $author, $genre, $price, $stock, $publish_date, $location, $book_id);

    if ($stmt->execute()) {
        $success = true;
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
} else {
    $book_id = $_GET["book_id"];
    $query = "SELECT * FROM records WHERE book_id = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $book_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $book = $result->fetch_assoc();
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <title>Edit Book</title>
    <script>
    <?php if (isset($success) && $success === true): ?>
        window.onload = function() {
            alert("Book details updated successfully!");
            window.location.href = "index.php";
        }
    <?php endif; ?>
</script>
<script>
    function goBack() {
        event.preventDefault();
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
                        <h2 class="display-6 text-center">Edit Book</h2>
                    </div>
                    <div class="card-body">
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                            <input type="hidden" name="book_id" value="<?php echo $book['book_id']; ?>">
                            <div class="form-group">
                                <label for="name">Book Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="<?php echo $book['name']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="author">Author</label>
                                <input type="text" class="form-control" id="author" name="author" value="<?php echo $book['author']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="genre">Genre</label>
                                <input type="text" class="form-control" id="genre" name="genre" value="<?php echo $book['genre']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="price">Price</label>
                                <input type="number" class="form-control" id="price" name="price" value="<?php echo $book['price']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="stock">Stock</label>
                                <input type="number" class="form-control" id="stock" name="stock" value="<?php echo $book['stock']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="publish_date">Publish Date</label>
                                <input type="date" class="form-control" id="publish_date" name="publish_date" value="<?php echo $book['publish_date']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="location">Location</label>
                                <input type="text" class="form-control" id="location" name="location" value="<?php echo $book['location']; ?>" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Update Book</button>
                            <button type="button" class="btn btn-danger" onclick="goBack()">Cancel</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>