// Live Search

function checkSearchField(input, output) {
    if (document.getElementById(input).value === "") {
        document.getElementById(output).style.display = "none";
        document.getElementById(output).innerHTML = "";
    } else {
        document.getElementById(output).style.display = "block";
    }
}

function showResult(str, input, output) {
    checkSearchField(input, output);
    if (str.length == 0) {
        // document.getElementById("livesearch").innerHTML="";
        // document.getElementById("livesearch").style.border="0px";
        return;
    }
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            response = this.responseText;
            responseArray = response.split(":");
            if (responseArray[1] == 0) {
                document.getElementById(output).innerHTML = responseArray[0];
            } else {
                document.getElementById(output).innerHTML = "<a href='service.php?sid="+responseArray[1]+"'>"+responseArray[0]+"</a>";
            }
        }
    };
    xmlhttp.open("GET", "livesearch.php?q=" + str, true);
    xmlhttp.send();
}