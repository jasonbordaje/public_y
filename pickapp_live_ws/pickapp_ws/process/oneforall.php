<?php
include '../includes/dbconfig2.php';
session_start();

$loginid = $_SESSION['loginid'];
$vtype = $_REQUEST['transpoType'];

$jsonResult;

//service available
$service = "SELECT * FROM service_availability WHERE serviceType = $vtype";
$service  = $conn2->query($service);
$service_result = mysqli_fetch_assoc($service);

$jsonResult .= '{"service":'.json_encode($service_result).',';

//vehicle rate
$vehicleRate = "SELECT * FROM transportation_type where id = $vtype";
$vehicleRate = $conn2->query($vehicleRate);
$vehicleRate_result = mysqli_fetch_assoc($vehicleRate);

$jsonResult .= '"vehicleRate":'.json_encode($vehicleRate_result).',';

//package types
$packageTypes = "SELECT * from package_type";
$packageTypes = $conn2->query($packageTypes);

while($row = mysqli_fetch_assoc($packageTypes)){
	$packageTypes_result[] = $row;
}

$jsonResult .= '"packageTypes":'.json_encode($packageTypes_result).',';

//collect payment options
$payment = "SELECT * from payment";
$payment = $conn2->query($payment);

while($paymentRow = mysqli_fetch_assoc($payment)){
	$payment_result[] = $paymentRow;
}

$jsonResult .= '"payment":'.json_encode($payment_result).',';

//user discount
$discount = "SELECT * from user_discount";
$discount = $conn2->query($discount);
$discount_result = mysqli_fetch_assoc($discount);

$jsonResult .= '"discount":'.json_encode($discount_result).',';

//get user balance
$userBalance = "SELECT * from mst_user where id = $loginid";
$userBalance = $conn2->query($userBalance);
$userBalance_result = mysqli_fetch_assoc($userBalance);

$jsonResult .= '"userBalance":'.json_encode($userBalance_result).'}';

echo $jsonResult;

?>

