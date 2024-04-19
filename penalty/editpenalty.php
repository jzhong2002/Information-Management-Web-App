<?php
require_once __DIR__ . '/../config/db.php';
require_once 'config/functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $title = ucfirst(strtolower($_POST['title']));
    $firstname = ucfirst(strtolower($_POST['firstname']));
    $surname = ucfirst(strtolower($_POST['surname']));
    $gender = ucfirst(strtolower($_POST["gender"]));
    $phone = $_POST["phone"];
    $email = $_POST["email"];
    $book_borrowed = $_POST["book_borrowed"];
    $amount_due = $_POST["amount_due"];
    $expiry_date = date('Y-m-d', strtotime($_POST["expiry_date"]));
    $status = ucfirst(strtolower($_POST["status"]));

    $query = "UPDATE penalty SET title = ?, firstname = ?, surname = ?, gender = ?, phone = ?, email = ?, book_borrowed = ?, amount_due = ?, expiry_date = ?, status = ? WHERE id = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("ssssississi", $title, $firstname, $surname, $gender, $phone, $email, $book_borrowed, $amount_due, $expiry_date, $status, $id);

    if ($stmt->execute()) {
        $success = true;
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
} else {
    $id = $_GET["id"];
    $query = "SELECT * FROM penalty WHERE id = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $id);
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
    <title>Edit Penalty Record</title>
    <script>
    <?php if (isset($success) && $success === true): ?>
        window.onload = function() {
            alert("Record updated successfully!");
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
                        <h2 class="display-6 text-center">Edit Penalty Record</h2>
                    </div>
                    <div class="card-body">
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                            <input type="hidden" name="id" value="<?php echo $book['id']; ?>">
                            <div class="form-group">
                            <label for="title">Title</label>
                                <select class="form-control" name="title" id="title" required>
                                    <option value="Select">Select a title</option>
                                    <option value="mr">Mr</option>
                                    <option value="mrs">Mrs</option>
                                    <option value="miss">Miss</option>
                                    <option value="ms">Ms</option>
                                    <option value="dr">Dr</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="firstname">Firstname</label>
                                <input type="text" class="form-control" id="firstname" name="firstname" value="<?php echo $book['firstname']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="surname">Surname</label>
                                <input type="text" class="form-control" id="surname" name="surname" value="<?php echo $book['surname']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="gender">Gender</label>
                                <select class="form-control" id="gender" name="gender" value="<?php echo $book['gender']; ?>" required>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                    <option value="other">Other</option>
                                </select> 
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone</label>
                                <input type="number" class="form-control" id="phone" name="phone" value="<?php echo $book['phone']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="text" class="form-control" id="email" name="email" value="<?php echo $book['email']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="book_borrowed">Book Borrowed</label>
                                <input type="text" class="form-control" id="book_borrowed" name="book_borrowed" value="<?php echo $book['book_borrowed']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="amount_due">Amount Due (£)</label>
                                <input type="number" class="form-control" id="amount_due" name="amount_due" value="<?php echo $book['amount_due']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="expiry_date">Expiry Date</label>
                                <input type="DATE" class="form-control" id="expiry_date" name="expiry_date" value="<?php echo $book['expiry_date']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select class="form-control" id="status" name="status" value="<?php echo $book['status']; ?>" required>
                                    <option value="paid">Paid</option>
                                    <option value="not paid">Not Paid</option> 
                                </select>
                            </div>
                            <button type="submit" class="btn btn-success">Update Book</button>
                            <button type="return" class="btn btn-danger" onclick="goBack()">Cancel</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>