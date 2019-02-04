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
$firstname = defSqlInjection($_POST['firstname']);
$lastname = defSqlInjection($_POST['lastname']);
$email = defSqlInjection($_POST['email']);
$address= defSqlInjection($_POST['address']);
//car
$car = defSqlInjection($_POST['car']);
$carcc= defSqlInjection($_POST['carcc']);
$phone= defSqlInjection($_POST['phone']);
$carid = defSqlInjection($_POST['carid']);
//extra
$date1= defSqlInjection(time());
$date = date('Y-m-d',$date1);

//insurance
$company = defSqlInjection($_POST['company']);
$price = defSqlInjection($_POST['price']);
$date_start = defSqlInjection($_POST['datestart']);
$duration = defSqlInjection($_POST['duration']);
$date_expire = date('Y-m-d', strtotime("+".$duration." months", strtotime($date_start)));


$sql = "INSERT INTO client (firstname, lastname, email,address,date,phone,amount) VALUES ('".$firstname."', '".$lastname."', '".$email."','".$address."','".$date."','".$phone."','".$price."')";

if (mysqli_query($conn, $sql)) {
    $last_id = mysqli_insert_id($conn);
    // echo "<br>New record created successfully: ".$last_id;
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

 $sql1 = "INSERT INTO cars (client_id, car_model, car_cc,car_label,date_start,date_expire,company_id) VALUES ('".$last_id."', '".$car."', '".$carcc."','".$carid."','".$date_start."','".$date_expire."','".$company."')";

if (mysqli_query($conn, $sql1)) {
    $last_car_id = mysqli_insert_id($conn);
    // echo "<br>New record created successfully: ".$last_car_id;
} else {
    // echo "Error: " . $sql1 . "<br>" . mysqli_error($conn);
}

$sql2 = "INSERT INTO invoice (client_id, car_id, price,invoice_date) VALUES ('".$last_id."', '".$last_car_id."', '".$price."','".$date."')";

if (mysqli_query($conn, $sql2)) {
    $last_invoice_id = mysqli_insert_id($conn);
    // echo "<br>New record created successfully: ".$last_invoice_id;
} else {
    // echo "Error: " . $sql2 . "<br>" . mysqli_error($conn);
}


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
        <input id="tab-1" type="radio" name="tab" class="sign-in" checked><label for="tab-1" class="tab">ΠΡΟΣΘΕΘΗΚΕ Ο ΧΡΗΣΤΗΣ ΜΕ ΤΑ ΣΤΟΙΧΕΙΑ</label>
        <input id="tab-2" type="radio" name="tab" class="sign-up"><label for="tab-2" class="tab"> </label>
        <div class="login-form">
           <?php

            $sql = "SELECT * FROM `client` INNER JOIN cars on cars.client_id = client.client_id INNER JOIN invoice on invoice.car_id = cars.car_id INNER JOIN company on cars.company_id = company.company_id WHERE client.lastname = '".$lastname."' AND client.phone='".$phone."' AND client.email='".$email."'";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                // output data of each row
                echo "<ul>";
                while($row = mysqli_fetch_assoc($result)) {
                   
                    echo "<li style='color:white'>". $row["firstname"]. " " . $row["lastname"]. "</li>";
                    echo "<li style='color:white'>". $row["email"]. "</li>";
                    echo "<li style='color:white'>". $row["address"]. "</li>";
                    echo "<li style='color:white'>". $row["date"]. "</li>";
                    echo "<li style='color:white'>". $row["phone"]. "</li>";
                    echo "<li style='color:white'>". $row["car_model"]. "</li>";
                    echo "<li style='color:white'>". $row["car_cc"]. "</li>";
                    echo "<li style='color:white'>". $row["car_label"]. "</li>";
                    echo "<li style='color:white'>". $row["date_start"]. "</li>";
                    echo "<li style='color:white'>". $row["date_expire"]. "</li>";
                    echo "<li style='color:white'>". $row["company_name"]. "</li>";
                    echo "<li style='color:white'>". $row["price"]. "€</li>";
                    $clid = $row['client_id'];
                    $caid = $row['car_id'];
                    $inid = $row['invoice_id'];
                    
                }
                echo "<ul>";
            } else {
                echo "0 results";
            }

           ?>

              <div class="group">
                    <a href="../../app.php"> <input type="submit" class="button" value="ΣΥΝΕΧΕΙΑ"></a><br>
                     <a href='revert.php?client_id=<?php echo $clid; ?>&car_id=<?php echo $caid; ?>&invoice_id=<?php echo $inid; ?>'> <input type="submit" class="button" value="ΑΚΥΡΩΣΗ ΕΓΓΡΑΦΗΣ"></a>
                </div>
        </div>
    </div>
</div>


</body>
</html>
<?php

mysqli_close($conn);

?>