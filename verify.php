<?php
    session_start();
    include "db_connection.php";

	if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
		$url = "https://";
	} else {
		$url = "http://";
	}
	
	// Append the host(domain name, ip) to the URL.   
	$url .= $_SERVER['HTTP_HOST'];
	// Append the requested resource location to the URL   
	$url .= $_SERVER['REQUEST_URI'];
	$url_components = parse_url($url);
	
	parse_str($url_components['query'], $params);
	$returnURL = $params["return"];
	$_SESSION["return"] = $returnURL;

//Remove white space, check for blank, and remove special characters
	if (($userid = trim($_POST['userid'])) == '') {
		$_SESSION["errmsg"] = 1;
		goto tryagain;
	}
	else {$userid = mysqli_real_escape_string($connection, $_POST['userid']);
	}
	if (($userPasswd = trim($_POST['passwd'])) == '') {
		$_SESSION["errmsg"] = 2;
		goto tryagain;
	}
	else {$userPasswd = mysqli_real_escape_string($connection, $_POST['passwd']);
	}

//Encrypt the password.
	$encryptpasswd = sha1($userPasswd);

//See if match in the user table
	$query = "SELECT *
		   FROM odfu_user
		   WHERE id= '$userid' AND user_password= '$encryptpasswd'";
	$result = mysqli_query($connection, $query);
	if (!$result) {
		echo "Select from user failed. ", mysqli_error($connection);
		exit();
	}

//Determine if the user ID and password are on file.
	$row = mysqli_fetch_object($result);
	$db_userid = $row->id;
	$db_password = $row->user_password;
	$db_name = $row->name;
    $db_surname = $row->surname;
	$db_profilepic = $row->profile_pic;

	if ($db_userid != $userid || $db_password != $encryptpasswd){

tryagain:
	//If not, add to Session Retry and test > 3
		$retry = $_SESSION["retry"];
		$retry++;
		if ($retry > 3) {
    //If greater than 3 go to register.
		   header( "Location: login.html");
		}
		else {
    //If less than 3 reset Session Retry and go to Sign in
		   $_SESSION["retry"] = $retry;
		   header( "Location: login.html");
    	}
	}
	else {
    //If on file, get name, reset the session, and enter site.
        $_SESSION["id"] = $db_userid;
		$_SESSION["name"] = $db_name;
		$_SESSION["surname"] = $db_surname;
		$_SESSION["description"] = $row->description;
		$_SESSION["profile-pic"] = $db_profilepic;
        $_SESSION["retry"] = "admit";
        $_SESSION["time"] = time();
        header( "Location: createcookie.php");
	}
?>