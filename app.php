<?php

session_start();
header('Content-Type: text/html; charset=utf-8');
require_once "db_vars.php";
require_once "functions.php";

// Create connection
$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
mysqli_set_charset($conn, "utf8");

if($_POST['username']){
    unset($_COOKIE['username']);
    unset($_COOKIE['password']);
}


if(!isset($_COOKIE['username'])) {
        $username = defSqlInjection($_POST['username']);
        $password = defSqlInjection($_POST['password']);
        $cookie_username="username";
        $cookie_password="password";
}
else{
     $username = $_COOKIE['username'];
     $password = $_COOKIE['password'];
}

$sql = "SELECT * FROM `users` WHERE username = '".$username."'";

$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        $rowpass =  $row["password"];
        $rowusername = $row["username"];
    }
    if($rowpass == $password && $rowusername == $username && 1){
        echo "TEST";
        setcookie('username', $username, time() + (86400 * 30), "/"); // 86400 = 1 day
        setcookie('password', $password, time() + (86400 * 30), "/"); // 86400 = 1 day
    } 
    else {
        $_SESSION['LoginMsg'] = "Failed to Login: The username or password you entered is incorrect";
        header("Location:index.php");
    }

} else {
    $_SESSION['LoginMsg'] = "Failed to Login: The username or password you entered is incorrect or User Not Found";
    header("Location:index.php");
    
}

mysqli_close($conn);


?>

<!DOCTYPE html>
<!--App: atosystem-->
<!--Company: atoinsurance-->
<!--Dev: rtroulak-->
<!--Date: 4/1/2019-->
<html lang="en" >
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <title>aToSystem</title>


    <link rel='stylesheet prefetch' href='https://fonts.googleapis.com/css?family=Open+Sans:600'>
    <link rel="stylesheet" href="./assets/css/style.css">
    
    <script type="text/javascript">
    

        function validate(evt) {
              var theEvent = evt || window.event;

              // Handle paste
              if (theEvent.type === 'paste') {
                  key = event.clipboardData.getData('text/plain');
              } else {
              // Handle key press
                  var key = theEvent.keyCode || theEvent.which;
                  key = String.fromCharCode(key);
              }
              var regex = /[0-9\b]|\./;
              if( !regex.test(key) ) {
                theEvent.returnValue = false;
                if(theEvent.preventDefault) theEvent.preventDefault();
              }
        }

    
    </script>

</head>
<body>
<div class="login-wrap">
    <div class="login-html">
        <img style="display: block;margin: 0 auto;" width="600px" height="150px" src="assets/images/whitelogo.png">
        <h1 style="color:white" align="center">ATOSystem</h1>
        <br>
        <br>
        <input id="tab-1" type="radio" name="tab" class="sign-in" checked><label for="tab-1" class="tab">Αναζητηση</label>
        <input id="tab-2" type="radio" name="tab" class="sign-up"><label for="tab-2" class="tab">Εισαγωγη</label>
        <div class="login-form">
            <form class="sign-in-htm" action="./api/User/search.php" method="POST">
                <div class="group">
                    <label for="user" class="label">Αναζητηση βαση Επιθετου πελατη</label>
                    <input id="lastname" name="lastname" type="text" class="input" placeholder="πχ ΟΡΦΑΝΟΥΔΑΚΗ" onkeyup="this.value = this.value.toUpperCase();">
                </div>
                 <div class="group">
                    <label for="user" class="label">Αναζητηση βαση email πελατη</label>
                    <input id="email" name="email" type="email" class="input" placeholder="πχ info@atoinsurance.gr">
                </div>
                 <div class="group">
                    <label for="user" class="label">Αναζητηση βαση τηλεφωνου πελατη</label>
                     <input id="phone" name="phone" type="text" class="input" placeholder="πχ 6943405312" onkeypress='validate(event)'>
                </div>
                 <div class="group">
                    <label for="user" class="label">Αναζητηση βαση πινακιδας αυτοκινητου</label>
                   <input id="carid" name="carid" type="text" class="input" placeholder="πχ XNK8716" onkeyup="this.value = this.value.toUpperCase();">
                </div>
                <div class="group">
                    <input type="submit" class="button" value="Αναζητηση Πελατη">
                </div>
               
                <div class="hr"></div>
                 <div class="group">
                    <a href="./api/User/client_list.php"> <input type="button" class="button" value="ΛΙΣΤΑ ΟΛΩΝ ΤΩΝ ΠΕΛΑΤΩΝ"></a><br>
                     <a href='./api/User/car_list.php'> <input type="button" class="button" value="ΛΙΣΤΑ ΟΛΩΝ ΤΩΝ ΟΧΗΜΑΤΩΝ"></a>
                </div>
            </form>



            <form class="sign-up-htm" action="./api/User/signup.php" method="POST">


                <!-- USER -->
                <div class="group">
                    <label for="user" class="label" >ONOMA</label>
                    <input id="firstname" name="firstname" type="text" class="input" placeholder="πχ ΑΘΗΝΑ" onkeyup="this.value = this.value.toUpperCase();">
                </div>
                <div class="group">
                    <label for="user" class="label" >EΠΩΝΥΜΟ</label>
                    <input id="lastname" name="lastname" type="text" class="input" placeholder="πχ ΟΡΦΑΝΟΥΔΑΚΗ" onkeyup="this.value = this.value.toUpperCase();">
                </div>
                <div class="group">
                    <label for="user" class="label">EMAIL</label>
                    <input id="email" name="email" type="email" class="input" placeholder="πχ info@atoinsurance.gr">
                </div>
                <div class="group">
                    <label for="user" class="label">ΔΙΕΥΘΥΝΣΗ</label>
                    <input id="address" name="address" type="text" class="input" placeholder="πχ ΚΑΛΎΒΕΣ ΑΠΟΚΟΡΏΝΟΥ ΧΑΝΊΩΝ 73003" onkeyup="this.value = this.value.toUpperCase();">
                </div>

                 <div class="group">
                    <label for="user" class="label">ΤΗΛΕΦΩΝΟ ΕΠΙΚΟΙΝΩΝΙΑΣ</label>
                    <input id="phone" name="phone" type="text" class="input" placeholder="πχ 6943405312" onkeypress='validate(event)'>
                </div>


                <div class="hr"></div>
                <!-- CAR -->
                <div class="group">
                    <label for="car" class="label">ΑΜΑΞΙ</label>
                    <input id="car" name="car" type="text" class="input" placeholder="πχ OPEL ASTRA" onkeyup="this.value = this.value.toUpperCase();">
                </div>
                <div class="group">
                    <label for="car" class="label">ΚΥΒΙΣΜΟΣ</label>
                    <input id="carcc" name="carcc" type="text" onkeypress='validate(event)' class="input" placeholder="πχ 1400">
                </div>
                <div class="group">
                    <label for="car" class="label">ΠΙΝΑΚΙΔΑ</label>
                    <input id="carid" name="carid" type="text" class="input" placeholder="πχ XNK8716" onkeyup="this.value = this.value.toUpperCase();">
                </div>


                <div class="hr"></div>
                <!-- INSURANCE -->
                <div class="group">
                    <label for="invoice" class="label">ΕΤΑΙΡΙΑ</label>
                    <select id="company" name="company" class="inputdropdown" >
                      <option value="1">INTERAMERICAN</option>
                      <option value="2" selected>ΕΥΡΩΠΑΪΚΗ ΠΙΣΤΗ</option>
                      <option value="3">ΣΥΝΕΤΑΙΡΙΣΤΙΚΗ</option>
                      <option value="4">INTERLIFE</option>
                    </select> 
                </div>
                <div class="group">
                    <label for="invoice" class="label">ΚΟΣΤΟΣ</label>
                    <input id="price" name="price" type="text" onkeypress='validate(event)' class="input" placeholder="πχ 95€" onkeyup="this.value = this.value.toUpperCase();">
                </div>
                <div class="group">
                    <label for="invoice" class="label">ΗΜΕΡΜΗΝΙΑ ΕΝΑΡΞΗΣ ΑΣΦΑΛΕΙΑΣ</label>
                    <input id="datestart" name="datestart" type="date" value="<?php echo date("Y-m-d"); ?>"  class="input">
                </div>
                <div class="group">
                    <label for="invoice" class="label">ΠΕΡΙΟΔΟΣ</label>

                    <select id="duration" name="duration" class="inputdropdown">
                      <option value="3" >3 MHNEΣ</option>
                      <option value="6" selected>6 MHNEΣ</option>
                      <option value="12">12 MHNEΣ</option>
                      <option value="24" >24 MHNEΣ</option>
                    </select> 
                </div>

                <div class="group">
                    <input type="submit" class="button" value="ΕΙΣΑΓΩΓΗ">
                </div>
                
                <!--<div class="foot-lnk">-->
                    <!--<label for="tab-1">Already Member?</a>-->
                <!--</div>-->
            </form>
        </div>
    </div>
</div>


</body>
</html>