<?php
require_once 'config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $book_id = $_POST["book_id"];

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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <title>Delete Book</title>
    <script>
        function confirmDelete(bookId) {
            if (confirm("Are you sure you want to delete this book?")) {
                document.getElementById("book_id").value = bookId;
                document.getElementById("deleteForm").submit();
            }
        }

        <?php if (isset($success) && $success === true): ?>
            window.onload = function() {
                alert("Book deleted successfully!");
                window.location.href = "index.php";
            }
        <?php endif; ?>

        // Wait for the document to be ready
$(document).ready(function() {
    // Add click event listener to delete buttons
    $('.delete-button').click(function() {
        // Get the action and id values from the data attributes
        var action = $(this).data('action');
        var id = $(this).data('id');

        // Show confirmation dialog
        if (confirm('Are you sure you want to delete this record?')) {
            // Redirect to the delete URL
            window.location.href = '?action=' + action + '&id=' + id;
        }
    });
});
    </script>
</head>
<body class="bg-dark">
    <div class="container">
        <div class="row mt-5">
            <div class="col">
                <div class="card mt-5">
                    <div class="card-header bg-primary text-white">
                        <h2 class="display-6 text-center">Delete Book</h2>
                    </div>
                    <div class="card-body">
                        <form id="deleteForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                            <input type="hidden" name="book_id" id="book_id" value="">
                            <p>Are you sure you want to delete this book?</p>
                            <button type="button" class="btn btn-danger" onclick="confirmDelete(<?php echo $_GET['book_id']; ?>)">Yes, Delete</button>
                            <a href="index.php" class="btn btn-secondary">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>