<?php
require_once __DIR__ . '/../config/db.php';
require_once 'config/functions.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = $_POST["firstname"];
    $surname = $_POST["surname"];
    $gender = $_POST["gender"];
    $phone = $_POST["phone"];
    $email = $_POST["email"];
    $book_borrowed = $_POST["book_borrowed"];
    $amount_due = $_POST["amount_due"];
    $expiry_date = $_POST["expiry_date"];
    $status = $_POST["status"];

    $query = "INSERT INTO penalty (firstname, surname, gender, phone, email, book_borrowed, amount_due, expiry_date, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $con->prepare($query);
    $stmt->bind_param("sssssssss", $firstname, $surname, $gender, $phone, $email, $book_borrowed, $amount_due, $expiry_date, $status);

    if ($stmt->execute()) {
        $success = true;
    } else {
        echo "Error: " . $stmt->error. "<br>";
        echo "Query: " . $query;
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
    <title>Add Penalty Record</title>
    <script>
        <?php if (isset($success) && $success === true): ?>
            window.onload = function() {
                alert("Record Added successfully!");
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
                        <h2 class="display-6 text-center">Add Penalty Record</h2>
                    </div>
                    <div class="card-body">
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                            <div class="form-group">
                                <label for="firstname">Firstname</label>
                                <input type="text" class="form-control" id="firstname" name="firstname" required>
                            </div>
                            <div class="form-group">
                                <label for="surname">Surname</label>
                                <input type="text" class="form-control" id="surname" name="surname" required>
                            </div>
                            <div class="form-group">
                                <label for="gender">Gender</label>
                                <select class="form-control" id="gender" name="gender" required>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone No</label>
                                <input type="varchar" class="form-control" id="phone" name="phone" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="varchar" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="form-group">
                                <label for="book_borrowed">Book Borrowed</label>
                                <input type="text" class="form-control" id="book_borrowed" name="book_borrowed" required>
                            </div>
                            <div class="form-group">
                                <label for="amount_due">Amount Due (£)</label>
                                <input type="amount_due" class="form-control" id="amount_due" name="amount_due" required>
                            </div>
                            <div class="form-group">
                                <label for="expiry_date">Expiry Date</label>
                                <input type="date" class="form-control" id="expiry_date" name="expiry_date" required>
                            </div>
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select class="form-control" id="status" name="status" required>
                                    <option value="paid">Paid</option>
                                    <option value="unpaid">Not Paid</option>
                                </select>
                            </div>
        
                            <button type="submit" class="btn btn-success">Confirm</button>
                            <button type="return" class="btn btn-danger" onclick="goBack()">Cancel</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>