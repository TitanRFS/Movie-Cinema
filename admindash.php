<?php 
	session_start();
	//ένα απλό check για να δει άμα είναι συνδεδεμένος ο χρήστης
//αν δεν είναι συνδεδεμένος τοτε τον ανακατευθύνει στην σελίδα login
//αν είναι συνδεδεμένος τότε εμφανίζει το admin dashboard
	if($_SESSION['user']==true){
		echo "";
	}
	else{
		header('location:admin_login_page.php');
	}
?>

<html class="animated fadeIn">
<head>
	<link href="css/dashstyle.css" type='text/css' rel="stylesheet">
	<link href="css/animate.css" type='text/css' rel="stylesheet">


	<title>Admin Dashboard</title>
</head>
<body class='bg-gray'>

<div class='header'>
<center><img src='images/admin.png' alt="Admin" id="adminlogo"><br><center id='head' class="animated flipInX">ADMIN DASHBOARD</center>

</center>

</div>

<div class='navbar'>

    <ul align="center">
        <li><a href="admindash.php"  >Arxiki</a></li>
        <li><a href="users.php" >USERS</a></li>
        <li><a href="movie.php" >Tainies</a></li>
        <li><a href="theatres.php" >Aithouses</a></li>
        <li><a href="timings.php" class="active">Wres</a></li>
        <li><b class='logout' style="padding-top:14px;padding-right:2px;"><?php echo strtoupper("USER:".$_SESSION['user']);?></b></li>
        <li><a href="logout.php" class='logout' >Aposindesh</a></li>
    </ul>

</div>

<div class='content'>
<br>
<table style='margin-left:30px;padding:0;border:none;background-color:#070505'>
<tr>

	<td>
	<div class="movie-detailscss">
		<a href="users.php">
		<img height="300px" width="300px" style="transition:0.75s;border-radius:20px;" src="images/users.png"> 
		</a>
	</div>
	<center><h4>MANAGE USERS</h4></center>
	</td>
	
	<td>
	<div class="movie-detailscss">
		<a href="movie.php">
		<img height="300px" width="300px" style="transition:0.75s;border-radius:20px;" src="images/movies.jpeg"> 
		</a>
	</div>
	<center><h4>MANAGE MOVIES</h4></center>
	</td>
	
	<td>
	<div class="movie-detailscss">
		<a href="theatres.php">
		<img height="300px" width="300px" style="transition:0.75s;border-radius:20px;" src="images/banner.jpg"> 
		</a>
	</div>
	<center><h4>MANAGE THEATRES</h4></center>
	</td>
	
	<td>
	<div class="movie-detailscss">
		<a href="timings.php">
		<img height="300px" width="300px" style="transition:0.75s;border-radius:20px;" src="images/timer.png"> 
		</a>
	</div>
	<center><h4>MANAGE TIMINGS</h4></center>
	</td>
</tr>
</table>

</div>





</body>
</html>








