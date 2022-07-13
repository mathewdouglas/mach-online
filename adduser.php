<?php
session_start();
include "db_connection.php";

$password = sha1($_POST['Password']);

$query = "INSERT INTO `odfu_user` (`id`, `user_password`, `name`, `surname`, `description`, `profile_pic`, `banner_pic`, `website`, `email`, `phone_number`, `facebook`, `instagram`, `twitter`) 
VALUES (NULL, '$password', 'None', '', '', '', '', '', '', '', '', '', '');";

if ($connection->query($query) === TRUE) {
    // echo "New record created successfully";
}

header( "Location: userlist.php");

?>