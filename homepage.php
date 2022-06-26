<?php
session_start();
// include "doorway.php";
include "db_connection.php";
include "userinfo.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#3162a5">
    <meta name="description" content="Germany's best freelance website">
    <title>Mach Online</title>
    <link rel="stylesheet" href="css/style.css?v=0.38">
    <link rel="stylesheet" href="css/common.css?v=0.1">
    <link rel="stylesheet" href="css/mobile.css?v=0.25.3">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap">
    <?php echo $jscode; ?>
    <script src="script.js?v=0.27.8"></script>
    <script src="livesearch.js?v=0.2"></script>
</head>


<body>
    <header class="header">
        <input type="text" name="" id="search-bar" class="text-box" placeholder="Suche..." onkeyup="showResult(this.value, 'search-bar', 'livesearch')">
        <div id="livesearch"></div>
        <a id="login-link" href="./login.html">Sign in</a>
        <div id="login-status"><a class="item-link" href="./profile.php?id=<?php echo $id ?>">
                <div class="login-profile-pic"><img src="Assets/<?= $_SESSION["profile-pic"] ?>" alt=""></div>
                <p class="login-username"><?php echo $_SESSION["name"] . ' ' . $_SESSION["surname"] ?></p>
                <p class="login-servicename"><?php echo $_SESSION["description"] ?></p>
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
    <div id="container">
        <div class="profiles-container">
            <div class="profile">
                <div class="profile-img"></div>
                <p>Design</p>
            </div>
            <div class="profile">
                <div class="profile-img"></div>
                <p>Marketing</p>
            </div>
            <div class="profile">
                <div class="profile-img"></div>
                <p>Finances</p>
            </div>
            <div class="profile">
                <div class="profile-img"></div>
                <p>Lifestyle</p>
            </div>
            <div class="profile">
                <div class="profile-img"></div>
                <p>Tech</p>
            </div>
        </div>
        <div id="search-box">
            <h2 class="search-title">Finde deine Dienstleistung</h2>
            <input type="text" name="" id="search-bar1" class="text-box" placeholder="Suche..." onkeyup="showResult(this.value, 'search-bar1', 'livesearch1')">
            <div id="livesearch1"></div>
            <div class="suggestions-container">
                <a href="service.php?sid=2" class="suggestion">Web Design</a>
                <a href="service.php?sid=10" class="suggestion">Social Media</a>
                <a href="service.php?sid=9" class="suggestion">Markendesign</a>
                <a href="service.php?sid=22" class="suggestion">Anwälte</a>
                <a href="service.php?sid=1" class="suggestion">Logo Design</a>
            </div>
        </div>

        <div class="favourite-block">
            <div class="catagory-title">
                <h4 id="favourites-title">Favoriten</h4>
                <a href="" class="right">
                    <h4 class="see-all">See All <i class="fa fa-chevron-right"></i></h4>
                </a>
            </div>
            <div id="favourites-container" class="favourites-container">
                <div id="favourite1" class="item favourite"><a class="item-link" href="service.php?sid=53">
                        <h2 class="favourite-title">Kochkurse</h2>
                        <img src="Assets/Cooking-1-Medium.jpg" alt="">
                        <div class="favourite-overlay"></div>
                    </a></div>
                <div class="item favourite"><a class="item-link" href="service.php?sid=50">
                        <h2 class="favourite-title">Fitnesskurse</h2>
                        <img src="Assets/Personal-Training-Medium.jpg" alt="">
                        <div class="favourite-overlay"></div>
                    </a></div>
                <div class="item favourite"><a class="item-link" href="service.php?sid=4">
                        <h2 class="favourite-title">Flyer-Design</h2>
                        <img src="Assets/Flyer-Design-1-Medium.jpg" alt="">
                        <div class="favourite-overlay"></div>
                    </a></div>
                <div class="item favourite"><a class="item-link" href="service.php?sid=11">
                        <h2 class="favourite-title">Cinematography</h2>
                        <img src="Assets/Cinematography-2-Medium.jpg" alt="">
                        <div class="favourite-overlay"></div>
                    </a></div>
                <div class="item favourite"><a class="item-link" href="service.php?sid=21">
                        <h2 class="favourite-title">Rechtsberatung</h2>
                        <img src="Assets/Legal-Consulting-Medium.jpg" alt="">
                        <div class="favourite-overlay"></div>
                    </a></div>
                <div class="item favourite"><a class="item-link" href="service.php?sid=70">
                        <h2 class="favourite-title">Coding</h2>
                        <img src="Assets/Coding-1-Medium.jpg" alt="">
                        <div class="favourite-overlay"></div>
                    </a></div>
            </div>
            <div class="button-container">
                <button class="button-previous" onclick="scrollPrevious('favourites-container', favouriteWidth)"><i class="fa fa-chevron-left"></i></button>
                <button class="button-next" onclick="scrollNext('favourites-container', favouriteWidth)"><i class="fa fa-chevron-right"></i></button>
            </div>
        </div>

        <div class="highlight-container">
            <h1 class="highlight-title">Top <light>Dienstleister</light>
            </h1>
            <h2 class="subtitle highlight-subtitle">Volle Kreativität mit Leidenschaft</h2>
            <div class="highlight" id="highlight">
                <div class="highlight-item" id="highlight1">
                    <!-- <h3 class="highlight-item-title">Painter</h3> -->
                    <div class="highlight-img"><img src="Assets/Painter-1-Medium.jpg" alt=""></div>
                    <div class="highlight-info">
                        <h4>Mathew Douglas</h4>
                        <h5>Painter</h5>
                        <div class="highlight-info-grid">
                            <p class="info-title">€50</p>
                            <p class="info-title">1-2</p>
                            <p class="info-subtitle">Price</p>
                            <p class="info-subtitle">Weeks</p>
                        </div>
                        <a href="./profile.php?id=1" class="profile-button">View Profile</a>
                    </div>
                </div>
                <div class="highlight-item">
                    <div class="highlight-img"><img src="Assets/Cooking-1-Medium.jpg" alt=""></div>
                    <div class="highlight-info">
                        <h4>Mathew Douglas</h4>
                        <h5>Chef</h5>
                        <div class="highlight-info-grid">
                            <p class="info-title">€50</p>
                            <p class="info-title">1-2</p>
                            <p class="info-subtitle">Price</p>
                            <p class="info-subtitle">Weeks</p>
                        </div>
                        <a href="./profile.php?id=2" class="profile-button">View Profile</a>
                    </div>
                </div>
                <div class="highlight-item">
                    <div class="highlight-img"></div>
                    <div class="highlight-info">
                        <h4>Mathew Douglas</h4>
                        <h5>Painter</h5>
                        <div class="highlight-info-grid">
                            <p class="info-title">€50</p>
                            <p class="info-title">1-2</p>
                            <p class="info-subtitle">Price</p>
                            <p class="info-subtitle">Weeks</p>
                        </div>
                        <a href="./profile.php?id=2" class="profile-button">View Profile</a>
                    </div>
                </div>
            </div>
            <div class="button-container">
                <button class="button-previous gray" onclick="scrollPrevious('highlight', highlightWidth)"><i class="fa fa-chevron-left"></i></button>
                <button class="button-next gray" onclick="scrollNext('highlight', highlightWidth)"><i class="fa fa-chevron-right"></i></button>
            </div>
        </div>

        <h3 id="catagory-main-title">Entdecke <light>deinen Service</light>
        </h3>
        <div id="catagory-block1" class="catagory-block">
            <div class="catagory-title">
                <h4>Graphik <light>Design</light>
                </h4>
                <a href="./catagory.php?sid=1" class="right">
                    <h4 class="see-all">See All <i class="fa fa-chevron-right"></i></h4>
                </a>
            </div>
            <div id="item-container1" class="item-container">
                <div class="item"><a class="item-link" href="service.php?sid=1">
                        <h2 class="item-title">Logo Design</h2>
                        <img src="Assets/Design-Small.jpg" alt="">
                        <div class="overlay"></div>
                    </a></div>
                <div class="item"><a class="item-link" href="service.php?sid=2">
                        <h2 class="item-title">Web Design</h2>
                        <img src="Assets/Web-Design-1-Small.jpg" alt="">
                        <div class="overlay"></div>
                    </a></div>
                <div class="item"><a class="item-link" href="service.php?sid=3">
                        <h2 class="item-title">Bildbearbeitung</h2>
                        <img src="Assets/Photo-Editing-Small.jpg" alt="">
                        <div class="overlay"></div>
                    </a></div>
                <div class="item"><a class="item-link" href="service.php?sid=4">
                        <h2 class="item-title">Flyer Design</h2>
                        <img src="Assets/Flyer-Design-1-Small.jpg" alt="">
                        <div class="overlay"></div>
                    </a></div>
                <div class="item"><a class="item-link" href="service.php?sid=5">
                        <h2 class="item-title">Visitenkarten</h2>
                        <img src="Assets/Business-Card-1-Small.jpg" alt="">
                        <div class="overlay"></div>
                    </a></div>
                <div class="item"><a class="item-link" href="service.php?sid=6">
                        <h2 class="item-title">Poster Design</h2>
                        <img src="" alt="">
                        <div class="overlay"></div>
                    </a></div>
                <div class="item"><a class="item-link" href="service.php?sid=7">
                        <h2 class="item-title">Buch Design</h2>
                        <img src="" alt="">
                        <div class="overlay"></div>
                    </a></div>
                <div class="item"><a class="item-link" href="service.php?sid=8">
                        <h2 class="item-title">Comic Design</h2>
                        <img src="" alt="">
                        <div class="overlay"></div>
                    </a></div>
                <div class="item"><a class="item-link" href="service.php?sid=9">
                        <h2 class="item-title">Markendesign</h2>
                        <img src="" alt="">
                        <div class="overlay"></div>
                    </a></div>
            </div>
            <div class="button-container">
                <button class="button-previous" onclick="scrollPrevious('item-container1', itemWidth)"><i class="fa fa-chevron-left"></i></button>
                <button class="button-next" onclick="scrollNext('item-container1', itemWidth)"><i class="fa fa-chevron-right"></i></button>
            </div>
        </div>

        <div id="catagory-block2" class="catagory-block grey">
            <div class="catagory-title">
                <h4>Marketing</h4>
                <a href="./catagory.php?sid=2" class="right">
                    <h4 class="see-all">See All <i class="fa fa-chevron-right"></i></h4>
                </a>
            </div>
            <div id="item-container2" class="item-container">
                <div class="item"><a class="item-link" href="service.php?sid=10">
                        <h2 class="item-title">Social Media</h2>
                        <img src="Assets/Social-Media-Small.jpg" alt="">
                        <div class="overlay"></div>
                    </a></div>
                <div id="item1" class="item"><a class="item-link" href="service.php?sid=11">
                        <h2 class="item-title">Cinematography</h2>
                        <img src="Assets/Cinematography-2-Small.jpg" alt="">
                        <div class="overlay"></div>
                    </a></div>
                <div class="item"><a class="item-link" href="service.php?sid=12">
                        <h2 class="item-title">Video Marketing</h2>
                        <img src="Assets/Video-Marketing-Small.jpg" alt="">
                        <div class="overlay"></div>
                    </a></div>
                <div class="item"><a class="item-link" href="service.php?sid=13">
                        <h2 class="item-title">Branding</h2>
                        <img src="Assets/Branding-1-Small.jpg" alt="">
                        <div class="overlay"></div>
                    </a></div>
                <div class="item"><a class="item-link" href="service.php?sid=14">
                        <h2 class="item-title">Online Werbung</h2>
                        <img src="Assets/Digital-Marketing-Small.jpg" alt="">
                        <div class="overlay"></div>
                    </a></div>
                <div class="item"><a class="item-link" href="service.php?sid=15">
                        <h2 class="item-title">Email Marketing</h2>
                        <img src="" alt="">
                        <div class="overlay"></div>
                    </a></div>
                <div class="item"><a class="item-link" href="service.php?sid=16">
                        <h2 class="item-title">Selbst Marketing</h2>
                        <img src="" alt="">
                        <div class="overlay"></div>
                    </a></div>
                <div class="item"><a class="item-link" href="service.php?sid=17">
                        <h2 class="item-title">Strategieentwicklung</h2>
                        <img src="" alt="">
                        <div class="overlay"></div>
                    </a></div>
                <div class="item"><a class="item-link" href="service.php?sid=18">
                        <h2 class="item-title">Musik Promotion</h2>
                        <img src="" alt="">
                        <div class="overlay"></div>
                    </a></div>
                <div class="item"><a class="item-link" href="service.php?sid=19">
                        <h2 class="item-title">Buch Marketing</h2>
                        <img src="" alt="">
                        <div class="overlay"></div>
                    </a></div>
            </div>
            <div class="button-container">
                <button class="button-previous" onclick="scrollPrevious('item-container2', itemWidth)"><i class="fa fa-chevron-left"></i></button>
                <button class="button-next" onclick="scrollNext('item-container2', itemWidth)"><i class="fa fa-chevron-right"></i></button>
            </div>
        </div>

        <div id="catagory-block3" class="catagory-block">
            <div class="catagory-title">
                <h4>Recht <light>und Beratung</light>
                </h4>
                <a href="./catagory.php?sid=3" class="right">
                    <h4 class="see-all">See All <i class="fa fa-chevron-right"></i></h4>
                </a>
            </div>
            <div id="item-container3" class="item-container">
                <div class="item"><a class="item-link" href="service.php?sid=20">
                        <h2 class="item-title">Steuerberater</h2>
                        <img src="Assets/Tax-Small.jpg" alt="">
                        <div class="overlay"></div>
                    </a></div>
                <div class="item"><a class="item-link" href="service.php?sid=21">
                        <h2 class="item-title">Rechtsberatung</h2>
                        <img src="Assets/Legal-Consulting-Small.jpg" alt="">
                        <div class="overlay"></div>
                    </a></div>
                <div class="item"><a class="item-link" href="service.php?sid=22">
                        <h2 class="item-title">Anwälte</h2>
                        <img src="Assets/Lawyer-1-Small.jpg" alt="">
                        <div class="overlay"></div>
                    </a></div>
                <div class="item"><a class="item-link" href="service.php?sid=23">
                        <h2 class="item-title">Ernärungsberatung</h2>
                        <img src="Assets/Nutrition-1-Small.jpg" alt="">
                        <div class="overlay"></div>
                    </a></div>
                <div class="item"><a class="item-link" href="service.php?sid=24">
                        <h2 class="item-title">Finanzberater</h2>
                        <img src="Assets/Financial-Advisor-Small.jpg" alt="">
                        <div class="overlay"></div>
                    </a></div>
                <div class="item"><a class="item-link" href="service.php?sid=25">
                        <h2 class="item-title">Job Beratung</h2>
                        <img src="" alt="">
                        <div class="overlay"></div>
                    </a></div>
                <div class="item"><a class="item-link" href="service.php?sid=26">
                        <h2 class="item-title">Unternahmensberatung</h2>
                        <img src="" alt="">
                        <div class="overlay"></div>
                    </a></div>
                <div class="item"><a class="item-link" href="service.php?sid=27">
                        <h2 class="item-title">Erziehungsberatung</h2>
                        <img src="" alt="">
                        <div class="overlay"></div>
                    </a></div>
                <div class="item"><a class="item-link" href="service.php?sid=28">
                        <h2 class="item-title">Immobilien Beratung</h2>
                        <img src="" alt="">
                        <div class="overlay"></div>
                    </a></div>
                <div class="item"><a class="item-link" href="service.php?sid=29">
                        <h2 class="item-title">Reiseberatung</h2>
                        <img src="" alt="">
                        <div class="overlay"></div>
                    </a></div>
            </div>
            <div class="button-container">
                <button class="button-previous" onclick="scrollPrevious('item-container3', itemWidth)"><i class="fa fa-chevron-left"></i></button>
                <button class="button-next" onclick="scrollNext('item-container3', itemWidth)"><i class="fa fa-chevron-right"></i></button>
            </div>
        </div>

        <div id="collapsible-content" class="collapsible-content">
            <div id="catagory-block4" class="catagory-block grey">
                <div class="catagory-title">
                    <h4>Bildung</h4>
                    <a href="./catagory.php?sid=4" class="right">
                        <h4 class="see-all">See All <i class="fa fa-chevron-right"></i></h4>
                    </a>
                </div>
                <div id="item-container4" class="item-container">
                    <div class="item"><a class="item-link" href="service.php?sid=30">
                            <h2 class="item-title">Nachhlife</h2>
                            <img src="Assets/Tutoring-1-Small.jpg" alt="">
                            <div class="overlay"></div>
                        </a></div>
                    <div class="item"><a class="item-link" href="service.php?sid=31">
                            <h2 class="item-title">Seminare</h2>
                            <img src="Assets/Seminar-Small.jpg" alt="">
                            <div class="overlay"></div>
                        </a></div>
                    <div class="item"><a class="item-link" href="service.php?sid=32">
                            <h2 class="item-title">Lernkurse</h2>
                            <img src="Assets/Learning-1-Small.jpg" alt="">
                            <div class="overlay"></div>
                        </a></div>
                    <div class="item"><a class="item-link" href="service.php?sid=33">
                            <h2 class="item-title">Sprachkurse</h2>
                            <img src="Assets/Language-1-Small.jpg" alt="">
                            <div class="overlay"></div>
                        </a></div>
                    <div class="item"><a class="item-link" href="service.php?sid=34">
                            <h2 class="item-title">Musikkurse</h2>
                            <img src="Assets/Music-Lesson-Small.jpg" alt="">
                            <div class="overlay"></div>
                        </a></div>
                    <div class="item"><a class="item-link" href="service.php?sid=35">
                            <h2 class="item-title"></h2>
                            <img src="" alt="">
                            <div class="overlay"></div>
                        </a></div>
                    <div class="item"><a class="item-link" href="service.php?sid=36">
                            <h2 class="item-title"></h2>
                            <img src="" alt="">
                            <div class="overlay"></div>
                        </a></div>
                    <div class="item"><a class="item-link" href="service.php?sid=37">
                            <h2 class="item-title"></h2>
                            <img src="" alt="">
                            <div class="overlay"></div>
                        </a></div>
                    <div class="item"><a class="item-link" href="service.php?sid=38">
                            <h2 class="item-title"></h2>
                            <img src="" alt="">
                            <div class="overlay"></div>
                        </a></div>
                    <div class="item"><a class="item-link" href="service.php?sid=39">
                            <h2 class="item-title"></h2>
                            <img src="" alt="">
                            <div class="overlay"></div>
                        </a></div>
                </div>
                <div class="button-container">
                    <button class="button-previous" onclick="scrollPrevious('item-container4', itemWidth)"><i class="fa fa-chevron-left"></i></button>
                    <button class="button-next" onclick="scrollNext('item-container4', itemWidth)"><i class="fa fa-chevron-right"></i></button>
                </div>
            </div>

            <div id="catagory-block5" class="catagory-block">
                <div class="catagory-title">
                    <h4>Unternehmen</h4>
                    <a href="./catagory.php?sid=5" class="right">
                        <h4 class="see-all">See All <i class="fa fa-chevron-right"></i></h4>
                    </a>
                </div>
                <div id="item-container5" class="item-container">
                    <div class="item"><a class="item-link" href="service.php?sid=40">
                        <h2 class="item-title">Buchhaltung</h2>
                        <img src="Assets/Accounting-1-Small.jpg" alt="">
                        <div class="overlay"></div>
                    </a></div>
                    <div class="item"><a class="item-link" href="service.php?sid=41">
                        <h2 class="item-title">Kundenakquise</h2>
                        <img src="Assets/Seminar-Small.jpg" alt="">
                        <div class="overlay"></div>
                    </a></div>
                    <div class="item"><a class="item-link" href="service.php?sid=42">
                        <h2 class="item-title">Marktanalysen</h2>
                        <img src="Assets/Market-Research-Small.jpg" alt="">
                        <div class="overlay"></div>
                    </a></div>
                    <div class="item"><a class="item-link" href="service.php?sid=43">
                        <h2 class="item-title">Sales</h2>
                        <img src="Assets/Sales-1-Small.jpg" alt="">
                        <div class="overlay"></div>
                    </a></div>
                    <div class="item"><a class="item-link" href="service.php?sid=44">
                        <h2 class="item-title">Presentations</h2>
                        <img src="Assets/Presentation-1-Small.jpg" alt="">
                        <div class="overlay"></div>
                    </a></div>
                    <div class="item"><a class="item-link" href="service.php?sid=45">
                        <h2 class="item-title">Project Management</h2>
                        <img src="Assets/Project-Management-Small.jpg" alt="">
                        <div class="overlay"></div>
                    </a></div>
                    <div class="item"><a class="item-link" href="service.php?sid=46">
                        <h2 class="item-title">Legal Consulting</h2>
                        <img src="Assets/Legal-Consulting-Small.jpg" alt="">
                        <div class="overlay"></div>
                    </a></div>
                    <div class="item"><a class="item-link" href="service.php?sid=47">
                        <h2 class="item-title">Business Consulting Unternehmensberatung</h2>
                        <img src="Assets/Legal-Consulting-Small.jpg" alt="">
                        <div class="overlay"></div>
                    </a></div>
                    <div class="item"><a class="item-link" href="service.php?sid=48">
                        <h2 class="item-title">Sales Strategies Vertriebsstrategien</h2>
                        <img src="Assets/Legal-Consulting-Small.jpg" alt="">
                        <div class="overlay"></div>
                    </a></div>
                    <div class="item"><a class="item-link" href="service.php?sid=49">
                        <h2 class="item-title">E-Commerce</h2>
                        <img src="Assets/Trading-1-Small.jpg" alt="">
                        <div class="overlay"></div>
                    </a></div>
                </div>
                <div class="button-container">
                    <button class="button-previous" onclick="scrollPrevious('item-container5', itemWidth)"><i class="fa fa-chevron-left"></i></button>
                    <button class="button-next" onclick="scrollNext('item-container5', itemWidth)"><i class="fa fa-chevron-right"></i></button>
                </div>
            </div>

            <div id="catagory-block6" class="catagory-block grey">
                <div class="catagory-title">
                    <h4>Sport <light>und Lifestyle</light>
                    </h4>
                    <a href="./catagory.php?sid=6" class="right">
                        <h4 class="see-all">See All <i class="fa fa-chevron-right"></i></h4>
                    </a>
                </div>
                <div id="item-container6" class="item-container">
                    <div class="item"><a class="item-link" href="">
                            <h2 class="item-title">Fitnesskurse</h2>
                            <img src="Assets/Personal-Training-Small.jpg" alt="">
                            <div class="overlay"></div>
                        </a></div>
                    <div class="item"><a class="item-link" href="">
                            <h2 class="item-title">Gaming</h2>
                            <img src="Assets/Gaming-1-Small.jpg" alt="">
                            <div class="overlay"></div>
                        </a></div>
                    <div class="item"><a class="item-link" href="">
                            <h2 class="item-title">Bastel</h2>
                            <img src="Assets/Crafts-1-Small.jpg" alt="">
                            <div class="overlay"></div>
                        </a></div>
                    <div class="item"><a class="item-link" href="">
                            <h2 class="item-title">Kochkurse</h2>
                            <img src="Assets/Cooking-1-Small.jpg" alt="">
                            <div class="overlay"></div>
                        </a></div>
                    <div class="item"><a class="item-link" href="">
                            <h2 class="item-title">Kunstkurse</h2>
                            <img src="Assets/Modeling-1-Small.jpg" alt="">
                            <div class="overlay"></div>
                        </a></div>
                    <div class="item"></div>
                    <div class="item"></div>
                    <div class="item"></div>
                    <div class="item"></div>
                    <div class="item"></div>
                </div>
                <div class="button-container">
                    <button class="button-previous" onclick="scrollPrevious('item-container6', itemWidth)"><i class="fa fa-chevron-left"></i></button>
                    <button class="button-next" onclick="scrollNext('item-container6', itemWidth)"><i class="fa fa-chevron-right"></i></button>
                </div>
            </div>

            <div id="catagory-block7" class="catagory-block">
                <div class="catagory-title">
                    <h4>Gesundheit</h4>
                    <a href="./catagory.php?sid=7" class="right">
                        <h4 class="see-all">See All <i class="fa fa-chevron-right"></i></h4>
                    </a>
                </div>
                <div id="item-container7" class="item-container">
                    <div class="item"></div>
                    <div class="item"></div>
                    <div class="item"></div>
                    <div class="item"></div>
                    <div class="item"></div>
                    <div class="item"></div>
                    <div class="item"></div>
                    <div class="item"></div>
                    <div class="item"></div>
                    <div class="item"></div>
                </div>
                <div class="button-container">
                    <button class="button-previous" onclick="scrollPrevious('item-container7', itemWidth)"><i class="fa fa-chevron-left"></i></button>
                    <button class="button-next" onclick="scrollNext('item-container7', itemWidth)"><i class="fa fa-chevron-right"></i></button>
                </div>
            </div>

            <div id="catagory-block8" class="catagory-block grey">
                <div class="catagory-title">
                    <h4>Programmierung <light>und IT</light>
                    </h4>
                    <a href="./catagory.php?sid=8" class="right">
                        <h4 class="see-all">See All <i class="fa fa-chevron-right"></i></h4>
                    </a>
                </div>
                <div id="item-container8" class="item-container">
                    <div class="item"><a class="item-link" href="">
                            <h2 class="item-title">Coding</h2>
                            <img src="Assets/Coding-1-Small.jpg" alt="">
                            <div class="overlay"></div>
                        </a></div>
                    <div class="item"><a class="item-link" href="">
                            <h2 class="item-title">UX Design</h2>
                            <img src="Assets/UX-Design-2-Small.jpg" alt="">
                            <div class="overlay"></div>
                        </a></div>
                    <div class="item"><a class="item-link" href="">
                            <h2 class="item-title">Wordpress</h2>
                            <img src="Assets/Wordpress-Small.jpg" alt="">
                            <div class="overlay"></div>
                        </a></div>
                    <div class="item"><a class="item-link" href="">
                            <h2 class="item-title">Website Aufbau</h2>
                            <img src="Assets/Web-Design-1-Small.jpg" alt="">
                            <div class="overlay"></div>
                        </a></div>
                    <div class="item"><a class="item-link" href="">
                            <h2 class="item-title">Spielentwicklung</h2>
                            <img src="Assets/Gaming-2-Small.jpg" alt="">
                            <div class="overlay"></div>
                        </a></div>
                    <div class="item"></div>
                    <div class="item"></div>
                    <div class="item"></div>
                    <div class="item"></div>
                    <div class="item"></div>
                </div>
                <div class="button-container">
                    <button class="button-previous" onclick="scrollPrevious('item-container8', itemWidth)"><i class="fa fa-chevron-left"></i></button>
                    <button class="button-next" onclick="scrollNext('item-container8', itemWidth)"><i class="fa fa-chevron-right"></i></button>
                </div>
            </div>
        </div>
        <button id="collapsible" class="collapsible">Show More</button>


        <div class="advantages-container">
            <h4 class="advantages-title">Ihre Vorteile <light>auf einem Blick:</light>
            </h4>
            <div class="advantages-flex">
                <div class="advantages-img">
                    <img src="Assets/Presentation-1-Medium.jpg" alt="">
                </div>
                <ul>
                    <li>Riesige Auswahl aus den besten Firman und Freiberuflichen deutschlandweit</li>
                    <li>Komplette Wertschöpfungskette von der ersten eigenen Website bus zur Unternehmensberatung</li>
                    <li>Mehr Flexibilität und transparenz durch online Dienstleistungen</li>
                    <li>Zeitsparen durch die Suchfunktion</li>
                </ul>
            </div>
        </div>

        <div id="review1" class="reviews-container">
            <h4 class="back-to-top" onclick="topFunction()">Back to top <i class="fa fa-arrow-up"></i></h4>
            <h3 class="review-title">Rezensionen:</h3>
            <div class="review-grid">
                <div class="review review-one">
                    <h2>Title</h3>
                        <p>“Lorem ipsum dolor, sit amet consectetur adipisicing elit. Consectetur possimus non culpa! Adipisci dignissimos rerum assumenda tempora iusto sed debitis dolorem iste esse, culpa aperiam, id”</p>
                        <h3>Mathew Douglas</h3>
                </div>
                <div class="review review-two">
                    <h2>Title</h3>
                        <p>“Diese website bietet eine super Möglichkeit schnell und einfach einen passenden zu finden um mein Unternehmen weiter zu einwickeln”</p>
                        <h3>Mathew Douglas</h3>
                </div>
                <div class="review review-three">
                    <h2>Title</h3>
                        <p>“Lorem ipsum dolor sit amet consectetur adipisicing elit. Eveniet cum, eos ullam quibusdam modi dolorum.”</p>
                        <h3>Mathew Douglas</h3>
                </div>
                <div class="review review-four">
                    <h2>Title</h3>
                        <p>“Lorem ipsum, dolor sit amet consectetur adipisicing elit. Nesciunt cupiditate porro fugiat voluptates, ipsa minus numquam veniam distinctio. Obcaecati nemo ipsam eaque officia maxime repudiandae quod atque velit.”</p>
                        <h3>Mathew Douglas</h3>
                </div>
                <div class="review review-five">
                    <h2>Title</h3>
                        <p>“Lorem ipsum dolor sit amet consectetur adipisicing elit. Enim, perferendis.”</p>
                        <h3>Mathew Douglas</h3>
                </div>
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
    </div>
</body>

</html>