/* Toggle between adding and removing the "responsive" class to topnav when the user clicks on the icon */
function myFunction() {
    var x = document.getElementById("myTopnav");
    if (x.className === "topnav") {
        x.className += " responsive";
    } else {
        x.className = "topnav";
    }
}

//replace homepage content with signUp content
function replace_home() {
    document.getElementById("homepage").style.display="none";
    document.getElementById("signUp").style.display="block";
}

//replace signup content with pollForm content
function replace_signUp() {
    document.getElementById("signUp").style.display="none";
    document.getElementById("poll").style.display="block";
}

