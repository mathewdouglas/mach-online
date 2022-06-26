<?php
	// session_start();
	// //Check if user has cookie
	// if (isset ($_COOKIE["ODFU"])) {
	// 	//If so, set session and go to sign in
	// 	$_SESSION["id"] = $_COOKIE["ODFU"];
	// 	$_SESSION["retry"] = 0;
	// 	$_SESSION["time"] = time();
	// 	header( "Location: homepage.php");
	// }
	// else {
	// 	//If not, go to registration.
	// 	header( "Location: login.html");
	// }
	header( "Location: homepage.php");
?>