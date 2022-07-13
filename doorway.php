<?php

// Check to see if session retry is admit
if (isset($_SESSION["retry"])&& $_SESSION["retry"] == "admit") {
	
} else {
    header( "Location: authenticate.php");
}

?>