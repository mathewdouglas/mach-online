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

// Will probably change to use user_id and service_id and then get info database
parse_str($url_components['query'], $params);
$search_id = $params["sid"];

// Search database for service with given id
$sql = "SELECT * FROM odfu_services WHERE id = $search_id";
$res = mysqli_query($connection, $sql);

if (mysqli_num_rows($res) > 0) {
    $sql_result = mysqli_fetch_assoc($res);
    $service = $sql_result['service_title'];
    $catagory_id = $sql_result['catagory_id'];
    $img_small = $sql_result['img_small'];
    $img_medium = $sql_result['img_medium'];
}

// Search database for service with given id
$sql2 = "SELECT * FROM odfu_jobs WHERE service_id = $search_id";
$res2 = mysqli_query($connection, $sql2);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#3162a5">
    <meta name="description" content="Germany's best freelance website and ">
    <title>Mach Online - Service</title>
    <link rel="stylesheet" href="css/service.css?v=0.36">
    <link rel="stylesheet" href="css/mobile.css?v=0.22">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap">
    <?php echo $jscode;?>
    <script src="livesearch.js?v=0.2"></script>
    <!-- <script src="script.js?v=0.22"></script> -->
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
    <div class="top-section">
        <p class="catagory-title"><?php echo $service?></p>
        <div class="slideshow-container">
                <div class="mySlides fade">
                    <img src="Assets/<?php echo $img_medium?>"/>
                </div>

                <div class="mySlides fade">
                    <img src="Assets/Banner-Medium.jpg"/>
                </div>

                <div class="mySlides fade">
                    <img src="Assets/Video-Marketing-Medium.jpg"/>
                </div>
            </div>
    </div>
    <div class="card-grid">

        <?php
            if (mysqli_num_rows($res2) > 0) {
                $num = 1;
                while ($sql_result2 = mysqli_fetch_assoc($res2)) {
                    echo '<div class="card">
                        <img src="Assets/'.$sql_result2["img-1"].'" alt="" class="card-image" draggable="false">
                        <div class="name-flex">
                            <p class="name">Job Title</p>
                            <p class="medium service">Chef</p>
                        </div>
                        <div class="details-grid">
                            <p class="value bottom">$'.$sql_result2["cost"].'</p>
                            <p class="value bottom">'.$sql_result2["time_min"].'-'.$sql_result2["time_max"].'</p>
                            <p class="medium">Price</p>
                            <p class="medium">Weeks</p>
                        </div>
                        <div id="info-pane'.$num.'" class="info-pane">
                            <p class="info-pane-title">Job Title</p>
                            <p class="info-pane-description">'.$sql_result2["description"].'</p>
                        </div>
                        <a href="./profile.php?id='.$sql_result2["provider_id"].'" onmouseover="showInfo(`info-pane'.$num.'`)" onmouseout="hideInfo(`info-pane'.$num++.'`)" class="profile-btn">View Profile Page</a>
                    </div>';
                }
            }
            
        ?>


        <div class="card">
            <img src="Assets/Cooking-1-Small.jpg" alt="" class="card-image" draggable="false">
            <div class="name-flex">
                <p class="name">Job Title</p>
                <p class="medium service">Chef</p>
            </div>
            <div class="details-grid">
                <p class="value bottom">$50</p>
                <p class="value bottom">1-2</p>
                <p class="medium">Price</p>
                <p class="medium">Weeks</p>
            </div>
            <div id="info-pane30" class="info-pane">
                <p class="info-pane-title">Job Title</p>
                <p class="info-pane-description">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Consectetur possimus non culpa! Adipisci dignissimos rerum assumenda tempora iusto sed debitis dolorem iste esse, culpa aperiam, id</p>
            </div>
            <a href="./profile.php?id=1" onmouseover="showInfo('info-pane30')" onmouseout="hideInfo('info-pane30')" class="profile-btn">View Profile Page</a>
        </div>
        <div class="card">
            <img src="Assets/Coding-1-Small.jpg" alt="" class="card-image" draggable="false">
            <div class="name-flex">
                <p class="name">Mathew Douglas</p>
                <p class="medium service">Coder</p>
            </div>
            <div class="details-grid">
                <p class="value bottom">$50</p>
                <p class="value bottom">3-4</p>
                <p class="medium">Price</p>
                <p class="medium">Weeks</p>
            </div>
            <a href="./profile.php?id=1" class="profile-btn">View Profile Page</a>
        </div>
    </div>

    <div class="footer">
            <div class="footer-grid">
                <h3>INSERT ODFU LOGO</h3>
                <div class="footer-social-media">
                    <a href="https://www.facebook.com/" target="_blank" class="facebook">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                            <path d="M504 256C504 119 393 8 256 8S8 119 8 256c0 123.78 90.69 226.38 209.25 245V327.69h-63V256h63v-54.64c0-62.15 37-96.48 93.67-96.48 27.14 0 55.52 4.84 55.52 4.84v61h-31.28c-30.8 0-40.41 19.12-40.41 38.73V256h68.78l-11 71.69h-57.78V501C413.31 482.38 504 379.78 504 256z" fill="currentcolor" />
                        </svg>
                    </a>
                    <a href="https://www.instagram.com/" target="_blank" class="instagram">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                            <path d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z" fill="currentcolor" />
                        </svg>
                    </a>
                    <a href="https://twitter.com/" target="_blank" class="twitter">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                            <path d="M459.37 151.716c.325 4.548.325 9.097.325 13.645 0 138.72-105.583 298.558-298.558 298.558-59.452 0-114.68-17.219-161.137-47.106 8.447.974 16.568 1.299 25.34 1.299 49.055 0 94.213-16.568 130.274-44.832-46.132-.975-84.792-31.188-98.112-72.772 6.498.974 12.995 1.624 19.818 1.624 9.421 0 18.843-1.3 27.614-3.573-48.081-9.747-84.143-51.98-84.143-102.985v-1.299c13.969 7.797 30.214 12.67 47.431 13.319-28.264-18.843-46.781-51.005-46.781-87.391 0-19.492 5.197-37.36 14.294-52.954 51.655 63.675 129.3 105.258 216.365 109.807-1.624-7.797-2.599-15.918-2.599-24.04 0-57.828 46.782-104.934 104.934-104.934 30.213 0 57.502 12.67 76.67 33.137 23.715-4.548 46.456-13.32 66.599-25.34-7.798 24.366-24.366 44.833-46.132 57.827 21.117-2.273 41.584-8.122 60.426-16.243-14.292 20.791-32.161 39.308-52.628 54.253z" fill="currentcolor" />
                        </svg>
                    </a>
                    <a href="" target="_blank" class="email">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                            <path d="M256 352c-16.53 0-33.06-5.422-47.16-16.41L0 173.2V400C0 426.5 21.49 448 48 448h416c26.51 0 48-21.49 48-48V173.2l-208.8 162.5C289.1 346.6 272.5 352 256 352zM16.29 145.3l212.2 165.1c16.19 12.6 38.87 12.6 55.06 0l212.2-165.1C505.1 137.3 512 125 512 112C512 85.49 490.5 64 464 64h-416C21.49 64 0 85.49 0 112C0 125 6.01 137.3 16.29 145.3z" fill="currentcolor" />
                        </svg>
                    </a>
                </div>

                <h3></h3>
                <h3>Contact</h3>
                <a href="">
                    <h3>Support</h3>
                </a>
                <a href="">
                    <h3>Becoming a Provider</h3>
                </a>
                <a href="./login.html">
                    <h3>Sign in</h3>
                </a>
                <h3></h3>

                <h3>About</h3>
                <a href="">
                    <h3>About ODFU</h3>
                </a>
                <a href="">
                    <h3>Privacy Policy</h3>
                </a>
                <a href="">
                    <h3>Terms of Service</h3>
                </a>


                <!-- <h3>Catagories</h3>
                <a href=""><h3>Graphik-Design</h3></a>
                <a href=""><h3>Marketing</h3></a>
                <a href=""><h3>Recht und Beratung</h3></a>
                <a href=""><h3>Bildung</h3></a>
                <a href=""><h3></h3></a>
                <a href=""><h3>Unternehmen</h3></a>
                <a href=""><h3>Sport und Lifestyle</h3></a>
                <a href=""><h3>Gesundheit</h3></a>
                <a href=""><h3>Programmierung und IT</h3></a> -->
            </div>
            <p class="copyright-text">Copyright @ 2022 ODFU DE</p>
        </div>
</body>
<script>
    window.onload = function(){
        showHideLoginStatus();
    }

    let slideIndex = 0;
        showSlides();

        function showSlides() {
            let i;
            let slides = document.getElementsByClassName("mySlides");
            for (i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }
            slideIndex++;
            if (slideIndex > slides.length) {
                slideIndex = 1;
            }
            slides[slideIndex - 1].style.display = "block";
            setTimeout(showSlides, 5000); // Change image every 2 seconds
        }

        // Test
        function showInfo(id) {
            var elem = document.getElementById(id);
            elem.style.visibility = "visible";
            elem.style.opacity = 1;
        }

        function hideInfo(id) {
            var elem = document.getElementById(id);
            elem.style.visibility = "hidden";
            elem.style.opacity = 0;
        }
</script>