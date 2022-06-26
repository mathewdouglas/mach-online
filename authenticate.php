<?php
	session_start();
	if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
		$url = "https://";
	} else {
		$url = "http://";
	}
	
	// Append the host(domain name, ip) to the URL.   
	$url .= $_SERVER['HTTP_HOST'];
	// Append the requested resource location to the URL   
	$url .= $_SERVER['REQUEST_URI'];
	$fullpath = parse_url($url, PHP_URL_PATH);
    $patharray = explode('/', $fullpath);
    $path = $patharray[count($patharray)-1];

if (isset ($_COOKIE["ODFU"])) {
        $adminid = $_SESSION["id"];
        if ($adminid != 1 & $adminid != 2 & $adminid != 3) {
            header( "Location: homepage.php");
        }
} else {
	header( "Location: login.html?return=$path");
}
?>
