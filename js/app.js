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

//replace poll content with poll-after content
const pollForm = document.getElementById("submit-vote");
pollForm.addEventListener("submit", function(e) {
    e.preventDefault();
    const formData = new FormData(pollForm);

    if(formData.get("position") != "poolt" && formData.get("position") != "vastu" )
        return;

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "/vote.php", true);
    xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
    xhr.send(JSON.stringify({
        action: "vote",
        data: {
            id: formData.get("person"),
            vote: formData.get("position")
        }
    }));
    xhr.onreadystatechange = function() {
        if(xhr.readyState === 4) {
            var data = JSON.parse(xhr.responseText);
            console.log(data);
            if(data.success == true) {

            }
            document.getElementById("poll").style.display="none";
            document.getElementById("poll-after").style.display="block";
        }
    };
});

//replace poll-after content with poll-after content
document.getElementById("btn-change").addEventListener("click", function(e) {
    e.preventDefault();
    document.getElementById("poll-after").style.display="none";
    document.getElementById("poll").style.display="block";
});

//replace poll-after content with endpage content
document.getElementById("btn-result").addEventListener("click", function(e) {
    e.preventDefault();

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "/vote.php", true);
    xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
    xhr.send(JSON.stringify({
        action: "results",
    }));
    xhr.onreadystatechange = function() {
        if(xhr.readyState === 4) {
            var data = JSON.parse(xhr.responseText);
            console.log(data);
            if(data.success == true) {
                if(data.data.form != "undefined") {
                    var form = document.getElementById("results");
                    form.innerHTML = data.data.form;
                    var pie = new pieChart( {
                        canvas: "pie",
                        data: data.data.data,
                        colors: ["#fde23e", "#f16e23"]
                    });
                    pie.draw();
                }
                if(data.data.name != "undefined") {
                    var name = document.getElementById("participant");
                    name.innerHTML = data.data.name;
                }
            }
            document.getElementById("poll-after").style.display="none";
            document.getElementById("endpage").style.display="block";
        }
    };
});

function drawPieSlice(ctx, centerX, centerY, radius, start, end, color) {
    ctx.fillStyle = color;
    ctx.beginPath();
    ctx.moveTo(centerX, centerY);
    ctx.arc(centerX, centerY, radius, start, end);
    ctx.closePath();
    ctx.fill();
}

var pieChart = function(options) {
    this.options = options;
    this.canvas = document.getElementById(options.canvas);
    console.log(this.canvas);
    this.ctx = this.canvas.getContext("2d");
    this.colors = options.colors;

    this.draw = function() {
        var totalValue = 0;
        var colorIndex = 0;
        for(var category in this.options.data) {
            var val = this.options.data[category];
            totalValue += parseInt(val);
        }
        console.log(totalValue, this.options.data);
        var startAngle = 0;
        for(var category in this.options.data) {
            val = this.options.data[category];
            sliceAngle = 2 * Math.PI * val / totalValue;
            var pieRadius = Math.min(this.canvas.width / 2, this.canvas.height / 2);
            var labelX = this.canvas.width / 2 + (pieRadius / 2) * Math.cos(startAngle + sliceAngle / 2);
            var labelY = this.canvas.height / 2 + (pieRadius / 2) * Math.cos(startAngle + sliceAngle / 2);

            drawPieSlice(
                this.ctx,
                this.canvas.width / 2,
                this.canvas.height / 2,
                Math.min(this.canvas.width / 2, this.canvas.height / 2),
                startAngle,
                startAngle + sliceAngle,
                this.colors[colorIndex % this.colors.length]
            );

            var labelText = val;
            this.ctx.fillStyle = "black";
            this.ctx.font = "bold 20px Arial";
            this.ctx.fillText(labelText + " " + category, labelX, labelY);
            startAngle += sliceAngle;
            colorIndex++;
        }
    }
}







