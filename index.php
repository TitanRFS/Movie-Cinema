<?php 
	session_start();
	
	if(isset($_SESSION['name'])){
		header('location:userindex.php');
	}
//Έδώ έχουμε το login form του user
//το οποιο συνδέεται με το database που έχουμε δημιουργήσει
//και ελέγχει αν οι πληροφορίες που έχουμε δώσει στο user
//login form είναι σωστές
?>
<!DOCTYPE HTML>
<html lang="en_US">
<head>
	<meta charset="UTF-8">
		<title>Sign In</title>

		<link rel="stylesheet" type="text/css" href="css/index.css">
        <link rel="stylesheet" type="text/css" href="css/signupstyles.css">
</head>
<style>
body{
    background-image: url("images/banner.jpg");
    background-size: cover;
}
</style>
<body >
	<div class="title">
	</div>
	<div class="loginbox">
		<img src="images/profile.png" class="profile" />
		
		<h2>Login Here</h2>
		
		<form action="index.php" method="post" class="animated flipInY">
			<p>Username</p>
			<input type="text" name="username" placeholder="Enter Username" required>
			
			<p>Password</p>
			<input type="password" name="password" placeholder="Enter Password" required><br>
			
			<input type="submit" name="submit" value="Login"><br>
			
			<a href="signup.php">Create new account?</a>
		</form>
	</div>


</body>
</html>		


<?php
//εδώ συνδέεται με το database που έχουμε δημιουργήσει και ελέγχει αν οι πληροφορίες που έχουμε δώσει στο user
//login form είναι σωστές
//Αν είναι σωστές τότε θα μας πάει στην userindex.php
//Αν δεν είναι σωστές θα μας εμφανίσει ένα μήνυμα λάθους
//Αν δεν έχουμε κάνει εγγραφή θα μας πάει στην signup.php
//Αν έχουμε κάνει εγγραφή θα μας πάει στην userindex.php
	include('databaseconnect.php');
	if(isset($_POST['submit'])) {
		$username = $_POST['username'];
		$password= $_POST['password'];

		$query = "select * from users WHERE username='$username'";
		$stmt=mysqli_prepare($conn,$query);
        mysqli_stmt_execute($stmt);
        $run = mysqli_stmt_get_result($stmt);
        $row = mysqli_num_rows($run);
		
		if($row <1) {
			?>
			<script>
			alert("Invalid Username");
			</script>
			<?php
		}
		else {
			$logindata = mysqli_fetch_array($run);
			if(password_verify($password,$logindata['password'])) {
			$usern1= $logindata['username'];
			$eml1= $logindata['email'];
			session_start();
			$_SESSION['name']=$usern1;
			$_SESSION['email']=$eml1;
			header('location:userindex.php');
            }
            else {
                ?>
                <script>
                alert("Invalid Password");
                </script>
                <?php
			}
	}
	}



?>