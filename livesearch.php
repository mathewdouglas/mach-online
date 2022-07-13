<?php
session_start();
include "db_connection.php";
    
    $q=$_GET["q"];
    
//Get records from the detention table
 	$query = "SELECT * FROM odfu_services WHERE service_title LIKE '%$q%'";
	$result = mysqli_query($connection, $query);

    $row = mysqli_fetch_assoc($result);

    if ($row['service_title']=="") {
        $response="No service found:0";
        echo $response;
        exit();
    }

    echo $row['service_title'].':'.$row['id'];
    exit();
?>

<!-- Test -->

<!-- <form action="service.php" method="post" name="searchform" class="">
    <input type="text" name="" id="search-bar" class="text-box" placeholder="Suche..." onkeyup="showResult(this.value, 'search-bar', 'livesearch')">            
    <input type="submit" id="search-btn" class="search-btn" value="search">
</form>
<div id="livesearch"></div>

<form action="service.php" method="post" name="searchform1" class="">
    <input type="text" name="" id="search-bar1" class="text-box" placeholder="Suche..." onkeyup="showResult(this.value, 'search-bar1', 'livesearch1')">            
    <input type="submit" id="search-btn1" class="search-btn" value="search">
</form>
<div id="livesearch1"></div> -->

<!-- <script>
    function showResult(str, input, output) {
  			if (str.length == 0) { 
    			// document.getElementById("livesearch").innerHTML="";
    			// document.getElementById("livesearch").style.border="0px";
    			return;
  			}
  			if (window.XMLHttpRequest) {
    			// code for IE7+, Firefox, Chrome, Opera, Safari
    			xmlhttp = new XMLHttpRequest();
  			} else {  // code for IE6, IE5
    			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
  			}
  			xmlhttp.onreadystatechange=function() {
    			if (this.readyState == 4 && this.status == 200) {
                    response = this.responseText;
      				document.getElementById(output).innerHTML = response;
    			}
  			}
  			xmlhttp.open("GET", "livesearch.php?q=" + str, true);
  			xmlhttp.send();
        }

        // (function () {
        //     var element = document.getElementById(output),
		// 		nameDiv = document.getElementById(input);

        //     element.addEventListener('click', function (e) {
        //         // TODO redirect to service page
        //         e.preventDefault();
        //     });
        // })();
</script> -->