<?php
require_once 'config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];

    $query = "DELETE FROM issuedbooks WHERE id = ?";
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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <title>Delete Record</title>
    <script>
        function confirmDelete(id) {
            if (confirm("Are you sure you want to delete this record?")) {
                document.getElementById("id").value = id;
                document.getElementById("deleteForm").submit();
            }
        }

        <?php if (isset($success) && $success === true): ?>
            window.onload = function() {
                alert("record deleted successfully!");
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
                        <h2 class="display-6 text-center">Delete record</h2>
                    </div>
                    <div class="card-body">
                        <form id="deleteForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                            <input type="hidden" name="id" id="id" value="">
                            <p>Are you sure you want to delete this record?</p>
                            <button type="button" class="btn btn-danger" onclick="confirmDelete(<?php echo $_GET['id']; ?>)">Yes, Delete</button>
                            <a href="index.php" class="btn btn-secondary">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>