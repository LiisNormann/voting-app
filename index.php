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
        <h1>Welcome to the poll</h1>
        <br>
        <h5>The time has finally come for all of you lovely students to answer the ultimate question!</h5>
        <h4>Are you ready for this? ARE YOU REALLY?</h4>
        <br>
        <div>
            <button class="button-home" type="submit" onclick="replace_home()">I am READY!</button>
        </div>
    </div>

    <!-- SIGN UP FORM -->
    <div id="signUp" class="container" style="display:none">
        <div class="container signUpForm">
            <h2>Poll Sign Up</h2>
            <p>In order to take part in the survey, you first had to sign up for it. If so then you shall find your name in the dropdown below.</p>
            <p>Once you have found your name on the list and press the button to continue to the poll you will have 5 minutes to pick your answer to a simple agree /disagree question.</p>
            <p>During those 5 minutes you can change your answer as many times as you like. But once the time runs out, any changes you make will be disregarded.</p>

            <form action="/action_page.php">
                <div class="input-field">
                    <label for="poll">Materialize Select</label>
                    <select id="poll">
                        <option value="" disabled selected>Choose your option</option>
                        <option value="1">Option 1</option>
                        <option value="2">Option 2</option>
                        <option value="3">Option 3</option>
                    </select>
                </div>
                <br>
                <div class="row">
                    <input type="submit" value="To the Poll" onclick="replace_signUp()">
                </div>
            </form>
        </div>
    </div>

    <!-- POLL -->
    <div id="poll" style="display:none">
            <div class="container pollForm">
                <h2>The poll</h2>
                <p>You now have 5 minutes to pick your answer! You must choose whether you agree or disagree with the question below.</p>
                <p>Keep in mind that once the time runs out - you can no longer change your answer!</p>
                <br>
                <h3>The question is: should homework at school be banned?</h3>
                <br>
                <form action="#">
                    <p>
                        <label>
                            <input name="agree" type="radio" />
                            <span>Agree</span>
                        </label>
                    </p>
                    <p>
                        <label>
                            <input name="disagree" type="radio" />
                            <span>Disagree</span>
                        </label>
                    </p>
                    <br>
                    <div class="row">
                        <input type="submit" value="To the Poll">
                    </div>
                </form>
            </div>
    </div>
</div>
</body>
</html>

