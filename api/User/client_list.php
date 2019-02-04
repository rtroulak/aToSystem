<?php
header('Content-Type: text/html; charset=utf-8');
session_start();

require_once "../../db_vars.php";
require_once "../../functions.php";
 
// Create connection
$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

mysqli_set_charset($conn, "utf8");



$sql = "SELECT * FROM `client`";



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
<meta charset=utf-8" />

    <link rel='stylesheet prefetch' href='https://fonts.googleapis.com/css?family=Open+Sans:600'>
    <link rel="stylesheet" href="../../assets/css/style.css">

</head>
<body>
<div class="login-wrap">
    <div class="login-html">
        <a href="../../app.php"><img width="50px" height="50px" src="../../assets/images/home.png"></a>
        <img style="display: block;margin: 0 auto;" width="600px" height="150px" src="../../assets/images/whitelogo.png">
        <h1 style="color:white" align="center">ATOSystem</h1>
        <br>
        <br>
        <input id="tab-1" type="radio" name="tab" class="sign-in" checked><label for="tab-1" class="tab">ΑΠΟΤΕΛΕΣΜΑΤΑ</label>
        <input id="tab-2" type="radio" name="tab" class="sign-up"><label for="tab-2" class="tab"> </label>
        <div class="login-form">
           <?php

            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                // output data of each row
                echo "<table border='1'>";
                echo "<th>ΟΝΟΜΑΤΕΠΩΝΥΜΟ</th><th>ΕΜΑΙΛ</th><th>ΔΙΕΥΘΥΝΣΗ</th><th>ΤΗΛΕΦΩΝΟ</th><th>ΕΓΓΡΑΦΗ</th>";
                while($row = mysqli_fetch_assoc($result)) {
                   echo "<tr>";
                    echo "<td style='color:lightgray'>". $row["firstname"]. " " . $row["lastname"]. "</td><td style='color:lightgray'>". $row["email"]. " </td><td style='color:lightgray'>". $row["address"]. " </td><td style='color:lightgray'>". $row["phone"]. " </td><td style='color:lightgray'>". $row["date"]. " </td>";
                    echo "</tr>";
                }
                
                echo "</table>";
            } else {
                echo "0 results";
            }

           ?>
        </div>
    </div>
</div>


</body>
</html>
<?php

mysqli_close($conn);

?>