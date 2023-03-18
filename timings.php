<?php 
	session_start();
    //Αυτός ο κώδικας είναι για την εισαγωγή των ωρών στην βάση δεδομένων
// και την εμφάνιση τους. Πρέπει να τρέξει μόνο μία φορά για να εισαχθούν όλες οι ώρες
	if($_SESSION['user']==true){
		echo "";
	}
	else{
		header('location:admin_login_page.php');
	}
		
	
?>

<html  >
<head>
	<link href="css/dashstyle.css" type='text/css' rel="stylesheet">
	<link href="css/animate.css" type='text/css' rel="stylesheet">


	<title>Admin Page</title>

	
</head>
<body class='bg-gray'>

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
if($_SESSION['updated3']==true){
		?>
			<br><div align="center"> <?php echo "<b>DETAILS UPDATED.</b>";?></div><br>
		<?php
		$_SESSION['updated3']=NULL;
		
	}
?>
<div id='insert' class='pop animated jackInTheBox'>
<div class="pop-content" style="padding:32px">
  <h1 align='center'>CREATE</h1><br>

  <span class="close"  onclick="document.getElementById('insert').style.display='none'">&times;</span>
  
	<form action="timings.php" method="post">
	<table align='center' >
	
			<tr>
			<td><b>SHOWTIME-</b></td>
			<td><input type="time" name="time" required></td>
			</tr>
			<tr>
			<td><b>THEATRE-</b></td>
			<td><input type="text" name="theatre"  required></td>
			</tr>
			
			<tr><td><input type="submit" style="margin-left:90%" name="submit" value="SAVE"></td></tr>
			
		
	</table>
	</form>

</div>
</div>
    <?php
    include 'databaseconnect.php';

    if (isset($_REQUEST['delid'])) {
        $delid = $_REQUEST['delid'];
        $query = "DELETE FROM timings WHERE id = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 'i', $delid);
        if (mysqli_stmt_execute($stmt)) {
            echo "<div align='center'><b>DELETED.</b></div>";
        } else {
            echo "<div align='center'><b>Error: " . mysqli_error($conn) . "</b></div>";
        }
    }

    if (isset($_POST['submit'])) {
        $theatre = $_POST['theatre'] ?? '';
        $time = $_POST['time'] ?? '';

        $query = "SELECT id FROM timings WHERE Theatre_Name = ? AND showtime = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 'ss', $theatre, $time);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if (mysqli_num_rows($result) > 0) {
            echo "<div align='center'><b>SHOWS ALREADY PRESENT.PLEASE UPDATE IF NEEDED.</b></div>";
        } else {
            $query = "INSERT INTO timings (showtime, Theatre_Name) VALUES (?, ?)";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, 'ss', $time, $theatre);
            if (mysqli_stmt_execute($stmt)) {
                echo "<div align='center'><b>NEW RECORD CREATED SUCCESSFULLY.</b></div>";
            } else {
                echo "<div align='center'><b>Error: " . mysqli_error($conn) . "</b></div>";
            }
        }
        mysqli_close($conn);
    }
    ?>

<?php
//εδώ εμφανίζει τα δεδομένα του πίνακα
// και μετά με την css δημιουργεί ένα fadeinup animation
include('databaseconnect.php');
$qry="Select id,showtime ,Theatre_Name   from timings";
$result = mysqli_query($conn,$qry);
$row_count=mysqli_num_rows($result);

if($row_count==0){echo  "<br><center><b>SHOWING 0 RESULTS.<b></center>";
?><center><button class='create animated fadeInUp' onclick="document.getElementById('insert').style.display='block'"> INSERT </button></center><?php
}
else{
	echo  "<br><center><b>SHOWING ".$row_count." RESULTS.<b></center><br>";
	
?>
<table align='center' border='1'>

<tr><center><button class='create ' onclick="document.getElementById('insert').style.display='block'"> INSERT </button></center></tr>
<tr>
<th>Serial.No</th>
<th>Wra Probolhs</th>
<th>Cinema</th>
<th>Delete</th>
<th>Edit</th>
</tr>

    <?php
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            ?>
            <tr>
                <td><?php echo $row["id"] ?></td>
                <td><?php echo $row["showtime"] ?></td>
                <td><?php echo $row["Theatre_Name"] ?></td>

                <td>
                    <center>
                        <a href="?delid=<?php echo $row["id"] ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this record?');">Delete</a>
                    </center>
                </td>

                <td>
                    <a href="edit_timings.php?eid=<?php echo $row["id"] ?>" class="btn btn-warning">Edit</a>
                </td>

            </tr>
            <?php
        }
    }}
    ?>

</div>


</body>
</html>


