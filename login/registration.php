<!DOCTYPE html>
<html lang="en">
	<head>
		<link rel="stylesheet" type="text/css" href="css/bootstrap.css"/>
		<meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1"/>
	</head>
<body>
	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<a class="navbar-brand" href="https://sourcecodester.com">Sourcecodester</a>
		</div>
	</nav>
	<div class="col-md-3"></div>
	<div class="col-md-6 well">
		<h3 class="text-primary">User Registration</h3>
		<hr style="border-top:1px dotted #ccc;"/>
		<div class="col-md-2"></div>
		<div class="col-md-8">
			<form action="register_query.php" method="POST">	
				<h4 class="text-success">Register here...</h4>
				<hr style="border-top:1px groovy #000;">
				<div class="form-group">
					<label>Firstname</label>
					<input type="text" class="form-control" name="firstname" />
				</div>
				<div class="form-group">
					<label>Surname</label>
					<input type="text" class="form-control" name="surname" />
				</div>
				<div class="form-group">
					<label>Gender</label>
					<select class="form-control" name="gender">
						<option value="Select">Select a gender</option>
						<option value="male">Male</option>
						<option value="female">Female</option>
					</select>
				</div>
				<div class="form-group">
					<label>Date of Birth</label>
					<input type="date" class="form-control" name="date_of_birth" />
				</div>
				<div class="form-group">
					<label>Username</label>
					<input type="text" class="form-control" name="username" />
				</div>
				<div class="form-group">
					<label>Password</label>
					<input type="password" class="form-control" name="password" />
				</div>
				<div class="form-group">
					<label>Job Role</label>
					<select class="form-control" name="job_role">
						<option value="staff">Staff</option>
						<option value="admin">Admin</option>
					</select>
				</div>
				<br />
				<div class="form-group">
					<button class="btn btn-primary form-control" name="register">Register</button>
				</div>
				<a href="../digitallibrary.php">Login</a>
			</form>
		</div>
	</div>
</body>
</html>