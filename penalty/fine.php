<?php
require_once __DIR__ . '/../config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Id = $_POST["Id"]; // Assuming you have a unique identifier for each issued book

    // Update the status of the book in the database
    $query = "UPDATE issuedbooks SET status = 'returned' WHERE id = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $Id);

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

    <script>
    function goBack() {
        window.location.href = "index.php";
    }

    <?php if (isset($success) && $success === true): ?>
        window.onload = function() {
            window.location.href = "index.php";
        }
    <?php endif; ?>
    </script>

<!DOCTYPE html>
<html>
<head>
    <title>Issue Fine</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>
<body>
    <h1>Issue Fine</h1>
    
    <form method="post" action="send-email.php">
        <label for="name">Name</label>
        <input type="text" name="name" id="name" required>
        
        <label for="email">Email</label>
        <input type="email" name="email" id="email" required>
        
        <label for="subject">Subject</label>
        <input type="text" name="subject" id="subject" required>
        
        <label for="message">Message</label>
        <textarea name="message" id="message" required></textarea>
        
        <br>
        
    <button type="submit" class="btn btn-success">Submit</button>
    <button type="button" onclick="goBack()" class="btn btn-danger">Cancel</button>
    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>