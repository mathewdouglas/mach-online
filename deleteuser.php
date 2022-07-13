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
if ($params["id"] === null) {
    $userID = 0;
} else {
    $userID = $params["id"];
}

$query = "DELETE FROM `odfu_user` WHERE `id` = $userID";


if ($connection->query($query) === TRUE) {
    // echo "User deleted successfully";
}

header( "Location: userlist.php");

?>