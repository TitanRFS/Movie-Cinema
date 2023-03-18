<?php
//Διαγράφει το login session και μας κάνει logout
//και μας επιστρέφει στην σελίδα admin login
	session_start();
	session_destroy();
	header('location:admin_login_page.php');
?>