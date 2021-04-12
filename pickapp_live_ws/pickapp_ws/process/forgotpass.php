<?php
include '../includes/dbconfig2.php';
include '../../sms/sms_function.php';

$number = $_REQUEST['number'];
$newpass = $_REQUEST['newpass'];
$email = $_REQUEST['email'];
$encPass = md5($newpass);

$query = "SELECT * from mst_user where mobileno = '$number' AND emailadd = '$email'";
$query = $conn2->query($query);
$numrows = mysqli_num_rows($query);

if($numrows > 0){
	while($row = mysqli_fetch_assoc($query)){
		$update = "UPDATE mst_user set password = '$encPass' where mobileno = '$number' AND emailadd = '$email'";
		$conn2->query($update);

        $number = '+63'.$number;
        $content = "Your new password is ".$newpass;
        $send = sendSMS($content, $number);
	}
}else{
    echo "wrong";
}


?>