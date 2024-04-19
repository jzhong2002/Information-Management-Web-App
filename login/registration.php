<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css"/>
    <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1"/>
    <style>
        .password-strength-bar {
            height: 5px;
            margin-top: 5px;
            transition: width 0.3s ease-in-out;
        }

        .weak {
            width: 25%;
            background-color: red;
        }

        .normal {
            width: 50%;
            background-color: orange;
        }

        .strong {
            width: 100%;
            background-color: green;
        }
    </style>
    <script>
        function validateForm() {
            var dobInput = document.getElementById("date_of_birth");
            var dob = new Date(dobInput.value);
            var today = new Date();
            var age = today.getFullYear() - dob.getFullYear();
            var monthDiff = today.getMonth() - dob.getMonth();

            if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < dob.getDate())) {
                age--;
            }

            if (age < 18) {
                alert("You must be at least 18 years old to register.");
                dobInput.focus();
                return false;
            }

            // Password strength validation
            var passwordInput = document.getElementById("password");
            var password = passwordInput.value;
            var strength = checkPasswordStrength(password);

            // Apply CSS classes based on password strength
            var progressBar = document.getElementById("password-strength-bar");
            progressBar.classList.remove("weak", "normal", "strong");
            if (strength === "weak") {
                progressBar.classList.add("weak");
            } else if (strength === "normal") {
                progressBar.classList.add("normal");
            } else if (strength === "strong") {
                progressBar.classList.add("strong");
            }

            // Check for empty input fields
            var requiredFields = document.querySelectorAll("input[required], select[required]");
            var emptyFields = [];
            for (var i = 0; i < requiredFields.length; i++) {
                if (requiredFields[i].value.trim() === "") {
                    emptyFields.push(requiredFields[i].name);
                }
            }

            if (emptyFields.length > 0) {
                alert("Please fill in the following fields: " + emptyFields.join(", "));
                return false;
            }
        }

        function checkPasswordStrength(password) {
            var strength = "weak";
            if (password.length >= 8) {
                strength = "normal";
                if (/[A-Z]/.test(password) && /[a-z]/.test(password) && /\d/.test(password) && /[!@#$%^&*(),.?":{}|<>]/.test(password)) {
                    strength = "strong";
                }
            }
            return strength;
        }

        window.onload = function() {
            var passwordInput = document.getElementById("password");
            var progressBar = document.getElementById("password-strength-bar");

            passwordInput.addEventListener("input", function() {
                var password = passwordInput.value;
                var strength = checkPasswordStrength(password);

                // Update progress bar based on password strength
                progressBar.classList.remove("weak", "normal", "strong");
                if (strength === "weak") {
                    progressBar.classList.add("weak");
                } else if (strength === "normal") {
                    progressBar.classList.add("normal");
                } else if (strength === "strong") {
                    progressBar.classList.add("strong");
                }
            });
        }
    </script>
</head>
<body>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <a class="navbar-brand" href="https://sourcecodester.com">Sourcecodester</a>
        </div>
    </nav>
    <div class="col-md-3"></div>
    <div class="col-md-6 well">
        <h3 class="text-primary">Staff Registration</h3>
        <hr style="border-top:1px dotted #ccc;"/>
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <form action="register_query.php" method="POST" onsubmit="return validateForm()">
                <h4 class="text-success">Register here...</h4>
                <hr style="border-top:1px groovy #000;">
                <div class="form-group">
                    <label>Title</label>
                    <select class="form-control" name="title">
                        <option value="Select">Select a title</option>
                        <option value="mr">Mr</option>
                        <option value="mrs">Mrs</option>
                        <option value="miss">Miss</option>
                        <option value="ms">Ms</option>
                        <option value="dr">Dr</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Firstname</label>
                    <input type="text" class="form-control" name="firstname"/>
                </div>
                <div class="form-group">
                    <label>Surname</label>
                    <input type="text" class="form-control" name="surname"/>
                </div>
                <div class="form-group">
                    <label>Gender</label>
                    <select class="form-control" name="gender">
                        <option value="Select">Select a gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Date of Birth</label>
                    <input type="date" class="form-control" name="date_of_birth" id="date_of_birth"/>
                </div>
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" class="form-control" name="username"/>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" class="form-control" name="password" id="password"/>
                    <div class="password-strength-bar" id="password-strength-bar"></div>
                </div>
                <div class="form-group">
                    <label>Job Role</label>
                    <select class="form-control" name="job_role">
                        <option value="staff">Staff</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <br/>
                <div class="form-group">
                    <button class="btn btn-primary form-control" name="register" type="submit">Register</button>
                </div>
                <a href="../digitallibrary.php">Login</a>
            </form>
        </div>
    </div>
</body>
</html>