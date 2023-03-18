<?php
session_start();
?>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Booking</title>


  <!-- Link Swiper's CSS -->
  <link rel="stylesheet" href="css/swiper.min.css">



<style>
 
 * {
	margin: 0px;
	padding: 0px;
	font-family: arial-black;
}
select:required:invalid {
  color: gray;
}
option[value=""][disabled] {
  display: none;
}
option {
  color: black;
}

.location{
	height: 40px;
	width: 100%px;
	background:  #ffffff;
	color: #000000;
	display: block;

}


.location1{
	width: 100%;
	height:auto;
	margin-top: 10px;
	display: block;
	
}

.location2{
	height: 40px;
	width: 100%;
	background:  #ffffff;
	color: #000000;
	display:block;
	margin-top: 10px;

}
.swiper-container {
      width: 100%;
      height: 300px;
    }

.swiper-slide {
      text-align: center;
      font-size: 18px;
      background:#fff;

      /* Center slide text vertically */
      display: -webkit-box;
      display: -ms-flexbox;
      display: -webkit-flex;
      display: flex;
      -webkit-box-pack: center;
      -ms-flex-pack: center;
      -webkit-justify-content: center;
      justify-content: center;
      -webkit-box-align: center;
      -ms-flex-align: center;
      -webkit-align-items: center;
      align-items: center;
}

input[type="submit"]{
	border: 1px;
	background: #fb2525;
	outline: none;
	width:120px;
	height: 30px;
	color: #fff;
	border-radius:15px;
	
}

input[type="button"]{
	border: 1px;
	background: #fb2525;
	outline: none;
	width:120px;
	height: 30px;
	color: #fff;
	border-radius:15px;
	
}
.h5 a{
	text-decoration: none;
	color: white;
}

.sign{
		border-radius:6px;
		background-color:#d21919;
		border: none;
		color: white;
		padding: 8px 10px;
		text-align: center;
		text-decoration: none;
		display: inline-block;
		font-size: 16px;
		cursor: pointer;
		float:right;
		}
		
.sign:hover {
    background-color:#ECEFF1; 
    color: black;
}
.navbar li a:hover {
     background-color: black;
		color: white;
	
}

.navbar ul 
{	
	height:50px;
    list-style-type: none;
    overflow: hidden;
    background-color: #ffffff;
}

.navbar li a {
  float: left;
  display: block;
  color:white;
  text-align: center;
  padding: 12px 16px;
  text-decoration: none;
  font-size: 22px;
}

</style>
</head>
<body class="animated fadeIn">


	<?php
	//Ο κώδικας αυτός είναι για την εμφάνιση των ταινιών στην αρχική σελίδα
	// μαζί με τα στοιχεία τους poster, χρόνος, κατηγορία
		include('databaseconnect.php');
		$count=0;
		$loc="null";
		$mov="null";
	
		if( isset($_POST['loc']) && isset($_POST['mov'])){
			$loc=$_POST['loc'];
			$mov=$_POST['mov'];
			$_SESSION['movie_n']=$mov;
			$_SESSION['location']=$loc;
		}
		else{
			echo "";
		}
		$query = "select * from movies";
		$run = mysqli_query($conn,$query);
	
		
		$query1 = "SELECT DISTINCT Location FROM theatres;";
		$run1 = mysqli_query($conn,$query1);

		$query2 = "SELECT Theatre_name, time1, time2 FROM theatres where Location='$loc' and Movie_Name='$mov';";
		$run2 = mysqli_query($conn,$query2);

		
	?>

<div class='navbar'>
<ul>
<li style="margin:0px;padding-left:5px;padding-right:2px;padding-top:0px;float:left;"><a href="userindex.php"><img src="images/back.png" height="30px" width="30px"></a> </li>
<li><img src="images/logo.png" style="padding-left:5px;padding-right:10px;padding-top:10px;float:left;height:35px;width:250px"></li>


<li ><a class="" href="userindex.php">Home</a></li>

<?php if(isset($_SESSION['name']))
	{?>
<li style="padding-left:50px;padding-right:20px;padding-top:6px;"><button class='sign' onclick="document.location.href='userlogout.php'">Logout</button></li>
<?php }else{?>
<li style="padding-left:50px;padding-right:20px;padding-top:6px;"><button class='sign'  onclick="document.location.href='index.php'">Sign In</button></li>
<?php }?>
</ul>
</div>

<?php 
include('databaseconnect.php');
		
$query1 = "SELECT * from movies";
		
$result = mysqli_query($conn,$query1);


$row_count=mysqli_num_rows($result);
?>

	  <!-- Swiper -->
<div class="swiper-container">
    <div class="swiper-wrapper">
	<?php	
	for($i=0;$i<$row_count;$i++)
	{
	$row1 = mysqli_fetch_array($result);
	?>
	
      <div class="swiper-slide"><img src="<?php echo $row1['poster'];?>" height="200px" width="200px"></div>
     <?php
	}
	 ?>

    </div>
    <!-- Add Pagination -->
    <div class="swiper-pagination"></div>
</div>
  
  

  <!-- Swiper JS -->
  <script src="js/swiper.min.js"></script>

  <!-- Initialize Swiper -->
  <script>
    var swiper = new Swiper('.swiper-container', {
	slidesPerView: 5,
      spaceBetween: 10,
     
      autoplay: {
        delay: 2000,
        disableOnInteraction: false,
      },
      pagination: {
        el: '.swiper-pagination',
        clickable: true,
      },
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      },
    });
  </script>


<center>
<form  method="post" >

	<table width="700px" style="margin-bottom: 20px; margin-top: 20px "  height="50px">
		<tr>
		
			<td width="50%">

				<select  required  style=" height:30px; width:100% " name="mov">
					<option value="" disabled selected>Select Movie</option>	
					<?php
					while($data = mysqli_fetch_array($run))
					{
					if($data['Release_date'])
					{						
					?>
					<option value="<?php echo $data['Movie_Name']; ?>"> <?php echo $data['Movie_Name']; ?> </option>
					<?php
					}
					}
					?>
				</select>

			</td>
	
			<td width="50%">
				<select  required  style="width:100%; height:30px " name="loc">
					<option value="" disabled selected>Select Cinema</option>
					
					<?php
					
					while($data1 = mysqli_fetch_array($run1))
					{	
					?>
					<option value="<?php echo $data1["Location"]; ?>"> <?php echo $data1["Location"]; ?> </option>
					<?php
					}
					?>
				</select>

			</td>
	
		</tr>
	</table>
	<input type="submit" name="search_show" value="Search" />
</form>
</center>
<br>
<hr>


<?php
if(isset($_POST['search_show']))
{
?>
<br>
<div id="lo" class="location" ><center><h4 style="padding-top:10px;"><center><?php echo "Location : ".$_POST["loc"];?></center></h4></div>
<div id="lo2" class="location2" ><center><h4 style="padding-top:10px;"><center><?php echo "Movie : ".$_POST["mov"];?></center></h4></div>
<center>
<div id="lo1" class="location1">
<form method="post" >
<table width="100%"  border="1" height="200px">	
						<?php
					while($data2 = mysqli_fetch_array($run2)) {
					?>
						<tr>
							<td>
								<input type="radio" name="theatre" value="<?php echo $data2["Theatre_name"];?>"  /> <?php echo $data2["Theatre_name"];?>
							</td>
							<?php
							if(!empty($data2["time1"]))
							{
							?>
							<td>
								<input type="radio" name="time" value="<?php echo $data2["time1"];?>"  /> <?php echo $data2["time1"];?>
							</td>
							<?php
							}
							 if(!empty($data2["time2"]))
							{
							?>

							<td>
								<input type="radio" name="time" value="<?php echo $data2["time2"];?>"  /> <?php echo $data2["time2"];?>
							</td>
						</tr>
					<?php
					}
					?>

</table>

<input type="submit" name="submit3" value="Next" style="margin-bottom:30px; margin-top: 10px;"  />

</center>
</div>
</form>

<?php }?>
   
</body>
</html>

<?php
$_SESSION['theatre_n']=null;
$_SESSION['timer']=null;
$theatre=null;
$wra=null;
if(isset($_POST['submit3']))
{
	if(!isset($_SESSION['name']))
	{
		?>
		<script>
		alert("Please Login to book tickets")
		window.open('index.php','_self');
		</script>
		<?php
	}
	
	else if( isset($_POST['theatre']) && isset($_POST['time']) ){
		include ('databaseconnect.php');
		$theatre=$_POST['theatre'];
		$wra=$_POST['time'];
		$_SESSION['theatre_n']=$theatre;
		$_SESSION['timer']=$wra;
		?>

		<?php
	       $query="INSERT INTO bookings ('user','movie','theatre','time','location') VALUES ('".$_SESSION['name']."','".$_POST['tain']."','".$_POST['theatre']."','".$_POST['time']."','".$_POST['loc']."')";
            $run=mysqli_query($conn,$query);
					if (mysqli_query($conn, $query))
					{?>
					<br><div align="center"> <?php echo "<b>NEW RECORD CREATED SUCCESSFULLY.</b>";?></div><br>

					<?php
					}
					else
					{
					?>
					<br><div align="center"> <?php echo "<b>ERROR IN INSERTION.</b><br>".$query . "<br>" . mysqli_error($conn);?></div><br>
					<?php
					}
	}
	else
	{
		?>
		<script>
		alert("Please Select Theatre and Time");
		</script>
		<?php	
	}
		
          

}

}
?>