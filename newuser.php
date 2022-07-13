<?php
session_start();
include "db_connection.php";
include "authenticate.php";

$query = "SELECT `AUTO_INCREMENT`
FROM  INFORMATION_SCHEMA.TABLES
WHERE TABLE_SCHEMA = 'u810484942_db'
AND   TABLE_NAME   = 'odfu_user';";

$result = mysqli_query($connection, $query);
if (!$result) {
    echo "Fetch from database failed. ", mysqli_error($connection);
    
}
$row = mysqli_fetch_object($result);
$userid = $row->AUTO_INCREMENT;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#3162a5">
    <meta name="description" content="Germany's best freelance website">
    <title>OFDU - Add New User</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" charset="utf-8"></script>
<body>
    <form action="adduser.php" method="POST" class="login-form">
        <!-- <img src="" alt="icon"> -->
        <div>
            <h1>Add User</h1>

            <div class="txtb">
                <input id="password" type="text" name="Password">
                <span data-placeholder="Password"></span>
            </div>
            <p>User ID: <?=$userid?></p>
            <p>Link to send: <a href="">https://mathewdouglas.co.za/ODFU/login.html</a></p>

        </div>

        <input type="submit" class="logbtn" value="Add User">

    </form>
</body>
<style>
    @import url("https://fonts.googleapis.com/css?family=Montserrat:400,700");

:root {
    --red: #ff0000;
    --purple: #8e44ad;
    --blue: #3162a5;
    --main-color: #3162a5;
    --accent-color: #229bff;
}

* {
    margin: 0;
    padding: 0;
    text-decoration: none;
    font-family: "Montserrat";
    box-sizing: border-box;
}

body {
    min-height: 100vh;
    height: 100%;
    background-image: linear-gradient(
        120deg,
        var(--main-color),
        var(--accent-color)
    );
    background-attachment: fixed;
}

.login-form {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    width: 22.5em;
    background: #fff;
    height: 37.5em;
    padding: 40px 40px;
    border-radius: 30px;
    position: absolute;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
    box-shadow: 15px 15px 20px rgba(0, 0, 0, 0.3);
}

img {
    margin: 0% 50%;
    transform: translate(-50%, -0%);
}

.login-form h1 {
    text-align: center;
    margin-top: 20px;
    margin-bottom: 50px;
}

.txtb {
    border-bottom: 2px solid #adadad;
    position: relative;
    margin: 30px 0;
}

.txtb input {
    font-size: 15px;
    color: #333;
    border: none;
    width: 100%;
    outline: none;
    background: none;
    padding: 0 5px;
    height: 40px;
}

.txtb span::before {
    content: attr(data-placeholder);
    position: absolute;
    top: 50%;
    left: 5px;
    color: #adadad;
    transform: translateY(-50%);
    z-index: -1;
    transition: 0.5s;
}

.txtb span::after {
    content: "";
    float: left;
    position: relative;
    width: 0%;
    height: 2px;
    background: linear-gradient(120deg, var(--main-color), var(--accent-color));
    transition: 0.5s;
}

.focus + span::before {
    top: -5px;
}
.focus + span::after {
    width: 100%;
}

.logbtn {
    display: block;
    width: 100%;
    height: 4em;
    border: none;
    background: linear-gradient(
        120deg,
        var(--main-color),
        var(--accent-color),
        var(--main-color)
    );
    background-size: 200%;
    border-radius: 35px;
    box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.35);
    color: #fff;
    outline: none;
    cursor: pointer;
    transition: 0.5s;
}

.logbtn:hover {
    background-position: right;
}

p {
    font-size: 1em;
    line-height: 1.2em;
    text-align: left;
    margin: 10px 0 20px 0;
}

.red {
    margin-top: 60px;
    text-align: center;
    font-size: 13px;
    color: var(--red);
}
</style>
<script type="text/javascript">
        $(document).ready(function() {    
            $("#password").val("Test123"); 
            $(".txtb input").addClass("focus");
        });

        $(".txtb input").on("focus", function () {
            $(this).addClass("focus");
        });

        $(".txtb input").on("load", function () {
            $(this).addClass("focus");
        });

        $(".txtb input").on("blur", function () {
            if ($(this).val() == "")
                $(this).removeClass("focus");
        });

    </script>
</html>