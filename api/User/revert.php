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
mysqli_set_charset($con, "utf8");
$client_id = defSqlInjection($_GET['client_id']);
$car_id = defSqlInjection($_GET['car_id']);
$invoice_id = defSqlInjection($_GET['invoice_id']);


$sql = "DELETE FROM client where client_id='".$client_id."'";
mysqli_query($conn, $sql);
$sql = "DELETE FROM car where client_id='".$car_id."'";
mysqli_query($conn, $sql);
$sql = "DELETE FROM invoice_id where client_id='".$invoice_id."'";
mysqli_query($conn, $sql);

mysqli_close($conn);

header("Location:https://atoinsurance.gr/wp-admin/aToSystem/app.php"); /* Redirect browser */
exit();

?>