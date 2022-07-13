<?php
    session_start();

    if (isset($_SESSION["return"])) {
        $returnURL = $_SESSION["return"];
    } else {
        $returnURL = "homepage.php";
    }
	

    //Set cookie, expires in 3 hours.
	$date = time() ;
	$expire = time()+(60*60*3);
	setcookie("ODFU", $_SESSION["id"], $expire, "/");
    setcookie("ODFUname", $_SESSION["name"], $expire, "/");
    
    if ($_SESSION["name"] === 'None') {
        $returnURL = "edituser.php?id=".$_SESSION["id"];
    }

    header( "Location: $returnURL");
?>