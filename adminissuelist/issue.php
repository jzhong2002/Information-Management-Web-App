<?php
require_once __DIR__ . '/../config/db.php';
require_once 'config/functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = $_POST["firstname"];
    $surname = $_POST["surname"];
    $phone = $_POST["phone"];
    $email = $_POST["email"];
    $book_name = $_POST["book_name"];
    $expiry_date = $_POST["expiry_date"];
    $status = $_POST["status"];

    // Check if the book exists in the database
    $query = "SELECT stock FROM records WHERE name = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("s", $book_name);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $stock = $row['stock'];

        if ($stock > 0) {
            // Book exists and has enough stock, proceed with issuing the book
            $query = "INSERT INTO issuedbooks (firstname, surname, phone, email, book_name, expiry_date, status) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $con->prepare($query);
            $stmt->bind_param("sssssss", $firstname, $surname, $phone, $email, $book_name, $expiry_date, $status);

            if ($stmt->execute()) {
                $success = true;

                // Update the stock quantity
                $newStock = $stock - 1;
                $updateQuery = "UPDATE records SET stock = ? WHERE name = ?";
                $updateStmt = $con->prepare($updateQuery);
                $updateStmt->bind_param("is", $newStock, $book_name);
                $updateStmt->execute();
                $updateStmt->close();
            } else {
                echo "Error: " . $stmt->error . "<br>";
                echo "Query: " . $query;
            }
        } else {
            echo "Book is out of stock.";
        }
    } else {
        echo "Book not found in the database.";
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
    <title>Issue Book</title>
    <script>
        function validateForm() {
            // Check if the phone number is a valid number
            var phoneInput = document.getElementById("phone");
            var phonePattern = /^\d+$/;
            if (!phonePattern.test(phoneInput.value)) {
                alert("Please enter a valid phone number.");
                phoneInput.focus();
                return false;
            }

            // Check if the email is a valid email address
            var emailInput = document.getElementById("email");
            var emailPattern = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
            if (!emailPattern.test(emailInput.value)) {
                alert("Please enter a valid email address.");
                emailInput.focus();
                return false;
            }

            return true;
        }

        <?php if (isset($success) && $success === true): ?>
            window.onload = function() {
                alert("Book Issued successfully!");
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
                        <h2 class="display-6 text-center">Issue New Book</h2>
                    </div>
                    <div class="card-body">
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" onsubmit="return validateForm()">
                            <div class="form-group">
                                <label for="firstname">Firstname</label>
                                <input type="text" class="form-control" id="firstname" name="firstname" required pattern="[a-zA-Z]+">
                            </div>
                            <div class="form-group">
                                <label for="surname">Surname</label>
                                <input type="text" class="form-control" id="surname" name="surname" required pattern="[a-zA-Z]+">
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone No</label>
                                <input type="tel" class="form-control" id="phone" name="phone" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="form-group">
                                <label for="book_name">Book Name</label>
                                <input type="text" class="form-control" id="book_name" name="book_name" required>
                            </div>
                            <div class="form-group">
                                <label for="expiry_date">Expiry Date</label>
                                <input type="date" class="form-control" id="expiry_date" name="expiry_date" required>
                            </div>
                            <div class="form-group">
                                <label for="status">Status</label>
                                <input type="text" class="form-control" id="status" name="status" required value="Issued">
                            </div>
                            <button type="submit" class="btn btn-success">Confirm</button>
                            <button type="button" class="btn btn-danger" onclick="goBack()">Cancel</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>