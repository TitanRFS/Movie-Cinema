<?php 
	session_start();
	//Ένα απλό if για να ελέγξει αν ο χρήστης είναι συνδεδεμένος
	if($_SESSION['user']==true){
		echo "";
	}
	else{
		header('location:admin_login_page.php');
	}
?>

<html>
<head>
    <--! Bootstrap CSS -->
	<link href="css/dashstyle.css" type='text/css' rel="stylesheet">
	<link href="css/animate.css" type='text/css' rel="stylesheet">

	<title>Edit</title>
</head>
<body class='bg-gray'>

<div class='header'>
<center><img src='images/admin.png' alt="AdminLogo" id="adminlogo"><br><center id='head'>ADMIN DASHBOARD</center>

</center>

</div>

<div class='navbar'>

<ul align="center">
<li><a href="admindash.php"  >Arxiki</a></li>
<li><a href="users.php" >USERS</a></li>
<li><a href="movie.php" >Tainies</a></li>
<li><a href="theatres.php" class="active">Aithouses</a></li>
<li><a href="timings.php" >Wres</a></li>
<li><b class='logout' style="padding-top:14px;padding-right:2px;"><?php echo strtoupper("USER:".$_SESSION['user']);?></b></li>
<li><a href="logout.php" class='logout'>LOGOUT</a></li>
</ul>

</div>

<div class='content'>
<?php

include("databaseconnect.php");

?>

<div id="edit" style="display:block;"  class="pop animated jackInTheBox">
  <div class="pop-content" style="padding:32px">
  <h1 align='center'>EDIT</h1><br>
    <span class="close" onclick="location.href='theatres.php'">&times;</span>	
	<?php
    if(isset($_REQUEST['eid']))
    {
    $id=$_REQUEST['eid'];
    $qry1="SELECT Theatre_Name, Movie_Name, Location, time1, time2 FROM theatres WHERE Theatre_id=?";
    $stmt = mysqli_prepare($conn, $qry1);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row1 = mysqli_fetch_assoc($result);
    ?>
      <form method="post">
          <table align='center'>
              <tr>
                  <td><b>THEATRE-</b></td>
                  <td><input type='text' name='theatre' value="<?php echo $row1['Theatre_Name']?>" required></td>
              </tr>
              <tr>
                  <td><b>MOVIE-</b></td>
                  <td><input type='text' name='movie' value="<?php echo $row1['Movie_Name']?>" required></td>
              </tr>
              <tr>
                  <td><b>LOCATION-</b></td>
                  <td><input type='text' name='location' value="<?php echo $row1['Location']?>" required></td>
              </tr>
              <tr>
                  <td><b>TIME 1-</b></td>
                  <td><input type='time' name='time1' value="<?php echo $row1['time1']?>" ></td>
                </tr>
            <tr>
                <td><b>TIME 2-</b></td>
                <td><input type='time' name='time2' value="<?php echo $row1['time2']?>" ></td>
            </tr>
            <tr>
                <td><input type='submit' name='submit' style="margin-left:75%;" value="SUBMIT"></td>
            </tr>
        </table>
    </form>
    <?php
    }
    if(isset($_POST['submit'])) {
        $movie = mysqli_real_escape_string($conn, $_POST['movie']);
        $theatre = mysqli_real_escape_string($conn, $_POST['theatre']);
        $location = mysqli_real_escape_string($conn, $_POST['location']);
        $time1 = mysqli_real_escape_string($conn, $_POST['time1']);
        $time2 = mysqli_real_escape_string($conn, $_POST['time2']);

        $update_query = "UPDATE theatres SET Theatre_Name = ?, Movie_Name = ?, Location = ?, time1 = ?, time2 = ? WHERE Theatre_id = ?";
    $stmt = mysqli_prepare($conn, $update_query);
    mysqli_stmt_bind_param($stmt, "sssssi", $theatre, $movie, $location, $time1, $time2, $id);
    if(mysqli_stmt_execute($stmt)){
        $_SESSION['updated'] = true;
        header('location:theatres.php');
    } else {
        echo "<br><div align='center'><b>ERROR IN UPDATING.</b></div><br>";
    }
}
mysqli_stmt_close($stmt);
mysqli_close($conn);

?>
  </div>
</div>
</div>
</body>
</html>


      