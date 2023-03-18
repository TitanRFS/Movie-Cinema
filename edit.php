<?php 
	session_start();
	//ένα απλό if για να ελέγχει αν ο χρήστης είναι συνδεδεμένος
	if($_SESSION['user']==true){
		echo "";
	}
	else{
		header('location:admin_login_page.php');
	}
?>

<html>
<head>
/*Εδώ έχουμε τα css αρχεία που χρησιμοποιούμε για τον σχεδιασμό της σελίδας*/
	<link href="css/dashstyle.css" type='text/css' rel="stylesheet">
	<link href="css/animate.css" type='text/css' rel="stylesheet">

	<title>Edit</title>
</head>
<body class='bg-gray'>
<div class='header'>
<center><img src='images/admin.png' alt="AdminLogo" id="adminlogo"><br><center id='head'>ADMIN </center>

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
  <span class="close" onclick="location.href='movie.php'">&times;</span>
	
	<?php
    //Εδώ έχουμε την σύνδεση με την βάση δεδομένων
    //Επίσης έχουμε τον κώδικα που εμφανίζει τα στοιχεία της ταινίας που θέλουμε να τροποποιήσουμε
	include("databaseconnect.php");
	if(isset($_REQUEST['eid'])) {
	$eid=$_REQUEST['eid'];
	$query1=" select * FROM movies where Movie_id='$eid'";
	$apotelesma1 = mysqli_query($conn,$query1);
	$seira1=mysqli_fetch_assoc($apotelesma1);
    ?>


	<form  method="post" enctype="multipart/form-data">
	<table align='center'>
	<tr>
	<td>MOVIE-</td>
	<td><input type='text' name='movie' value="<?php echo $seira1['Movie_Name']?>" required></td>
	</tr>
	<tr>
	<td>ACTOR-</td>
	<td><input type='text' name='actor' value="<?php echo $seira1['Actor']?>" required></td>
	</tr>
	<tr>
	<td><b>ACTRESS-</b></td>
	<td><input type='text' name='actress' value="<?php echo $seira1['Actress']?>" required></td>
	</tr>
	<tr>
	<td><b>RELEASE DATE-</b></td>
	<td><input type='date' name='rdate' value="<?php echo $seira1['Release_date']?>" required></td>
	</tr>
	<tr>
	<td><b>DIRECTOR-</b></td>
	<td><input type='text' name='director' value="<?php echo $seira1['Director']?>" required></td>
	</tr>
	<tr>
	<td><b>RUNTIME-</b></td>
	<td><input type='text' name='rtime' placeholder='eg.2Hr 35Mins' value="<?php echo $seira1['RunTime']?>" required></td>
	</tr>
	<tr>
	<td><b>GENRE-</b></td>
	<td><input type='text' name='type' value="<?php echo $seira1['type']?>" required></td>
	</tr>
	<tr>
	<td><b>DESCRIPTION-</b></td>
	<td><textarea name='info' rows="4" cols="50" required><?php echo $seira1['Description']?> </textarea></td>
	</tr>
	<tr>
	<td><b>POSTER-</b></td>
	<td><input type="file" name="poster[]"  ></td>
	</tr>
	<tr>
	<td><b>ACTOR IMAGE-</b></td>
	<td><input type="file" name="poster[]" ></td>
	</tr>
	<tr>
	<td><b>ACTRESS IMAGE-</b></td>
	<td><input type="file" name="poster[]" ></td>
	</tr>
	<tr>
	<td ><input type='submit' name='submit' style="margin-left:75%;" value="SUBMIT"></td>
	</tr>
	
	</table>
	
	</form>
	<?php

    //Αυτός ο κώδικας είναι ένα σενάριο PHP που ενημερώνει μια εγγραφή
        // σε έναν πίνακα "ταινίες" σε μια βάση δεδομένων.
        // Το σενάριο ανακτά πρώτα τις τιμές διαφόρων πεδίων από μια φόρμα που
        // υποβάλλεται από τον χρήστη, όπως το όνομα της ταινίας, ο ηθοποιός, η ηθοποιός,
        // ο σκηνοθέτης, ο χρόνος εκτέλεσης, η ημερομηνία κυκλοφορίας, ο τύπος και η περιγραφή.
        // Στη συνέχεια δημιουργεί ένα ερώτημα ενημέρωσης χρησιμοποιώντας αυτές τις τιμές και το πεδίο "Movie_id",
        // το οποίο υποτίθεται ότι είναι αποθηκευμένο σε μια μεταβλητή που ονομάζεται "$eid".
        // Στη συνέχεια, το σενάριο ελέγχει για τυχόν σφάλματα κατά την εκτέλεση του ερωτήματος και,
        // εάν δεν υπάρχουν, ορίζει μια μεταβλητή περιόδου λειτουργίας "updated1" σε true.
        // Στη συνέχεια, το σενάριο ελέγχει για τυχόν αρχεία που έχουν μεταφορτωθεί
        // (προφανώς, εικόνες της αφίσας της ταινίας, του ηθοποιού και της ηθοποιού)
        // και τα μετακινεί σε έναν καθορισμένο κατάλογο και ενημερώνει τα αντίστοιχα
        // πεδία στη βάση δεδομένων με τα ονόματα των αρχείων τους. Τέλος, το σενάριο ανακατευθύνει
        // τον χρήστη πίσω στη σελίδα "movie.php".


	if( isset($_REQUEST['submit']))
	{
		$movie=$_REQUEST['movie'];
		$actor=$_REQUEST['actor'];
		$actress=$_REQUEST['actress'];
		$director=$_REQUEST['dir'];
		$runtime=$_REQUEST['rtime'];
		$rdate=$_REQUEST['rdate'];
		$type=$_REQUEST['type'];
		$info=$_POST['info'];

		$update_qry="UPDATE movies SET Movie_Name='$movie',Actor='$actor',Actress='$actress',RunTime='$runtime',Release_date='$rdate',Director='$director',type='$type',Description='$info', WHERE Movie_id='$eid'";
		if(mysqli_query($conn,$update_qry)) {
			$_SESSION['updated1']=true;
		}
		else {
			?>
			<div align="center"> <?php echo "<b>ERROR IN UPDATING PROCESS.</b><br>".$update_qry . "<br>" . mysqli_error($conn);?></div>
			<?php
		}

		$file=$_FILES["poster"]["name"];
		$temp=$_FILES["poster"]["tmp_name"];
		$path=array("Image/".$file[0],"Image/".$file[1],"Image/".$file[2],"Image/".$file[3]);
		if($file[0]!=NULL) {
			move_uploaded_file($temp[0],$path[0]);
			mysqli_query($conn,"UPDATE movies SET poster='$file[0]' WHERE Movie_id='$eid' ");
		}

		if($file[1]!=NULL) {
			move_uploaded_file($temp[1],$path[1]);
			mysqli_query($conn,"UPDATE movies SET ActorImg='$file[1]' WHERE Movie_id='$eid' ");
		}

		if($file[2]!=NULL)
		{
			move_uploaded_file($temp[2],$path[2]);
			mysqli_query($conn,"UPDATE movies SET ActressImg='$file[2]' WHERE Movie_id='$eid' ");
		}




	header('location:movie.php');
	}


	}

	?>

	</div>

</div>
</div>

</body>
</html>