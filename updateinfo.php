<?php
session_start();
include "db_connection.php";

$id = $_POST['id'];

// Checks if the user is not an admin and if so makes sure
// they can only update their own info
if ($_SESSION["id"] > 3) {
    $id = $_SESSION["id"];
}

$name = $_POST['name'];
$surname = $_POST['surname'];
$description = $_POST['profile-description'];
$email = $_POST['email'];
$website = $_POST['website'];
$number = $_POST['number'];
$facebook = $_POST['facebook'];
$instagram = $_POST['instagram'];
$twitter = $_POST['twitter'];

$query = "UPDATE `odfu_user` SET `name` = '$name', `surname` = '$surname', `description` = '$description', `website` = '$website', `email` = '$email', `phone_number` = '$number', `facebook` = '$facebook', `instagram` = '$instagram', `twitter` = '$twitter' 
    WHERE `odfu_user`.`id` = $id;";


if ($connection->query($query) === TRUE) {
    header("Location: userlist.php");
}


?>