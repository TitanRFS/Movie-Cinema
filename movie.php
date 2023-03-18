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


	<title>Dashboard</title>


</head>
<body class='bg-gray'>

<div class='header'>
<center><img src='images/admin.png' alt="AdminLogo" id="adminlogo"><br><center id='head' class="animated flipInX">ADMIN DASHBOARD</center>

</center>

</div>

<div class='navbar'>

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

</div>



<div class='content'>
<?php
$update = 'updated1';
if($_SESSION[ $update ]==true)
	{
		?>
			<br><div align="center"> <?php echo "<b>DETAILS UPDATED.</b>";?></div><br>
		<?php
		$_SESSION[$update]=NULL;
	}
?>
<<div id="insert">
        <div class="pop-content" style="padding:32px">
            <h1 align="center">CREATE</h1><br>

            <span class="close" onclick="document.getElementById('insert').style.display='none'">&times;</span>

            <form action="movie.php" method="post" enctype="multipart/form-data">
                <table align="center">
                    <tr>
                        <td><b>MOVIE-</b></td>
                        <td><input type="text" name="movie_name" required></td>
                    </tr>
                    <tr>
                        <td><b>ACTOR-</b></td>
                        <td><input type="text" name="actor" required></td>
                    </tr>
                    <tr>
                        <td><b>ACTRESS-</b></td>
                        <td><input type="text" name="actress" required></td>
                    </tr>
                    <tr>
                        <td><b>DIRECTOR-</b></td>
                        <td><input type="text" name="director" required></td>
                    </tr>
                    <tr>
                        <td><b>Release date-</b></td>
                        <td><input type="date" name="releasedate" required></td>
                    </tr>
                    <tr>
                        <td><b>RUNTIME-</b></td>
                        <td><input type="text" name="runtime" placeholder="2hr 35mins" required></td>
                    </tr>
                    <tr>
                        <td><b>GENRE-</b></td>
                        <td><input type="text" name="type" required></td>
			</tr>
			<tr>
			<td><b>DESCRIPTION-</b></td>
			<td><textarea name='info' placeholder="Write Something.." rows="4" cols="50" required ></textarea></td>
			</tr>
			<tr>
			<td><b>POSTER-</b></td>
			<td><input type="file" name="poster[]"></td>
			</tr>
			<tr>
			<td><b>ACTOR IMAGE-</b></td>
			<td><input type="file" name="poster[]"></td>
			</tr>
			<tr>
			<td><b>ACTRESS IMAGE-</b></td>
			<td><input type="file" name="poster[]"></td>
			</tr>
			<tr>
			<td><b>DIRECTOR IMAGE-</b></td>
			<td><input type="file" name="poster[]"></td>
			</tr>
			<tr><td><input type="submit" style="margin-left:90%" name="submit" value="SAVE"></td></tr>
	</table>
	</form>
</div>
</div>
<?php
	include('databaseconnect.php');
	if(isset($_POST['submit'])) {

		$movie=$_POST['movie_name'];
		$actor=$_POST['actor'];
		$actress=$_POST['actress'];
		$dir=$_POST['director'];
		$rdate=$_POST['rdate'];
		$runtime=$_POST['runtime'];
		$type=$_POST['type'];
		$info=$_POST['info'];



		//Εδώ ψάχνει στο database για το movie poster
		$file=$_FILES["poster"]["name"];

		$query_duplicate_1="Select Movie_Name,Actor,Actress,Release_date,Director from movies where Movie_Name='$movie' AND Actor='$actor' AND Actress='$actress' AND
		Release_date='$rdate' AND Director='$dir'";

		$result_dupli=mysqli_query($conn,$query_duplicate_1);
		$duplicate_count=mysqli_num_rows($result_dupli);
		if ($duplicate_count>0)
		{?>
			<br><div align="center"> <?php echo "<b>MOVIE DETAILS ALREADY PRESENT.</b>";?></div><br>

			<?php
		}
		else {
			if($file[0]!=NULL && $file[1]!=NULL && $file[2]!=NULL && $file[3]!=NULL) {
				$temp=$_FILES["poster"]["tmp_name"];
				$path=array("".$file[0],"".$file[1],"".$file[2],"");
				$file1=explode(".",$file[0]);
				$file2=explode(".",$file[1]);
				$file1_name=array($file1[0],$file2[0]);
				$file_ext=array($file1[1],$file2[1]);
				$allowed_ext=array('jpg','jpeg','png','gif');
				if(in_array($file_ext[0],$allowed_ext)&& in_array($file_ext[1],$allowed_ext) && in_array($file_ext[2],$allowed_ext) && in_array($file_ext[3],$allowed_ext))
				{
					for($i=0;$i<4;$i++)
					{
						move_uploaded_file($temp[$i],$path[$i]);
					}


					$query="INSERT INTO movies (Movie_Name,Actor,Actress,Release_date,Director,poster,RunTime,type,ActorImg,ActressImg) 
					VALUES ('$movie','$actor','$actress','$rdate','$dir','$file[0]','$runtime','$type','$file[1]','$file[2]'";


					if (mysqli_query($conn, $query))
					{?>
					<br><div align="center"> <?php echo "<b>NEW RECORD CREATED SUCCESSFULLY.</b>";?></div><br>

					<?php }
					else {
					?>
					<br><div align="center"> <?php echo "<b>ERROR IN INSERTION.</b><br>".$query . "<br>" . mysqli_error($conn);?></div><br>
					<?php
					}
				}

			}
				else {
					$query="INSERT INTO movies (Movie_Name,Actor,Actress,Release_date,Director,RunTime,type,Description) 
					VALUES ('$movie','$actor','$actress','$rdate','$dir','$runtime','$type','$info')";
					if (mysqli_query($conn, $query)) {
						?>
						<br><div align="center"> <?php echo "<b>NEW MOVIE  SUCCESSFULLY CREATED.</b>";?></div><br>
						<div align="center"> <?php echo "<b>UPLOAD FAILED(jpg,jpeg,png,gif EXTENSIONS ONLY)</b>";?></div><br>
						<?php
					}
					else {
						?>
						<div align="center"> <?php echo "<b>ERROR IN INSERTION.</b><br>".$query . "<br>" . mysqli_error($conn);?></div>
						<?php
					}
                }}
		mysqli_close($conn);
	}
?>
<?php
include("databaseconnect.php");
if(isset($_REQUEST['delid'])) {
	$delid=$_REQUEST['delid'];
	$unlink_media_query="select poster from movies where Movie_id='$delid'";
	$result2=mysqli_query($conn,$unlink_media_query);
	$row_count2=mysqli_num_rows($result2);
	$row2=mysqli_fetch_assoc($result2);
	if($row2['poster']==''){mysqli_query($conn,"delete from movies where Movie_id='$delid'");}
	else {
		$unlink_media="Image/".$row2['poster'];
		unlink("$unlink_media");
		mysqli_query($conn,"delete from movies where Movie_id='$delid'");}
	?>
	<br><div align="center"> <?php echo "<b>DELETED.</b>";?></div><br>
	<?php
}
$query="select Movie_Name,Movie_id,Actor,Actress,Release_date,Director,poster,RunTime,type FROM movies";
$result = mysqli_query($conn,$query);
$row_count=mysqli_num_rows($result);

if($row_count==0){echo  "<br><center><b>SHOWING 0 RESULTS.<b></center>";
?><center><button class='create animated fadeInUp' onclick="document.getElementById('insert').style.display='block'"> INSERT </button></center><?php
}
else{
	echo  "<br><center><b>SHOWING ".$row_count." RESULTS.<b></center><br>";
	?>
<table align='center' class="animated fadeInUp"  border='1'>
<tr><center><button class='create animated fadeInUp' onclick="document.getElementById('insert').style.display='block'"> INSERT </button></center></tr>
<tr>
<th>Sr.No</th>
<th>MOVIE</th>
<th>ACTOR</th>
<th>ACTRESS</th>
<th>RELEASE DATE</th>
<th>DIRECTOR</th>
<th>RUNTIME</th>
<th>GENRE</th>
<th>POSTER</th>
<th>DELETE</th>
<th>EDIT</th>
</tr>
<?php
for($i=0;$i<$row_count;$i++) {
	$row=mysqli_fetch_assoc($result);
	?>
	<tr>
	<td><?php echo $i+1 ?></td>
	<td><?php echo $row["Movie_Name"] ?></td>
	<td><?php echo $row["Actor"] ?></td>
	<td><?php echo $row["Actress"] ?></td>
	<td><?php echo $row["Release_date"] ?></td>
	<td><?php echo $row["Director"] ?></td>
	<td><?php echo $row["RunTime"] ?></td>
	<td><?php echo $row["type"] ?></td>
	<td><img class="myImg" style="cursor: pointer;" onclick="imgdisp(this.src)" alt="No Image" src="<?php echo $row["poster"] ?>" height="50px" width='50px' ></td>

	<td><center><a href="movie.php?delid=<?php echo $row["Movie_id"] ?>" style="color:white"><img style="height:20px;width:20px" src="images/delete.png">
	</a></center></td>

	<td><a href="edit.php?eid=<?php echo $row["Movie_id"] ?>" style="color:white"><img style="height:20px;width:20px" src="images/edit.png">
	</a></td>

	</tr>
	<?php
}
}

?>



</div>

<div id="myModal" class="modal animated zoomIn">
  <span class="close" style="color:white;top:20px;right: 35px;" onclick="document.getElementById('myModal').style.display='none'">&times;</span>
  <img class="modal-content" id="img01">

</div >


<script>
var modal = document.getElementById('myModal');
var modalImg = document.getElementById("img01");

function imgdisp(img){
    modal.style.display = "block";
    modalImg.src = img;
}

</script>


</body>
</html>









