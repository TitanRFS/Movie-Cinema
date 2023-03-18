<html>

<head>
	<link href="css/animate.css" type='text/css' rel="stylesheet">

	<title>Details</title>
</head>

<style>
    .close {
        position:relative;
        top: 0px;
        right: 35px;
        color: black;
        font-size: 60px;
        font-weight: bold;
        transition: 0.3s;
    }
    .book{

        border-radius:6px;
        background-color:#009688;
        border: none;
        color: white;
        padding: 15px 32px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        margin: 4px 2px;
        cursor: pointer;

    }

    .book:hover {
        background-color:#263238 ;
        color: white;
    }



    .close:hover,
    .close:focus {
        color: #bbb;
        text-decoration: none;
        cursor: pointer;
    }

    .content{
        height:auto;
    }

    .pop-content{
        background-color:#ECEFF1;
        padding-top: 20px;
        padding-bottom:20px;
        border: 1px solid #888;
        width: 100%;}

    .pop{z-index:1;display:none;position:absolute;left:0;top:0;width:100%;height:100%;overflow:auto;background-color: rgb(0,0,0); /* Fallback color */
        background-color: rgba(0,0,0,0.9); /* Black w/ opacity */}



</style>

<body>

	<?php
	session_start();

	include("databaseconnect.php");
	if (isset($_REQUEST['id'])) {

		$eid = $_REQUEST['id'];
		$query1 = " select * FROM movies where Movie_id='$eid'";
		$result1 = mysqli_query($conn, $query1);
		$row1 = mysqli_fetch_assoc($result1);
	?>
		<div class='content'>
			<div style="display:block;" class="pop animated fadeIn">
				<div class="pop-content" style="padding:32px">

					<span class="close" onclick="location.href='userindex.php'">&times;</span>

					<table width="auto" height="1200px">
						<tr>
							<td style="position:absolute;top:40px;left:40px">
								<center>
									<h2><?php echo $row1['Movie_Name']; ?></h2>
								</center>

								<center>
									<img height="400px" width="340px" src="<?php echo $row1['poster'] ?>">
								</center>

								<center>
									<p>RunTime : <?php echo $row1['RunTime']; ?> </p>
									<p>ReleaseDate : <?php echo $row1['Release_date']; ?></p>
									<p>Type : <?php echo $row1['type']; ?></p>
								</center>
							</td>
						</tr>
						<tr>
							<h2 style="position:absolute;top:620px;left:80px;">CAST</h2>
							<td style="position:absolute;top:670px;left:80px">
								<center>
									<p>ACTOR</p>
									<img src="<?php echo $row1['ActorImg'] ?>" height="220px" width="150px" style="border-radius: 10px" />
									<h5> <?php echo $row1['Actor']; ?></h5>
								</center>
							</td>
							<td style="position:absolute;top:670px;left:380px">
								<center>
									<p>ACTRESS</p>
									<img src="<?php echo $row1['ActressImg'] ?>" height="220px" width="150px" style="border-radius: 10px" />
									<h5> <?php echo $row1['Actress']; ?></h5>
								</center>
							</td>

							<td style="position:absolute;top:670px;left:680px">
								<center>
									<p>DIRECTOR</p>
									<h5><?php echo $row1['Director']; ?></h5>
								</center>
							</td>
						</tr>
						<tr>
							<h2 style="position:absolute;top:1020px;left:80px">SYNOPSIS</h2>
							<td style="position:absolute;top:1080px;left:80px">
								<p><?php echo $row1['Description'] ?>

							</td>
						</tr>

						<tr>
							<td style="position:absolute;top:1200px;left:80px">

								<button class="book" onclick="location.href='ticket-booking.php'"> Book Now</button>

							</td>
						</tr>


					</table>

				</div>

			</div>

		</div>

	<?php
	}

	?>




	<?php
	include("databaseconnect.php");
	$str = 'mid';
	if (isset($_SESSION['' . $str . ''])) {

		$eid = $_SESSION[$str];
		$query1 = " select * FROM movies where Movie_id='$eid'";
		$result1 = mysqli_query($conn, $query1);
		$row1 = mysqli_fetch_assoc($result1);
	?>
		<div class='content'>
			<div style="display:block;" class="pop animated fadeIn">
				<div class="pop-content" style="padding:32px">
					<span class="close" onclick="location.href='userdashboard.php'">&times;</span>
					<table width="auto" height="1200px">
						<tr>
							<td style="position:absolute;top:40px;left:40px">
								<center>
									<h2><?php echo $row1['Movie_Name']; ?></h2>
								</center>
								<center>
									<img height="400px" width="340px" src="<?php echo $row1['poster'] ?>">
								</center>
								<center>
									<p>RunTime : <?php echo $row1['RunTime']; ?> </p>
									<p>ReleaseDate : <?php echo $row1['Release_date']; ?></p>
									<p>Type : <?php echo $row1['type']; ?></p>
								</center>
							</td>
						</tr>
						<tr>
							<h2 style="position:absolute;top:620px;left:80px;">CAST</h2>
							<td style="position:absolute;top:670px;left:80px">
								<center>
									<p>ACTOR</p>
									<img src="<?php echo $row1['ActorImg'] ?>" height="220px" width="150px" style="border-radius: 10px" />
									<h5> <?php echo $row1['Actor']; ?></h5>
								</center>
							</td>
							<td style="position:absolute;top:670px;left:380px">
								<center>
									<p>ACTRESS</p>
									<img src="<?php echo $row1['ActressImg'] ?>" height="220px" width="150px" style="border-radius: 10px" />
									<h5> <?php echo $row1['Actress']; ?></h5>
								</center>
							</td>
							<td style="position:absolute;top:670px;left:680px">
								<center>
									<p>DIRECTOR</p>
									<h5><?php echo $row1['Director']; ?></h5>
								</center>
							</td>
						</tr>
						<tr>
							<h2 style="position:absolute;top:1020px;left:80px">SYNOPSIS</h2>
							<td style="position:absolute;top:1080px;left:80px">


								<p><?php echo $row1['Description'] ?></p>

							</td>
						</tr>

						<tr>
							<td style="position:absolute;top:1200px;left:80px">
								<button class="book" onclick="location.href='booking.php'"> Book Now</button>

							</td>
						</tr>


					</table>

				</div>

			</div>

		</div>

	<?php
	}
	$_SESSION[$str] = NULL;
	?>


	<?php

	if (isset($_SESSION['noid'])) {
	?>
		<div class='content'>
			<div style="display:block;" class="pop animated fadeIn">
				<div class="pop-content" style="padding:32px">

					<span class="close" onclick="location.href='userdashboard.php'">&times;</span>

					<h1>Search Results for "<?php echo $_SESSION['noid']; ?>" </h1>
					<h2>No Results Found.</h2>

				</div>

			</div>

		</div>

	<?php
	}
	$_SESSION['noid'] = NULL;

	?>



</body>

</html>