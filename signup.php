<?php 
	session_start();
	
	if(isset($_SESSION['name'])){
		header('location:userindex.php');
	}

?>
<!DOCTYPE HTML>
<html lang="en_US">
<head>
	<meta charset="UTF-8">
		<title>Signup</title>

		<link rel="stylesheet" type="text/css" href="css/signupstyles.css">
</head>
<body>
	<div class="title">
	</div>
	<div class="loginbox">
		<img src="images/profile.png" class="profile">
		<h2>Signup Here</h2>
		<form action="signup.php" method="post" class="animated flipInY">
			<p style="font-size:15px">Username</p>
			<input type="text" name="username" placeholder="Enter Username" required>
			<p style="font-size:15px">Email</p>
			<input type="email" name="email" placeholder="Enter Email" required>
			<p style="font-size:15px">Password</p> <input type="password" name="password" placeholder="Enter Password" id="myInput" required>

            <input type="submit" name="submit" value="Signup">
			<a href="index.php">Already have an account?</a>
		</form>
	</div>
</body>
</html>
<?php
//Εδώ συνδέεται με το database που έχουμε δημιουργήσει και ελέγχει αν οι πληροφορίες που έχουμε δώσει στο signup
//και μετά τις στέλνει στον πίνακα users
	include('databaseconnect.php');

if (isset($_POST['submit'])) {
    $user_name = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password1 = $_POST['password1'];

    // check if username already exists
    $query = "SELECT * FROM users WHERE username = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $user_name);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if (mysqli_num_rows($result) > 0) {
        // display error message
        echo '<script>alert("Username Already Exist.Try other Username.");</script>';
    } else {
        // insert new user into database
        $query = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "sss", $user_name, $email, $password);
        mysqli_stmt_execute($stmt);

        // start session and set session variables
        session_start();
        $_SESSION['name'] = $user_name;
        $_SESSION['email'] = $email;

        // display success message and redirect
        echo '<script>alert("Registered Successfully");</script>';
        header('location: userindex.php');
    }
}


		
?>	 