<?php

session_start();

$db_host = "host";
$db_user = "user"; //database username
$db_pass = "pass"; //database password
$db_name = "name"; //database name

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";

if(!isset($_SESSION['username'])){
    header("Location:index.php");
}

?>

<!DOCTYPE html>
<!--App: atosystem-->
<!--Company: atoinsurance-->
<!--Dev: rtroulak-->
<!--Date: 4/1/2019-->
<html lang="en" >
<head>
    <meta charset="UTF-8">
    <title>aToSystem</title>


    <link rel='stylesheet prefetch' href='https://fonts.googleapis.com/css?family=Open+Sans:600'>
    <link rel="stylesheet" href="./assets/css/style.css">

</head>
<body>
<div class="login-wrap">
    <div class="login-html">
        <h1 style="color:white" align="center">ATOSystem</h1>
        <br>
        <br>
        <input id="tab-1" type="radio" name="tab" class="sign-in" checked><label for="tab-1" class="tab">Αναζητηση</label>
        <input id="tab-2" type="radio" name="tab" class="sign-up"><label for="tab-2" class="tab">Εισαγωγη</label>
        <div class="login-form">
            <form class="sign-in-htm" action="./api/user/login.php" method="GET">
                <div class="group">
                    <label for="user" class="label">Πελατης</label>
                    <input id="username" name="username" type="text" class="input">
                </div>
                <!--<div class="group">-->
                    <!--<label for="pass" class="label">Password</label>-->
                    <!--<input id="password" name="password" type="password" class="input" data-type="password">-->
                <!--</div>-->
                <!--<div class="group">-->
                    <!--<input id="check" type="checkbox" class="check" checked>-->
                    <!--<label for="check"><span class="icon"></span> Keep me Signed in</label>-->
                <!--</div>-->
                <div class="group">
                    <input type="submit" class="button" value="Αναζητηση Πελατη">
                </div>
                <div class="hr"></div>
                <!--<div class="foot-lnk">-->
                    <!--<a href="#forgot">Forgot Password?</a>-->
                <!--</div>-->
            </form>
            <form class="sign-up-htm" action="./api/user/signup.php" method="POST">
                <div class="group">
                    <label for="user" class="label">ONOMA</label>
                    <input id="firstname" name="firstname" type="text" class="input">
                </div>
                <div class="group">
                    <label for="user" class="label">EΠΩΝΥΜΟ</label>
                    <input id="lastname" name="lastname" type="text" class="input">
                </div>
                <div class="group">
                    <label for="user" class="label">EMAIL</label>
                    <input id="email" name="email" type="email" class="input">
                </div>
                <div class="group">
                    <label for="user" class="label">ΔΙΕΥΘΥΝΣΗ</label>
                    <input id="address" name="address" type="text" class="input">
                </div>
                <div class="group">
                    <label for="car" class="label">ΑΜΑΞΙ</label>
                    <input id="car" name="car" type="text" class="input">
                </div>
                <div class="group">
                    <label for="car" class="label">ΚΥΒΙΣΜΟΣ</label>
                    <input id="carcc" name="carcc" type="text" class="input">
                </div>
                <div class="group">
                    <label for="car" class="label">ΠΙΝΑΚΙΔΑ</label>
                    <input id="carid" name="carid" type="email" class="input">
                </div>

                <!--<div class="group">-->
                    <!--<label for="pass" class="label">Password</label>-->
                    <!--<input id="password" name="password" type="password" class="input" data-type="password">-->
                <!--</div>-->
                <!--<div class="group">-->
                    <!--<label for="pass" class="label">Confirm Password</label>-->
                    <!--<input id="pass" type="password" class="input" data-type="password">-->
                <!--</div>-->
                <div class="group">
                    <input type="submit" class="button" value="ΕΙΣΑΓΩΓΗ">
                </div>
                <div class="hr"></div>
                <!--<div class="foot-lnk">-->
                    <!--<label for="tab-1">Already Member?</a>-->
                <!--</div>-->
            </form>
        </div>
    </div>
</div>


</body>
</html>