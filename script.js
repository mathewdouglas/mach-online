var mobile;
var itemWidth;
var highlightWidth;
var favouriteWidth;
var scrollFlag = false;
// var ele;

let root = document.querySelector(':root');

// Check if in mobile or desktop mode on window load
window.onload = function(){
    if(window.innerWidth < 480) {
        mobile = true;
    } else {
        mobile = false;
    }
    console.log(mobile);

    showHideLoginStatus();

    try {
        itemWidth = document.getElementsByClassName("item")[0].offsetWidth;
        highlightWidth = document.getElementById("highlight1").offsetWidth /*+ 50*/;
        favouriteWidth = document.getElementById("favourite1").offsetWidth + 90;

        setScrollZero('favourites-container');   
        setScrollZero('highlight');
        setScrollZero('item-container1');
        setScrollZero('item-container2');   
        setScrollZero('item-container3');   
        setScrollZero('item-container4');   
        setScrollZero('item-container5');   
        setScrollZero('item-container6');   
        setScrollZero('item-container7');   
        setScrollZero('item-container8');           
        
        var colElem = document.getElementById("collapsible");
        colElem.addEventListener("click", function() {
            this.classList.toggle("active");
            var content = document.getElementById("collapsible-content");
            if (content.style.maxHeight){
                content.style.maxHeight = null;
                window.scrollBy(0, -1 * content.scrollHeight);
                colElem.innerText = "Show More";
            } else {
                content.style.maxHeight = content.scrollHeight + "px";
                colElem.innerText = "Show Less";
            } 
        });
    } catch (error) {
        console.log(error);
    }

    

}

function setScrollZero(element) {
    document.getElementById(element).scrollTo({
        left: 0
    });
}

function _calculateScrollbarWidth() {
    document.documentElement.style.setProperty(
        "--scrollbar-width",
        window.innerWidth - document.documentElement.clientWidth + "px"
    );
}

// recalculate on resize
window.addEventListener("resize", _calculateScrollbarWidth, false);
// recalculate on dom load
document.addEventListener("DOMContentLoaded", _calculateScrollbarWidth, false);
// recalculate on load (assets loaded as well)
window.addEventListener("load", _calculateScrollbarWidth);



// Moves the viewport to the top of the website
function topFunction() {
    document.body.scrollTop = 0; // For Safari
    document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
}




var mql = window.matchMedia('(max-width: 480px)');

mql.addEventListener( "change", (e) => {
    if (e.matches) {
    /* the viewport is 480 pixels wide or less */
    mobile = true;
    console.log(mobile);
  } else {
    /* the viewport is more than than 480 pixels wide */
    mobile = false;
    console.log(mobile);
  }
})







// When the user scrolls down 450px from the top of the document, resize the header's font size
window.onscroll = function () {
    scrollFunction();
};

function scrollFunction() {
    // Checks if the website is in desktop mode
    if (mobile == false) {

        // Checks how far the page has been scrolled
        if (document.body.scrollTop > 330 || document.documentElement.scrollTop > 300) {
            // The website is in desktop mode and the page has been scrolled past 330px
            // Hide search bar in search box and show in header
            document.getElementById("search-bar").style.display = "block";
            if (!scrollFlag) {
                checkSearchField("search-bar", "livesearch");
                scrollFlag = true;
            }
        } else {
            // Display the search bar in the search box as per usual
            document.getElementById("search-bar").style.display = "none";
            document.getElementById("livesearch").style.display = "none";

            if (scrollFlag) {
                scrollFlag = false;
            }
        }
    }
}



// var reviewElement = document.getElementById('review1');
// var leftPos = reviewElement.offsetLeft;
// console.log(leftPos);



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




/* Make item list draggable*/
// Buggy and very jittery

// let pos = { left: 0, x: 0 };


// const mouseDownHandler = function(e) {
//     pos = {
//         // The current scroll 
//         left: ele.scrollLeft,
//         // Get the current mouse position
//         x: e.clientX,
//     };

//     document.addEventListener('mousemove', mouseMoveHandler);
//     document.addEventListener('mouseup', mouseUpHandler);
// };

// const mouseMoveHandler = function(e) {
//     // How far the mouse has been moved
//     const dx = e.clientX - pos.x;

//     // Scroll the element
//     ele.scrollBy({
//         left: pos.left - dx,
//         behavior: "smooth"
//     });

//     // Change the cursor and prevent user from selecting the text
//     ele.style.cursor = 'grabbing';
//     ele.style.userSelect = 'none'
// };

// const mouseUpHandler = function() {
//     ele.style.cursor = 'grab';
//     ele.style.removeProperty('user-select');
//     document.removeEventListener('mousemove', mouseMoveHandler);
// };