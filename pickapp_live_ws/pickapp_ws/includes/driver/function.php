<?php
function checkUsername($username) {
	include 'dbconfig2.php';

	$query = "SELECT id from mst_admin_user where username = '$username'";
	$query = $conn2->query($query);
	$row = mysqli_fetch_assoc($query);
	
	$id = $row['id'];
	
	if ($id > 0) {
		return 1;
	} else {
		return 0;
	}
}

function checkPassword($username) {
	include 'dbconfig2.php';
	
	$query = "SELECT password from mst_admin_user where username = '$username'";
	$query = $conn2->query($query);
	$row = mysqli_fetch_assoc($query);
	
	return $row['password'];
}

function getID($username) {
	include 'dbconfig2.php';

	$query = "SELECT id from mst_admin_user where username = '$username'";
	$query = $conn2->query($query);
	$row = mysqli_fetch_array($query);
	
	return $row['id'];
}

function getAPIKEY($username){
	include 'dbconfig2.php';

	$query = "SELECT google_api_key from mst_admin_user where username = '$username'";
	$query = $conn2->query($query);
	$row = mysqli_fetch_assoc($query);

	return $row['google_api_key'];
}

function userInfo($loginid,$field) {
	include 'dbconfig2.php';

	$query = "SELECT $field as ans from mst_admin_user where id = $loginid";
	$query = $conn2->query($query);
	$row = mysqli_fetch_assoc($query);
	
	return $row['ans'];
}

function customerInfo($userid,$field) {
	include 'dbconfig2.php';
	$query = "Select $field as ans from mst_user where id = $userid";
	$query = $conn2->query($query);
	$row = mysqli_fetch_assoc($query);
	
	return $row['ans'];
}

function getRequest_info($header_id,$col) {
	include 'dbconfig2.php';
	
	$query = "SELECT $col as ans from request_details where request_header_id = $header_id";
	$query = $conn2->query($query);
	$row = mysqli_fetch_assoc($query);
	$ans = $row['ans'];
	
	return $ans;
}

function getRequestheader_info($header_id,$col) {
	include 'dbconfig2.php';
	
	$query = "SELECT $col as ans from request_header where id = $header_id";
	$query = $conn2->query($query);
	$row = mysqli_fetch_assoc($query);
	$ans = $row['ans'];
	
	return $ans;
}

function getRequestHeader() {
	include 'dbconfig2.php';

	$query = "SELECT * from request_header where status = 'CONFIRMED' order by dateTime_updated DESC";
	$query = $conn2->query($query);
	$numrow = mysqli_num_rows($query);
	if ($numrow > 0) {
		while ($row = mysqli_fetch_assoc($query)) {
			
			$id = $row['id'];
			$dateTime_requested = date('D, d M Y, H:i',strtotime($row['dateTime_requested']));
			$userid = $row['requested_by'];
			$cust_fullname = strtoupper(customerInfo($userid,"firstname").' '.customerInfo($userid,"mi").' '.customerInfo($userid,"lastname"));
			$cavatar = customerInfo($userid,"avatar");
			$origin = getRequest_info($id,"origin_address");
			$destination = getRequest_info($id,"destination_address");
			
			$doThis='review.html?headerid='.$id;
					
			$list .= '<div class="requestdiv left">
				<table width="100%" border="0" cellpadding="0" cellspacing="0">
				  <tbody class="tablerequest">
				  <tr onclick=DoNav(\''.$doThis.'\')>
					  <td width="60" valign="middle"><img src="http://pickapp.cssolutions.ph/pickapp_ws/'.$cavatar.'" height="60" width="60" style="margin-right:5px;"></td>
					  <td>
					  	<div style="padding-left:5px; padding-right:5px; padding-top:5px; padding-bottom:5px;">
							<strong>'.$cust_fullname.'</strong><br/>
							<span style="font-size:10px;">'.$dateTime_requested.'</span><br/>
							<span style="font-size:10px;">Origin: '.$origin.'</span>
						</div>
					  </td>
					</tr>
				  </tbody>
				</table>
			</div>';
			
		}
	
	} else {
			$list = '<div class="requestdiv">
				<table width="100%" border="0" cellpadding="0" cellspacing="0">
				  <tbody class="tablerequest">
					<tr>
					  <td colspan="2" align="center" valign="middle" height="25">No request available!</td>
					</tr>
				  </tbody>
				</table>
			</div>';
	}
	
	return $list;
	
}

function putOnline($loginid) {
	include 'dbconfig2.php';
	
	$str = "Update driver_availability set is_online = 1 where driver_id = $loginid";
	$update = $conn2->query($str);
}

function putOffline($loginid) {
	include 'dbconfig2.php';
	
	$str = "Update driver_availability set is_online = 0 where driver_id = $loginid";
	$update = $conn2->query($str);
}

function putAvailable($loginid) {
	include 'dbconfig2.php';
	
	$str = "Update driver_availability set is_available = 1 where driver_id = $loginid";
	$update = $conn2->query($str);
}

function putunAvailable($loginid) {
	include 'dbconfig2.php';
	
	$str = "Update driver_availability set is_available = 0 where driver_id = $loginid";
	$update = $conn2->query($str);
}

function acceptSMS($hid, $loginid){
	include 'dbconfig2.php';
	include '../../../sms/sms_function.php';

	$headerid = $hid;
	$driverid = $loginid;

	$query = "SELECT * from request_header where id = $headerid";
	$query = $conn2->query($query);
	$numrows = mysqli_num_rows($query);
	$date = date("ymds");

	if($numrows > 0){
	    while($result = mysqli_fetch_assoc($query)){
	        $requestorid = $result['requested_by'];
	    }
	}

	$query2 = "SELECT  * from mst_user where id = $requestorid";
	$query2 = $conn2->query($query2);
	$res = mysqli_fetch_assoc($query2);

	$requestorcont = $res['mobileno'];
	$requestorname = $res['firstname'];

	$query3 = "SELECT fname from mst_admin_user where id = $driverid";
	$query3 = $conn2->query($query3);
	$resu = mysqli_fetch_assoc($query3);

	$drivername = $resu['fname'];

	$number = '63'.$requestorcont;
	$content = "Hi ".$requestorname.", your request has been accepted by ".$drivername.". You can monitor your drivers location using Yello-X App!";

	$send = sendSMS($content, $number);
}

function NewUserBalance($userid,$newbal,$discountedCost,$hid) {
		include 'dbconfig2.php';
		
		$new_time = date("Y-m-d H:i:s", strtotime('+8 hours'));

		$query = "UPDATE mst_user set balance = $newbal where id = $userid";
		$query = $conn2->query($query);
		
		$query2 = "INSERT into user_balance_log (userID, request_header_id, requestCost, remainingBalance, dateTime_added) values ($userid, $hid, $discountedCost, $newbal, '$new_time')";
		$query2 = $conn2->query($query2);
	}
?>