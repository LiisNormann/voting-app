<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Make your pick</title>
    <link href="css/style.css" rel="stylesheet">
    <!-- Fontawesome icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- Materialize -->
    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

    <!-- JS -->
    <script src="js/app.js"></script>

</head>

<body>

<?php include 'header.php'; ?>

<div class="container">
    <!-- HOMEPAGE -->
    <div id="homepage" style="display:block">
        <h1>Welcome to our poll</h1>
        <p>The time has finally come for all of you lovely students to answer the ultimate question!</p>
        <h5>Are you ready for this? ARE YOU REALLY?</h5>
        <div>
            <button class="button-home" type="submit" onclick="replace_home()">I am READY!</button>
        </div>
    </div>

    <!-- SIGN UP FORM -->
    <div id="signUp" class="container" style="display:none">
        <div class="container signUpForm">
            <h2>Poll Sign Up</h2>
            <p>Please fill out your name below before you can answer the question of the century!</p>

            <form>
                <div class="row">
                    <div class="col-25">
                        <label for="fname">First Name</label>
                    </div>
                    <div class="col-75">
                        <input type="text" id="fname" name="firstname" placeholder="Your name..">
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                        <label for="lname">Last Name</label>
                    </div>
                    <div class="col-75">
                        <input type="text" id="lname" name="lastname" placeholder="Your last name..">
                    </div>
                </div>
                <br>
                <div class="row">
                    <input type="submit" value="To the Poll">
                </div>
            </form>
        </div>
    </div>

    <!-- POLL -->
    <div id="poll" style="display:none">
        <form>

        </form>
    </div>
</div>
</body>
</html>

