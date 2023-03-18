<?php
session_start();
include('databaseconnect.php');
?>

<!DOCTYPE HTML>
<head>
	<meta charset="UTF-8">
		<title>Admin Login</title>
		<link rel="stylesheet" type="text/css" href="css/styles1.css">
		<link href="css/animate.css" type='text/css' rel="stylesheet">
</head>
<body>
<h3 align="right" style="margin-right:20px;">
    <a href="index.php">User Login</a>
</h3>
	<div class="loginbox">
		<img src="images/profile.png" class="profile">
		
		<h2>Admin Login</h2>
		
		<form action="admin_login_page.php" method="post" class="animated flipInY">
			<p>Admin-Name</p>
			<input type="text" name="admin_name" placeholder="Enter Admin-Name">
			
			<p>Password</p>
			<input type="password" name="adminpass" placeholder="Enter Password"><br>
			
			<input type="submit" name="submit1" value="Login"><br>
			
		</form>
	</div>


</body>
</html>		


<?php
//Αυτός ο κώδικας είναι για την σελίδα του admin_login_page.php
//Είναι η σελίδα που θα εμφανίζεται όταν ο admin θα κάνει login
//και δέχεται username password του admin από το database και ελέγχει αν είναι σωστά
//αν είναι σωστά τότε εμφανίζει το admin dashboard
//αν δεν είναι σωστά τότε εμφανίζει μήνυμα λάθους
//και επιστρέφει στην σελίδα login
//Επίσης έχει και το session για να μπορεί να εμφανίζεται το admin dashboard
//και να μπορεί να κάνει logout από το admin dashboard
//Ελέγχει αν το username και το password είναι σωστά

	if(isset($_POST['submit1']))
	{   $admin_name = $_POST['admin_name'];
		$adminpassword= $_POST['adminpass'];

		$adminq = "select * from admin WHERE username='$admin_name' AND password='$adminpassword'";
		$stmt = $conn->prepare($adminq);
        $stmt=mysqli_prepare($conn,$adminq);
        mysqli_stmt_execute($stmt);
        $result=mysqli_stmt_get_result($stmt);
        $rowadmin = mysqli_num_rows($result);
		if($rowadmin <1)
		{
			?>
			<script>
			alert("Username and Password Not Match.");
			</script>
			<?php
		}
		else
		{
			?>
			<script>
			alert("login success");
			</script>
			<?php
			$_SESSION['user']=$admin_name;
			$_SESSION['updated']=NULL;
			$_SESSION['updated1']=NULL;
			$_SESSION['updated2']=NULL;
			$_SESSION['updated3']=NULL;
			header('location:admindash.php');
		
		}
		
	}


		
?>	 