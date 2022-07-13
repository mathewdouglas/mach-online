<?php
session_start();
include "db_connection.php";
include "userinfo.php";

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
$fullpath = parse_url($url, PHP_URL_PATH);
$patharray = explode('/', $fullpath);
$path = $patharray[count($patharray)-1];

// Will probably change to use user_id and service_id and then get info database
parse_str($url_components['query'], $params);
if ($params["id"] === null) {
    $search_id = $_SESSION["id"];
} else {
    $search_id = $params["id"];
}

// Search database for user with given user_id
$sql = "SELECT * FROM odfu_user WHERE id = $search_id";
$res = mysqli_query($connection, $sql);

if (mysqli_num_rows($res) > 0) {
    while ($sql_result = mysqli_fetch_assoc($res)) {
        $profile_name = $sql_result['name'] . " " . $sql_result['surname'];
        $profile_tier = $sql_result['tier'];
        $profile_description = $sql_result['description'];
        $profile_bio = $sql_result['bio'];
        $profile_pic_url = $sql_result['profile_pic'];
        $profile_banner_url = $sql_result['banner_pic'];
        $profile_website = $sql_result['website'];
        $profile_facebook = $sql_result['facebook'];
        $profile_instagram = $sql_result['instagram'];
        $profile_twitter = $sql_result['twitter'];
        $profile_email = $sql_result['email'];
    }
}

// Search database for jobs with given user_id
$sql2 = "SELECT * FROM odfu_jobs WHERE provider_id = $search_id";
$jobs_res = mysqli_query($connection, $sql2);

// $params["name"] = str_replace("_", " ", $params["name"]);

if ($_SESSION['id'] == $search_id) {
    $settingshtml = '<div id="settings">
                        <p class="profile-description-title">Settings</p>
                        <a class="options-btn" style="font-size: 14px" href="edituser.php?id='.$_SESSION["id"].'&return=profile.php?id='.$_SESSION["id"].'">Edit Profile</a>
                        <a class="options-btn" style="font-size: 14px" href="edituserjobs.php?id='.$_SESSION["id"].'&return=profile.php?id='.$_SESSION["id"].'">Edit Jobs</a>
                        <a class="options-btn" style="font-size: 14px" href="edituserimages.php?id='.$_SESSION["id"].'&return=profile.php?id='.$_SESSION["id"].'">Edit Images</a>
                    </div>
                    <div id="profile-options-container">
                        <div class="profile-options">
                            <button style="visibility: visible;" id="show-settings" class="options-btn" onclick="showOptions(true)">Show Settings</button>
                            <button style="visibility: visible;" id="hide-description" class="options-btn" onclick="hideDescription(true)">View Images</button>
                        </div>
                    </div>';
} else {
    $settingshtml = '<div id="profile-options-container">
                        <div class="profile-options">
                            <button style="visibility: visible;" id="hide-description" class="options-btn" onclick="hideDescription(true)">View Images</button>
                        </div>
                    </div>';
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
    <title>ODFU - Profile</title>
    <link rel="stylesheet" href="css/profile.css?v=0.66">
    <link rel="stylesheet" href="css/mobile.css?v=0.22">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap">
    <?php echo $jscode;?>
    <script src="livesearch.js?v=0.2"></script>
</head>
<body ondragstart="return false">
    <header class="header">
        <input type="text" name="" id="search-bar" class="text-box" placeholder="Suche..." onkeyup="showResult(this.value, 'search-bar', 'livesearch')">
        <div id="livesearch"></div>
        <a id="login-link" href="./login.html">Sign in</a>
        <div id="login-status"><a class="item-link" href="./profile.php?id=<?php echo $id?>">
            <div class="login-profile-pic"><img src="Assets/<?=$_SESSION["profile-pic"]?>" alt=""></div>
            <p class="login-username"><?php echo $_SESSION["name"].' '.$_SESSION["surname"]?></p>
            <p class="login-servicename"><?php echo $_SESSION["description"]?></p>
        </a></div>
        <!-- <button class="menu"><i class="fa fa-bars"></i></button> -->
        <img onclick="location.href='homepage.php';" id="header-logo" src="Assets/Logo.svg" alt="">
        <div id="catagory-container">
            <?php
                $index = 1;

                // Search database for services with given catagory id
                $sql3 = "SELECT * FROM odfu_catagories";
                $res3 = mysqli_query($connection, $sql3);
                $arr = array();

                if (mysqli_num_rows($res3) > 0) {
                    while ($sql_result3 = mysqli_fetch_assoc($res3)) {
                        $arr[$sql_result3["id"]] = $sql_result3["catagory_name"];
                    }
                }
                
                while ($index <= 8) {
                    $catagory_items_html = '';

                    // Search database for services with given catagory id
                    $sql3 = "SELECT * FROM odfu_services WHERE catagory_id = $index";
                    $res3 = mysqli_query($connection, $sql3);

                    if (mysqli_num_rows($res3) > 0) {
                        while ($sql_result3 = mysqli_fetch_assoc($res3)) {
                            $catagory_items_html .= '<a href="service.php?sid='.$sql_result3["id"].'">'.$sql_result3["service_title"].'</a>';
                        }
                    }

                    if ($index == 8) {
                        $dropdown_class = "dropdown-right";
                    } else {
                        $dropdown_class = "";
                    }

                    echo '<div class="catagory-item">
                        <a href="catagory.php?sid='.$index.'">
                            <h3>'.$arr[$index].'</h3>
                        </a>
                        <div class="dropdown '.$dropdown_class.'">
                            <div class="dropdown-spacer"></div>
                            <div class="dropdown-items">
                                '.$catagory_items_html.'
                            </div>
                        </div>
                    </div>';
                    $index++;
                }
            ?>
        </div>
    </header>

    <main>
        <banner>
            <img src="Assets/<?=$profile_banner_url?>" alt="">
        </banner>
        <div id="spacer">
            <img class="profile-pic" src="Assets/<?=$profile_pic_url?>" alt="">
            <div class="profile-grid">
                <p class="profile-name"><?php echo $profile_name?></p>
                <div class="profile-social-media">
                    <a href="https://www.facebook.com/<?=$profile_facebook?>" target="_blank" class="facebook">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                            <path d="M504 256C504 119 393 8 256 8S8 119 8 256c0 123.78 90.69 226.38 209.25 245V327.69h-63V256h63v-54.64c0-62.15 37-96.48 93.67-96.48 27.14 0 55.52 4.84 55.52 4.84v61h-31.28c-30.8 0-40.41 19.12-40.41 38.73V256h68.78l-11 71.69h-57.78V501C413.31 482.38 504 379.78 504 256z" fill="currentcolor" />
                        </svg>
                    </a>
                    <a href="https://www.instagram.com/<?=$profile_instagram?>" target="_blank" class="instagram">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                            <path d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z" fill="currentcolor" />
                        </svg>
                    </a>
                    <a href="https://twitter.com/<?=$profile_twitter?>" target="_blank" class="twitter">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                            <path d="M459.37 151.716c.325 4.548.325 9.097.325 13.645 0 138.72-105.583 298.558-298.558 298.558-59.452 0-114.68-17.219-161.137-47.106 8.447.974 16.568 1.299 25.34 1.299 49.055 0 94.213-16.568 130.274-44.832-46.132-.975-84.792-31.188-98.112-72.772 6.498.974 12.995 1.624 19.818 1.624 9.421 0 18.843-1.3 27.614-3.573-48.081-9.747-84.143-51.98-84.143-102.985v-1.299c13.969 7.797 30.214 12.67 47.431 13.319-28.264-18.843-46.781-51.005-46.781-87.391 0-19.492 5.197-37.36 14.294-52.954 51.655 63.675 129.3 105.258 216.365 109.807-1.624-7.797-2.599-15.918-2.599-24.04 0-57.828 46.782-104.934 104.934-104.934 30.213 0 57.502 12.67 76.67 33.137 23.715-4.548 46.456-13.32 66.599-25.34-7.798 24.366-24.366 44.833-46.132 57.827 21.117-2.273 41.584-8.122 60.426-16.243-14.292 20.791-32.161 39.308-52.628 54.253z" fill="currentcolor" />
                        </svg>
                    </a>
                    <a href="mailto:<?=$profile_email?>" target="_blank" class="email">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                            <path d="M256 352c-16.53 0-33.06-5.422-47.16-16.41L0 173.2V400C0 426.5 21.49 448 48 448h416c26.51 0 48-21.49 48-48V173.2l-208.8 162.5C289.1 346.6 272.5 352 256 352zM16.29 145.3l212.2 165.1c16.19 12.6 38.87 12.6 55.06 0l212.2-165.1C505.1 137.3 512 125 512 112C512 85.49 490.5 64 464 64h-416C21.49 64 0 85.49 0 112C0 125 6.01 137.3 16.29 145.3z" fill="currentcolor" />
                        </svg>
                    </a>
                </div>
                <p class="profile-subtitle"><?=$profile_description?></p>
                <a href="<?=$profile_website?>" target="_blank" class="profile-website"><?=$profile_website?></a>
            </div>
        </div>
        <info>
            <div class="job-info">
                <?php
                if (mysqli_num_rows($jobs_res) > 0) {
                    while ($sql_result2 = mysqli_fetch_assoc($jobs_res)) {
                        $job_images = '`'.$sql_result2["img-1"].':'.$sql_result2["img-2"].':'.$sql_result2["img-3"].':'.$sql_result2["img-4"].'`';
                        echo '<div class="job-info-item" onclick="openTab('.$sql_result2["time_min"].','.$sql_result2["time_max"].','.$sql_result2["cost"].','.$sql_result2["reviews"].','.$sql_result2["rating"].',`'.$sql_result2["title"].'`,`'.$sql_result2["description"].'`,'.$job_images.')">
                        <img src="Assets/'.$sql_result2["job_icon"].'" alt="" class="job-icon">
                        <p class="job-title">'.$sql_result2["title"].'</p>
                        </div>';
                    }
                }
                if (mysqli_num_rows($jobs_res) < $profile_tier && $search_id == $_SESSION["id"]) {
                    echo '<div class="job-info-item" onclick="window.location.href=`addjob.php?return='.$path.'`;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" style="color: #5bdf2f !important;" class="job-info-item-icon" viewBox="0 0 448 512"><path d="M432 256c0 17.69-14.33 32.01-32 32.01H256v144c0 17.69-14.33 31.99-32 31.99s-32-14.3-32-31.99v-144H48c-17.67 0-32-14.32-32-32.01s14.33-31.99 32-31.99H192v-144c0-17.69 14.33-32.01 32-32.01s32 14.32 32 32.01v144h144C417.7 224 432 238.3 432 256z"/></svg>
                    <p class="job-title">Add Job</p>
                    </div>';
                }
                ?>
            </div>
            <div style="overflow: hidden; grid-row: 1/3; grid-column: 2/3;">
                <div id="profile-description">
                    <p id="profile-description-title" class="profile-description-title">About Me</p>
                    <p id="profile-description-text" class="profile-description-text"><?=$profile_bio?></p>
                </div>
                <?php echo $settingshtml?>
                <div id="profile-images">
                    <img class="picture" id="picture1" src="Assets/Profile-Image-1-Medium.jpg" alt="">
                    <img class="picture" id="picture2" src="Assets/Banner-Medium.jpg" alt="">
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" onclick="exitInfo()" fill="currentColor" id="exit-job-info" viewBox="0 0 320 512"><path d="M310.6 361.4c12.5 12.5 12.5 32.75 0 45.25C304.4 412.9 296.2 416 288 416s-16.38-3.125-22.62-9.375L160 301.3L54.63 406.6C48.38 412.9 40.19 416 32 416S15.63 412.9 9.375 406.6c-12.5-12.5-12.5-32.75 0-45.25l105.4-105.4L9.375 150.6c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0L160 210.8l105.4-105.4c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25l-105.4 105.4L310.6 361.4z"/></svg>
                <div class="button-container">
                    <button class="btn" onclick="scrollPrevious('profile-images', pictureWidth)"><i class="fa fa-chevron-left"></i></button>
                    <button class="btn" onclick="scrollNext('profile-images', pictureWidth)"><i class="fa fa-chevron-right"></i></button>
                </div>
            </div>
            <div class="job-info job-info-small">
                <div id="package-selector">
                    <select name="packages" id="packages">
                        <option value="1">Package 1</option>
                        <option value="2">Package 2</option>
                        <option value="3">Package 3</option>
                        <option value="4">Package 4</option>
                      </select>
                </div>
                <div></div>
                <div class="job-info-item no-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" style="color: #ff0000 !important;" class="job-info-item-icon" viewBox="0 0 512 512"><path d="M232 120C232 106.7 242.7 96 256 96C269.3 96 280 106.7 280 120V243.2L365.3 300C376.3 307.4 379.3 322.3 371.1 333.3C364.6 344.3 349.7 347.3 338.7 339.1L242.7 275.1C236 271.5 232 264 232 255.1L232 120zM256 0C397.4 0 512 114.6 512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0zM48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48C141.1 48 48 141.1 48 256z"/></svg>
                    <p id="job-info-1" class="job-title" style="font-size: 20px">0 Weeks</p>
                </div>
                <div class="job-info-item no-pointer">
                    <!-- <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" style="color: #85bb65 !important" class="job-info-item-icon" viewBox="0 0 576 512"><path d="M400 256C400 317.9 349.9 368 288 368C226.1 368 176 317.9 176 256C176 194.1 226.1 144 288 144C349.9 144 400 194.1 400 256zM272 224V288H264C255.2 288 248 295.2 248 304C248 312.8 255.2 320 264 320H312C320.8 320 328 312.8 328 304C328 295.2 320.8 288 312 288H304V208C304 199.2 296.8 192 288 192H272C263.2 192 256 199.2 256 208C256 216.8 263.2 224 272 224zM0 128C0 92.65 28.65 64 64 64H512C547.3 64 576 92.65 576 128V384C576 419.3 547.3 448 512 448H64C28.65 448 0 419.3 0 384V128zM48 176V336C83.35 336 112 364.7 112 400H464C464 364.7 492.7 336 528 336V176C492.7 176 464 147.3 464 112H112C112 147.3 83.35 176 48 176z"/></svg> -->
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" style="color: #85bb65 !important; width:45px; height:45px;" class="job-info-item-icon" viewBox="0 0 576 512"><path d="M252 208C252 196.1 260.1 188 272 188H288C299 188 308 196.1 308 208V276H312C323 276 332 284.1 332 296C332 307 323 316 312 316H264C252.1 316 244 307 244 296C244 284.1 252.1 276 264 276H268V227.6C258.9 225.7 252 217.7 252 208zM512 64C547.3 64 576 92.65 576 128V384C576 419.3 547.3 448 512 448H64C28.65 448 0 419.3 0 384V128C0 92.65 28.65 64 64 64H512zM128 384C128 348.7 99.35 320 64 320V384H128zM64 192C99.35 192 128 163.3 128 128H64V192zM512 384V320C476.7 320 448 348.7 448 384H512zM512 128H448C448 163.3 476.7 192 512 192V128zM288 144C226.1 144 176 194.1 176 256C176 317.9 226.1 368 288 368C349.9 368 400 317.9 400 256C400 194.1 349.9 144 288 144z"/></svg>
                    <p id="job-info-2" class="job-title" style="font-size: 20px">€0</p>
                </div>
                <!-- <div class="job-info-item no-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" style="color: #2246b1 !important; width:40px; height:40px;" class="job-info-item-icon" viewBox="0 0 448 512"><path d="M416 127.1h-58.23l9.789-58.74c2.906-17.44-8.875-33.92-26.3-36.83c-17.53-2.875-33.92 8.891-36.83 26.3L292.9 127.1H197.8l9.789-58.74c2.906-17.44-8.875-33.92-26.3-36.83c-17.53-2.875-33.92 8.891-36.83 26.3L132.9 127.1H64c-17.67 0-32 14.33-32 32C32 177.7 46.33 191.1 64 191.1h58.23l-21.33 128H32c-17.67 0-32 14.33-32 32c0 17.67 14.33 31.1 32 31.1h58.23l-9.789 58.74c-2.906 17.44 8.875 33.92 26.3 36.83C108.5 479.9 110.3 480 112 480c15.36 0 28.92-11.09 31.53-26.73l11.54-69.27h95.12l-9.789 58.74c-2.906 17.44 8.875 33.92 26.3 36.83C268.5 479.9 270.3 480 272 480c15.36 0 28.92-11.09 31.53-26.73l11.54-69.27H384c17.67 0 32-14.33 32-31.1c0-17.67-14.33-32-32-32h-58.23l21.33-128H416c17.67 0 32-14.32 32-31.1C448 142.3 433.7 127.1 416 127.1zM260.9 319.1H165.8L187.1 191.1h95.12L260.9 319.1z"/></svg>
                    <p id="job-info-3" class="job-title" style="font-size: 20px">24 Jobs</p>
                </div>
                <div class="job-info-item no-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" style="color: #e9ca62 !important; width:40px; height:40px; padding-bottom: 4px;" class="job-info-item-icon" viewBox="0 0 576 512"><path d="M381.2 150.3L524.9 171.5C536.8 173.2 546.8 181.6 550.6 193.1C554.4 204.7 551.3 217.3 542.7 225.9L438.5 328.1L463.1 474.7C465.1 486.7 460.2 498.9 450.2 506C440.3 513.1 427.2 514 416.5 508.3L288.1 439.8L159.8 508.3C149 514 135.9 513.1 126 506C116.1 498.9 111.1 486.7 113.2 474.7L137.8 328.1L33.58 225.9C24.97 217.3 21.91 204.7 25.69 193.1C29.46 181.6 39.43 173.2 51.42 171.5L195 150.3L259.4 17.97C264.7 6.954 275.9-.0391 288.1-.0391C300.4-.0391 311.6 6.954 316.9 17.97L381.2 150.3z"/></svg>
                    <p id="job-info-4" class="job-title" style="font-size: 20px">4.3</p>
                </div> -->
                <div id="info-landing">

                </div>
            </div>
        </info>
    </main>
</body>
<script>
    var pictureWidth;

    window.onload = function(){
        showHideLoginStatus();
        setCSSProperty("--description-width", document.getElementById("profile-images").offsetWidth + "px");
        setCSSProperty("--description-height", document.getElementById("profile-images").offsetHeight + "px");
    }

    document.addEventListener('click', function handleClick(event) {
        var target;
        if (event.target.classList.contains("job-info-item")) {
            target = event.target;
        } else if (event.target.classList.contains("job-title") | event.target.classList.contains("job-icon")) {
            var target = event.target.parentElement;
        } else {
            return;
        }

        var elem = document.getElementsByClassName("selected")[0];

        if (elem !== null && elem !== undefined) {
            document.getElementsByClassName("selected")[0].classList.remove("selected");
        }

        target.classList.add('selected');
    });


    pictureWidth = document.getElementById("picture1").offsetWidth;
    console.log(<?php echo $in?>);

    function setCSSProperty(property, value) {
        document.documentElement.style.setProperty(property, value);
    }

    function exitInfo() {
        document.getElementById("profile-description-title").innerHTML = 'About Me';
        document.getElementById("profile-description-text").innerHTML = '<?=$profile_description?>';
        document.getElementById("exit-job-info").style.visibility = "hidden";
        document.getElementById("info-landing").style.visibility = "visible";
        document.getElementsByClassName("selected")[0].classList.remove("selected");
    }

    function hideDescription(flag) {
        if (flag) {
            document.getElementById("profile-description").style.visibility = "hidden";
            document.getElementById("hide-description").innerHTML = "View Description";
            try {
                document.getElementById("show-settings").style.visibility = "hidden";
            } catch (error) {
                
            }
            
        } else {
            document.getElementById("profile-description").style.visibility = "visible";
            document.getElementById("hide-description").innerHTML = "View Images";
            try {
                document.getElementById("show-settings").style.visibility = "visible";
            } catch (error) {
                
            }
        }
        document.getElementById("hide-description").setAttribute('onclick', 'hideDescription('+!flag+')');
    }

    function showOptions(flag) {
        if (flag) {
            document.getElementById("settings").style.visibility = "visible";
            document.getElementById("show-settings").innerHTML = "Hide Settings";
            document.getElementById("hide-description").style.visibility = "hidden";
            document.getElementById("hide-description").style.width = "0px";
            document.getElementById("hide-description").style.marginLeft = "0px";
            document.getElementById("hide-description").style.padding = "0px";
        } else {
            document.getElementById("settings").style.visibility = "hidden";
            document.getElementById("show-settings").innerHTML = "Show Settings";
            document.getElementById("hide-description").style.visibility = "visible";
            document.getElementById("hide-description").style.width = "fit-content";
            document.getElementById("hide-description").style.marginLeft = "12px";
            document.getElementById("hide-description").style.padding = "6px 10px";
        }
        document.getElementById("show-settings").setAttribute('onclick', 'showOptions('+!flag+')');
    }

    function scrollNext(element, width) {
    document.getElementById(element).scrollBy({
        left: width,
        behavior: "smooth"
    });

    }

    function scrollPrevious(element, width) {
        document.getElementById(element).scrollBy({
            left: -1*width,
            behavior: "smooth"
        });
    }


    function openTab(time_min, time_max, cost, reviews, rating, title, description, images) {
        document.getElementById("job-info-1").innerHTML = "" + time_min + "-" + time_max + " Weeks";
        document.getElementById("job-info-2").innerHTML = "€" + cost;
        // document.getElementById("job-info-3").innerHTML = "" + reviews + " Reviews";
        // document.getElementById("job-info-4").innerHTML = rating;
        document.getElementById("profile-description-title").innerHTML = title;
        document.getElementById("profile-description-text").innerHTML = description;

        document.getElementById("exit-job-info").style.visibility = "visible";
        document.getElementById("info-landing").style.visibility = "hidden";

        var image_arr = images.split(':').filter(e => e);
        var output = "";
        for (let index = 0; index < image_arr.length; index++) {
            output += '<img class="picture" id="picture' + (index+1) + '" src="Assets/' + image_arr[index] + '" alt="">';
        }

        document.getElementById("profile-images").innerHTML = output;
    }
    // var name, service;

    // try {
    //     const queryString = window.location.search;
    //     const urlParams = new URLSearchParams(queryString);
    //     name = urlParams.get('name').replace('_', ' ');
    //     service = urlParams.get('service').replace('_', ' ');
    //     console.log(name);
    //     console.log(service);
    // } catch (error) {
    //     name = "No Name Given"
    // }

    // // document.getElementsByClassName('profile-name')[0].innerHTML = name;
    // document.getElementsByClassName('profile-subtitle')[0].innerHTML = service;
    
    var packages = {
        "packages" : [{
            "name" : "Package 1",
            "description" : "Package 1",
            "cost" : 50,
            "time_min" : 2,
            "time_max" : 3
        },
        {
            "name" : "Package 2",
            "description" : "Package 2",
            "cost" : 25,
            "time_min" : 1,
            "time_max" : 4
        },
        {
            "name" : "Test",
            "description" : "Test",
            "cost" : 420,
            "time_min" : 6,
            "time_max" : 9
        }
        ]
    }
    
    var packagesHTML = "";
    packages.packages.forEach(package => {
        packagesHTML += `<option value="1" onclick="console.log('`+ package.name +`')">` + package.name + `</option>`;
    });

    document.getElementById("packages").innerHTML = packagesHTML;
</script>