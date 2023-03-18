<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('location:admin_login_page.php');
    exit;
}

$updated2 = $_SESSION['updated2'] ?? false;
$_SESSION['updated2'] = null;
?>
<!DOCTYPE html>
<html>
<head>
    <link href="css/dashstyle.css" type='text/css' rel="stylesheet">
    <link href="css/animate.css" type='text/css' rel="stylesheet">
    <title>Dashboard</title>
</head>
<body>
<div class='header'>
    <center>
        <img src='images/admin.png' alt="AdminLogo" id="adminlogo">
        <br>
        <center id='head'>ADMIN DASHBOARD</center>
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
    <?php if ($updated2) : ?>
        <br>
        <div align="center">
            <b>DETAILS UPDATED.</b>
        </div>
        <br>
    <?php endif; ?>
    <div id='insert' class='pop animated jackInTheBox'>
        <div class="pop-content" style="padding:32px">
            <h1 align='center'>CREATE</h1>
            <br>
            <span class="close" onclick="document.getElementById('insert').style.display='none'">&times;</span>
            <form action="theatres.php" method="post">
                <table align='center' >
                    <tr>
                        <td><b>Aithousa-</b></td>
                        <td><input type="text" name="aithousa" required></td>
                    </tr>
                    <tr>
                        <td><b>Tainia-</b></td>
                        <td><input type="text" name="tainia" required></td>
                    </tr>
                    <tr>
                        <td><b>Topothesia-</b></td>
                        <td><input type="text" name="topothesia" required></td>
                    </tr>
			<tr>
			<td><b>Screening 1-</b></td>
			<td><input type="time" name="Screening1" ></td>
			</tr>
			<tr>
			<td><b>Screeing 2-</b></td>
			<td><input type="time" name="Screening2" ></td>
			</tr>
			<tr><td><input type="submit" style="margin-left:90%" name="submit" value="SAVE"></td></tr>
			
		
	</table>
	</form>

</div>
</div>
<?php
//εδώ θα πρέπει να γίνει έλεγχος για το αν έχει γίνει submit η φόρμα
//και να γίνει insert στη βάση
//αν υπάρχει ήδη το θέατρο με την ταινία σε αυτό το τοπίο
//τότε να εμφανίζεται μήνυμα ότι υπάρχει ήδη και να μην γίνεται insert
//αλλιώς να γίνει insert
//και να γίνει εμφάνιση μηνύματος ότι έγινε insert
//και να γίνει και εμφάνιση του πίνακα με τα θέατρα
include('databaseconnect.php');


// Use a function to select data from the database
function selectData($conn) {
    // Use a prepared statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT Theatre_id, Theatre_Name, Movie_Name, Location, time1, time2 FROM theatres");
    $stmt->execute();
    $result = $stmt->get_result();
    return $result;
}

// Use a function to delete data from the database
function deleteData($conn, $theatre_id) {
    // Use a prepared statement to prevent SQL injection
    $stmt = $conn->prepare("DELETE FROM theatres WHERE Theatre_id = ?");
    $stmt->bind_param("i", $theatre_id);
    $stmt->execute();
}

// Use a function to insert data into the database
function insertData($conn, $theatre, $movie, $location, $time1, $time2) {
    // Use a prepared statement to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO theatres (Theatre_Name, Movie_Name, Location, time1, time2) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $theatre, $movie, $location, $time1, $time2);
    $stmt->execute();
}

// Use a function to update data in the database
function updateData($conn, $theatre_id, $theatre, $movie, $location, $time1, $time2) {
    // Use a prepared statement to prevent SQL injection
    $stmt = $conn->prepare("UPDATE theatres SET Theatre_Name = ?, Movie_Name = ?, Location = ?, time1 = ?, time2 = ? WHERE Theatre_id = ?");
    $stmt->bind_param("sssssi", $theatre, $movie, $location, $time1, $time2, $theatre_id);
    $stmt->execute();
}

// Check if delete request is made
if (isset($_REQUEST['delid'])) {
    $delid = $_REQUEST['delid'];
    deleteData($conn, $delid);
    echo "<br><div align='center'> <b>DELETED.</b></div><br>";
}

// Check if insert request is made
if (isset($_POST['submit'])) {
    $movie = $_POST['movie_name'];
    $theatre = $_POST['theatre'];
    $location_theatre = $_POST['location'];
    $screening1 = $_POST['time1'];
    $screening2 = $_POST['time2'];

    // Use a prepared statement to check for duplicate data
    $stmt = $conn->prepare("SELECT Theatre_Name, Movie_Name, Location, time1, time2 FROM theatres WHERE Theatre_Name = ? AND Movie_Name = ? AND Location = ?");
    $stmt->bind_param("sss", $theatre, $movie, $location_theatre);
    $stmt->execute();
    $duplicate_result = $stmt->get_result();
    $duplicate_count = mysqli_num_rows($duplicate_result);
    if ($duplicate_count > 0) {
        echo "<br><div align='center'> <b>SHOWS ALREADY PRESENT.PLEASE UPDATE IF NEEDED.</b></div><br>";
    } else {
        insertData($conn, $theatre, $movie, $location_theatre, $screening1, $screening2);
        echo "<br><div align='center'> <b>NEW RECORD CREATED SUCCESSFULLY.</b></div><br>";
    }
}

// Use a function to select data
$result = selectData($conn);
$num_rows = mysqli_num_rows($result);

// Use the ternary operator to check if there are any rows returned from the query
echo "<br><center><b>SHOWING " . ($num_rows > 0 ? $num_rows : "0") . " RESULTS.</b></center><br>";

if ($num_rows == 0) {
    echo "<center><button class='create animated fadeIn' onclick='document.getElementById(\"insert\").style.display = \"block\"'> INSERT </button></center>";
} else {
?>
    <table align='center' class="animated fadeIn" border='1'>
        <tr>
            <center>
                <button class='create animated fadeIn' onclick='document.getElementById("insert").style.display = "block"'> INSERT </button>
            </center>
        </tr>
        <tr>
            <th>Sr.No</th>
            <th>Cinema</th>
            <th>Tainia</th>
            <th>Topothesia</th>
            <th>Proboli 1</th>
            <th>Proboli 2</th>
            <th>Diagrafi</th>
            <th>Edit</th>
        </tr>
        <?php
        for ($i = 0; $i < $num_rows; $i++) {
        $row = mysqli_fetch_assoc($result);
        ?>
        <tr>
            <td><?php echo $i + 1 ?></td>
            <td><?php echo $row["Theatre_Name"] ?></td>
            <td><?php echo $row["Movie_Name"] ?></td>
            <td><?php echo $row["Location"] ?></td>
            <td><?php echo $row["time1"] ?></td>
            <td><?php echo $row["time2"] ?></td>
            <td>
                <center>
                    <a href="?delid=<?php echo $row["Theatre_id"] ?>" style="color:white">
                        <img style="height:20px;width:20px" src="images/delete.png">
                    </a>
                </center>
            </td>
            <td>
                <a href="theatre_edit.php?eid=<?php echo $row["Theatre_id"] ?>" style="color:white">
                    <img style="height:20px;width:20px" src="images/edit.png">
                </a>
            </td>
        </tr>
            <?php
        }
        ?>
    </table>
    <?php
}
?>

</div>


</body>
</html>


