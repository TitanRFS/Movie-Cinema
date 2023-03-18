<?php
// εδώ συνδέεται στην βάση
    $conn = mysqli_connect('localhost','root','','cinemaxristos');
	if($conn==false) {
		echo "Connection failed".mysqli_error();
	}
	else
	{
		echo "";	
	}
?>