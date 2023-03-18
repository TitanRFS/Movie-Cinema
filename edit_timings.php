<?php 
	session_start();
	
	if($_SESSION['user']==true){
		echo "";
	}
	else{
		header('location:admin_login_page.php');
	}
?>
<!DOCTYPE html>
<!-- Αυτό το αρχείο μας δίνει την δυνατότητα να αλλάξουμε ώρες στις προβολες
 χωρίς μεγάλα προβλήματα-->
<html>
<head>
    /*Εδώ έχουμε τα css αρχεία που χρησιμοποιούμε για τον σχεδιασμό της σελίδας*/
	<link href="css/dashstyle.css" type='text/css' rel="stylesheet">
	<link href="css/animate.css" type='text/css' rel="stylesheet">
	<title>Edit</title>
</head>
<body class='bg-gray'>
<div class='header'>
<center><img src='images/admin.png' alt="AdminLogo" id="adminlogo"><br><center id='head'>Admin dashboard</center>

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

?>

<div id="edit" style="display:block;"  class="pop animated jackInTheBox">
  <div class="pop-content" style="padding:32px">
  <h1 align='center'>EDIT</h1><br>
    <span class="close" onclick="location.href='timings.php'">&times;</span>	
	<?php
    $id = $_REQUEST['eid'];
    $query1 = "SELECT showtime, Theatre_Name FROM timings WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query1);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $r1 = mysqli_fetch_assoc($result);
	
	?>
	<form  method="post">
	<table align='center'>
	<tr>
	<td><b>SHOWTIME-</b></td>
	<td><input type='time' name='time' value="<?php echo $r1['showtime']?>" required></td>
	</tr>
	<tr>
	<td><b>THEATRE-</b></td>
	<td><input type='text' name='theatre' value="<?php echo $r1['Theatre_Name']?>" required></td>
	</tr>
	
	<tr>
	<td ><input type='submit' name='submit' style="margin-left:75%;" value="SUBMIT"></td>
	</tr>
	
	</table>
	
	</form>


</div>

</div>
<?php
include 'databaseconnect.php';
if( isset($_POST['submit'])) {


    $theatre = $_POST['theatre'] ?? '';
    $time = $_POST['time'] ?? '';
    $id = $_POST['id'] ?? ''; // added missing id

    $update_query = "UPDATE timings SET Theatre_Name = ?, showtime = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $update_query);
    mysqli_stmt_bind_param($stmt, 'ssi', $theatre, $time, $id); // added missing $id

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['updated3'] = true;
        header('location:timings.php');
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}?>
</div>
</body>
</html>