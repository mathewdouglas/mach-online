<?php
if (isset ($_COOKIE["ODFU"])) {
    $id = $_SESSION["id"];

    $query = "SELECT *
		   FROM odfu_user
		   WHERE id= '$id'";
	$result = mysqli_query($connection, $query);
	if (!$result) {
		echo "Select from user failed. ", mysqli_error($connection);
		exit();
	}

	$row = mysqli_fetch_object($result);

    $_SESSION["name"] = $row->name;
    $_SESSION["surname"] = $row->surname;
    $_SESSION["description"] = $row->description;
    $_SESSION["profile-pic"] = $row->profile_pic;
    $_SESSION["retry"] = 0;
    $_SESSION["time"] = time();

    $AUTH = TRUE;
    $jscode = "<script type=\"text/javascript\">
        function showHideLoginStatus() {
          document.getElementById('login-status').style.display = 'block';
          document.getElementById('login-link').style.display = 'none';
          console.log('Cookie: True');
        };
      </script>";

} else {
    //If not, go to registration.
    // header( "Location: login.html");
    $AUTH = FALSE;
    session_destroy();
    $id = 0;
    $jscode = "<script type=\"text/javascript\">
        function showHideLoginStatus() {
          document.getElementById('login-status').style.display = 'none';
          document.getElementById('login-link').style.display = 'none';
          console.log('Cookie: False');
        };
      </script>";
}
?>