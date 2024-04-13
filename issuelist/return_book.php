<?php
require_once 'config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $issueId = $_POST["Id"]; // Assuming you have a unique identifier for each issued book

    // Update the status of the book in the database
    $query = "UPDATE issuedbooks SET status = 'returned' WHERE id = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $issueId);

    if ($stmt->execute()) {
        $succes = true;
        header("Location: index.php");
        exit();
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
    <title>Return Book</title>
</head>
<body class="bg-dark">
    <div class="container">
        <div class="row mt-5">
            <div class="col">
                <div class="card mt-5">
                    <div class="card-header bg-primary text-white">
                        <h2 class="display-6 text-center">Return Book</h2>
                    </div>
                    <div class="card-body">
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                            <div class="form-group">
                                <label for="issue_Id">Issue ID</label>
                                <input type="text" class="form-control" id="Id" name="Id" required>
                            </div>
                            <button type="submit" class="btn btn-success">Return Book</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>