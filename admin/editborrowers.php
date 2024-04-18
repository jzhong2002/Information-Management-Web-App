<?php
require_once __DIR__ . '/../config/db.php';
require_once 'config/functions.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $borrowers_id = $_POST["borrower_id"];
    $firstname = $_POST["firstname"];
    $surname = $_POST["surname"];
    $gender = $_POST["gender"];
    $phone = $_POST["phone"];
    $email = $_POST["email"];
    $date_of_birth = date('Y-m-d', strtotime($_POST['date_of_birth']));
    $address = $_POST["address"];

    $query = "UPDATE borrowers SET firstname = ?, surname = ?, gender = ?, phone = ?, email = ?, date_of_birth = ?, address = ? WHERE borrower_id = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("sssssssi", $firstname, $surname, $gender, $phone, $email, $date_of_birth, $address, $borrowers_id);

    if ($stmt->execute()) {
        $success = true;
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
} else {
    $id = $_GET["id"];
    $query = "SELECT * FROM borrowers WHERE borrower_id = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $borrowers = $result->fetch_assoc();
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
    <title>Edit Records</title>
    <script>
    <?php if (isset($success) && $success === true): ?>
        window.onload = function() {
            alert("Library Member details updated successfully!");
            window.location.href = "borrowers.php";
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
            window.location.href = "borrowers.php";
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
                        <h2 class="display-6 text-center">Edit Library Member Details</h2>
                    </div>
                    <div class="card-body">
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                        <input type="hidden" name="borrower_id" value="<?php echo $borrowers['borrower_id'];?>">
                            <div class="form-group">
                                <label for="firstname">Firstname</label>
                                <input type="text" class="form-control" id="firstname" name="firstname" value="<?php echo $borrowers['firstname']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="surname">Surname</label>
                                <input type="text" class="form-control" id="surname" name="surname" value="<?php echo $borrowers['surname']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="gender">Gender</label>
                                <select class="form-control" id="gender" name="gender" required>
                                <option value="Male" <?php if ($borrowers['gender'] == 'Male') echo 'selected'; ?>>Male</option>
                                <option value="Female"<?php if ($borrowers['gender'] == 'Female') echo 'selected'; ?>>Female</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone No</label>
                                <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $borrowers['phone']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="text" class="form-control" id="email" name="email" value="<?php echo $borrowers['email']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="date">Date of Birth</label>
                                <input type="date" class="form-control" id="date" name="date" value="<?php echo $borrowers['date_of_birth']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="address">Address</label>
                                <input type="text" class="form-control" id="address" name="address" value="<?php echo $borrowers['address']; ?>" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Update Record</button>
                            <button type="button" class="btn btn-danger" onclick="goBack()">Cancel</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>