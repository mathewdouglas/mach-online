<?php
    session_start();
    include "db_connection.php";

    if (!(isset($_COOKIE["ODFU"]))) {
        session_destroy();
        header("Location: login.html?return=edituserimages.php");
    }

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
    
    // Will probably change to use user_id and service_id and then get info database
    parse_str($url_components['query'], $params);
    if ($params["id"] === null) {
        $user_id = $_SESSION["id"];
    } else {
        $user_id = $params["id"];
    }

    if ($params["return"] === null) {
        $return_URL = "";
    } else {
        $return_URL = $params["return"];
    }


    // Search database for user with given user_id
    $sql = "SELECT * FROM odfu_user WHERE id = $user_id";
    $res = mysqli_query($connection, $sql);

    if (mysqli_num_rows($res) > 0) {
        while ($sql_result = mysqli_fetch_assoc($res)) {
            $profile_name = $sql_result['name'];
            $profile_surname = $sql_result['surname'];
            $profile_description = $sql_result['description'];
            $profile_pic_url = $sql_result['profile_pic'];
            $profile_banner_url = $sql_result['banner_pic'];
        }
    }

    // Search database for jobs with given user_id
    $sql2 = "SELECT * FROM odfu_jobs WHERE provider_id = $user_id";
    $jobs_res = mysqli_query($connection, $sql2);

    if (mysqli_num_rows($jobs_res) > 0) {
        $jobs_list_html = '';
        while ($sql_result2 = mysqli_fetch_assoc($jobs_res)) {
            $job_images = '`'.$sql_result2["img-1"].':'.$sql_result2["img-2"].':'.$sql_result2["img-3"].':'.$sql_result2["img-4"].'`';
            $jobs_list_html .= '<option value="'.$sql_result2["id"].'">'.$sql_result2["title"].'</option>';
        }
    }

    // Search database for jobs with given user_id
    $sql3 = "SELECT * FROM odfu_catagories";
    $catagories_res = mysqli_query($connection, $sql3);

    if (mysqli_num_rows($catagories_res) > 0) {
        $catagories_list_html = '';
        while ($sql_result3 = mysqli_fetch_assoc($catagories_res)) {
            $catagories_list_html .= '<option value="'.$sql_result3["id"].'">'.$sql_result3["catagory_name"].'</option>';
        }
    }
    
    if ($profile_name === 'None') {
        $profile_name = '';
    }

    if (preg_match('/(.+)/', $profile_pic_url)) {
        $profile_img_html = '<div><p>Profile Pic</p>
        <img src="Assets/'.$profile_pic_url.'" alt=""></div>';
    } else {
        $profile_img_html = '<div><p>Profile Pic</p>
        <input type="file" name="profile_pic"></div>';
    }

    if ($_SESSION["id"] != $user_id) {
        if ($_SESSION["id"] > 3) {
            header("Location: homepage.php");
        }
    } else {
        $greeting = "Add a job";
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#3162a5">
    <meta name="description" content="Germany's best freelance website">
    <title>OFDU - Add Job</title>
</head>
<body>
    <form action="upload.php" method="POST" class="details-form" enctype="multipart/form-data">
        <h1><?=$greeting?></h1>
        <input type="submit" name="submit_image" value="Save changes" id="submit-btn">
        <div>
            <p>Job Title *</p>
            <input type="text" name="title" id="" required>
        </div>
        <div>
            <p>Description *</p>
            <input type="text" name="description" id="" required>
        </div>
        <div id="package-selector">
            <p>Select Catagory:</p>
            <select name="jobs" id="jobs">
                <?php echo $catagories_list_html?>
            </select>
        </div>
        <div>
            <p>Job Image 1</p>
            <input type="file" name="job_image_1">
        </div>
        <div>
            <p>Job Image 2</p>
            <input type="file" name="job_image_2">
        </div>
        <div>
            <p>Job Image 3</p>
            <input type="file" name="job_image_3">
        </div>
        <div>
            <p>Job Image 4</p>
            <input type="file" name="job_image_4">
        </div>
    </form>
</body>
<style>
    @font-face {
        font-family: "Montserrat", sans-serif;
        src: url("https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap");
        font-display: swap;
    }
    body {
        margin: 0;
        height: 100vh;
        font-size: 16px;
        font-family: "Montserrat", sans-serif;
        text-align: center;
        background-image: linear-gradient(
            120deg,
            #3162a5,
            #229bff
        );
        overflow: hidden;
    }

    .details-form {
        display: grid;
        grid-template-columns: 1fr 1fr;
        grid-template-rows: repeat(6, 1fr);
        justify-content: baseline;
        text-align: left;
        
        width: 50em;
        height: 37.5em;
        background: #fff;
        border-radius: 30px;
        padding: 40px 40px;
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        box-shadow: 15px 15px 20px rgba(0, 0, 0, 0.3);
    }

    .details-form div {
        margin-bottom: 20px;
    }

    h1 {
        align-self: center;
    }

    p {
        padding: 0;
        margin: 0 0 5px;
    }

    input[type=text], input[type=tel], input[type=email], input[type=url] {
        width: 75%;
        height: 32px;
        padding: 5px 10px;
        background-color: #F2F2F7;
        box-shadow: none;
        border: none;
        -webkit-border-radius: 10px;
        -moz-border-radius: 10px;
        border-radius: 10px;
        font-size: 22px;
        outline: none;
    }

    input[type=url], input[type=tel], input[type=email], .username {
        font-size: 18px !important;
    }

    input::placeholder {
        color: #a0a0a0;
        font-size: 18px;
    }

    #submit-btn {
        padding: 8px 16px;
        align-self: center;
        height: 32px;
        width: fit-content;
        font-family: "Montserrat", sans-serif;
        font-weight: 600;
        /* box-shadow: 0px 3px 5px rgba(0, 0, 0, 16%); */
        border-radius: 500px;
        border: 0px solid lightgray;
        cursor: pointer;
        color: white;
        background-color: #20416f;
    }

    #submit-btn:hover {
        background-color: #0F5DC7;
    }

    img {
        width: 50px;
        height: 50px;
        border-radius: 25px;
    }
</style>
<script>
</script>
</html>