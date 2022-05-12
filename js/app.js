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
document.getElementById("btn-signUp").addEventListener("click", function(e) {
    e.preventDefault();
    document.getElementById("homepage").style.display="none";
    document.getElementById("signUp").style.display="block";
});


//replace signup content with pollForm content
const personForm = document.getElementById("select-person");
personForm.addEventListener("submit", function(e) {
    e.preventDefault();
    const formData = new FormData(personForm);
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "/vote.php", true);
    xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
    xhr.send(JSON.stringify({
        action: "select-person",
        data: {
            id: formData.get("person")
        }
    }));
    xhr.onreadystatechange = function() {
        if(xhr.readyState === 4) {
            var data = JSON.parse(xhr.responseText);
            console.log(data);
            if(data.success == true) {
                if(data.data.form != "undefined") {
                    var form = document.getElementById("submit-vote");
                    form.innerHTML = data.data.form;
                }
                if(data.data.name != "undefined") {
                    var name = document.getElementById("participant");
                    name.innerHTML = data.data.name;
                }
            }
            document.getElementById("signUp").style.display="none";
            document.getElementById("poll").style.display="block";
        }
    };
});





