<?php 
	session_start();
	
	if($_SESSION['user']==true){
		echo "";
	}
	else{
		header('location:admin_login_page.php');
	}
?>
<html>
<head>
	<link href="css/dashstyle.css" type='text/css' rel="stylesheet">
	<link href="css/animate.css" type='text/css' rel="stylesheet">

	<title>users</title>

	
</head>
<body class='bg-gray animated fadeIn'>

<div class='header'>
<center><img src='images/admin.png' alt="AdminLogo" id="adminlogo"><br><center id='head' class="animated flipInX">ADMIN DASHBOARD</center>

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
<?php

include("databaseconnect.php");

$query="select * FROM users";
$user_res = mysqli_query($conn,$query);
$row_count=mysqli_num_rows($user_res);

if($row_count==0){echo  "<br><center><b>SHOWING 0 RESULTS.<b></center>";
}
else{
	echo  "<br><center><b>SHOWING ".$row_count." RESULTS.<b></center><br>";
	
?>
<table align='center' border='1'>

<tr>
<th>Sr.No</th>
<th>USERNAME</th>
<th>EMAIL-ID</th>
<th>BOOKINGS</th>

</tr>

<?php
 /** @var TYPE_NAME $i */
$i=0;
for($i; $i<$row_count; $i++)
{
	$data=mysqli_fetch_assoc($user_res);
	?>
	<tr>
	<td><?php echo $i+1 ?></td>
	<td><?php echo $data["username"] ?></td>
	<td><?php echo $data["email"] ?></td>
	<td><?php $user=$data["username"];
    $query5 = "select * from bookings where username='$user' ";
		$user_res=mysqli_query($conn,$query5);
		$table_book=mysqli_fetch_array($user_res);
		while($table_book=mysqli_fetch_array($user_res)){
		echo nl2br("\n"."Movie-".$table_book['movie']."\nDate-".$table_book['date']."\n");
		}?></td>
	</tr>
	<?php
}
}
?>
</div>
</body>
</html>








