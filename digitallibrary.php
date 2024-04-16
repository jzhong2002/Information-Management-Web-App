<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Type Selection</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            max-width: 500px;
            margin-top: 100px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4 class="card-title">Select User Type</h4>
            </div>
            <div class="card-body">
                <p>Please select whether you are a staff member or an admin:</p>
                <div class="form-group">
                    <a href="login/login.php" class="btn btn-primary btn-block">Staff</a>
                    <a href="login/index.php" class="btn btn-primary btn-block">Admin</a>
                    <a href="login/registration.php" class="btn btn-primary btn-block">Register</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>