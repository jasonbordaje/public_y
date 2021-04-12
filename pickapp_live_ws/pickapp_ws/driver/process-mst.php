<?php
include '../includes/dbconfig2.php';
include '../includes/driver/function.php';
include '../../sms/sms_function.php';

$action = $_REQUEST['action'];	
$now = date("Y-m-d H:i:s", strtotime('+8 hours'));
	
switch($action){

	case 'login':
	
	$username = trim($_POST['UserName']);
	$password = md5($_POST['Password']);
	
		if (checkUsername($username) == 1) {
			
			if (checkPassword($username) == $password) {
				
			session_start();
			$_SESSION['loginid'] = getID($username);
			$id = getID($username);
			putOnline($id);
			putAvailable($id);
			echo "success";	
			
			} else {
				echo "pi";
			}
			
		} else {
			echo "nod";
		}
	
	exit();
	break;
	
	case 'userprofile':
	
	session_start();
	$loginid = $_SESSION['loginid'];
	
	$fname = userInfo($loginid,"fname");
	$mi = userInfo($loginid,"mname");
	$lname = userInfo($loginid,"lname");
	
	echo '<div style="width:60px; height:60px; border:0px solid #000; border-radius: 55px; background:url(images/momon.png); overflow:hidden; margin-left:130px;">	<!--<img src="'.$avatar.'" width="60" height="60">--></div>
	<div style="border:0px solid #000;">'.$fname.' '.$mi.' '.$lname.'<input type="hidden" name="userid" id="userid" value="'.$loginid.'"></div>';
		
	exit();
	break;
	
	case 'getconfirmed':
	
	session_start();
	$loginid = $_SESSION['loginid'];
	
		echo getRequestHeader();
		
	exit();
	break;

	
	case 'acceptrequest':
	
	session_start();
	$loginid = $_SESSION['loginid'];
	$hid = $_REQUEST['hid'];
	$newTime = date("Y-m-d H:i:s", strtotime('+8 hours'));
	$rd_id = $_REQUEST['rd_id'];

	echo $hid;
	$str = "UPDATE request_header set assigned_driver = $loginid, dateTime_assigned = '$now', status = 'ACCEPTED' where id = $hid";

	$update1 = "UPDATE request_ledger set isConfirmed = 1, dateTime_updated = '$newTime' where request_header_id = $hid and  driver_id = $loginid";
	$conn2->query($update1);

	$update = $conn2->query($str);
	
	//new
	$update2 = "UPDATE request_details SET details_status = 'ACCEPTED' WHERE request_header_id = $hid";
	$update2 = $conn2->query($update2);
	//new

		if ($update) {
			$_SESSION['headerid'] = $hid;
			$discountedCost = getRequest_info($hid,"cost");
			$userid = getRequestheader_info($hid,"requested_by");
			$currentbal = customerInfo($userid,"balance");
			
			if ($currentbal >= $discountedCost) {
				$newbal = $currentbal - $discountedCost;
				NewUserBalance($userid,$newbal,$discountedCost,$hid);
			}
			
			putunAvailable($loginid);
			acceptSMS($hid, $loginid);
			echo "success";
		} else {
			echo "error";
		}
		
	exit();
	break;

	case 'acceptedrequests':
	
	session_start();
	$hid = $_REQUEST['hid'];
	$_SESSION['headerid'] = $hid;
	
	$str = "UPDATE request_header set assigned_driver = $loginid, dateTime_assigned = '$now', status = 'ACCEPTED' where id = $hid";
	$conn2->query($str);

	echo "success";
	exit();
	break;
	
	case 'loglocation':
	
	session_start();
	$loginid = $_SESSION['loginid'];
	$hid = $_SESSION['headerid'];
	$lat = $_REQUEST['lat'];
	$lng = $_REQUEST['lng'];
	
	$str = "Insert into delivery_tracking(driver_id,request_header_id,location_lat,location_long,dateTime_added) values($loginid,$hid,'$lat','$lng','$now')";
	$insert = $conn2->query($str);
		
	exit();
	break;

	case 'loglocation2':
	
	session_start();
	$loginid = $_SESSION['loginid'];
	$lat = $_REQUEST['lat'];
	$lng = $_REQUEST['lng'];
	
	$update = "UPDATE driver_availability set location_lat = '$lat', location_long = '$lng' where driver_id = $loginid";
	$update = $conn2->query($update);
		
	exit();
	break;


	case 'getmsg':
	
	session_start();
	$loginid = $_SESSION['loginid'];
	$hid = $_SESSION['headerid'];
	
	$str = "Select * from messages where request_header_id = $hid";
	$query = $conn2->query($str);
	
		$ctr = 0;
		while ($row = mysqli_fetch_assoc($query)) {
			
			$msg = $row['message'];
			$sendertype = $row['sender_type'];
			$sent_by = $row['sent_by_id'];
			
			if ($sendertype == "D") {
				$textalign = 'align="right"';
				$name = userInfo($sent_by,"fname");
			} else {
				$textalign = 'align="left"';
				$name = customerInfo($sent_by,"firstname");
			}
			
			$msgline .='<tr>
              <td '.$textalign.'><strong>'.$name.':</strong></td>
            </tr>
            <tr>
              <td '.$textalign.'>'.$msg.'</td>
            </tr>';
			
		$ctr++; }
		
		$table = '<table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tbody>
		  		'.$msgline.'
          </tbody>
        </table>';
		
		echo $table;
		
	exit();
	break;
	
	case 'sendmsg':
	
	session_start();
	$loginid = $_SESSION['loginid'];
	$hid = $_SESSION['headerid'];
	$msg = $_REQUEST['msg'];
	
	$str = "Insert into messages(message,request_header_id,sent_by_id,sender_type,dateTime_sent) values('$msg',$hid,$loginid,'D','$now')";
	/*$file = fopen("test.txt","w");
	echo fwrite($file,$str);
	fclose($file);*/
	$query = $conn2->query($str);
	
	if ($query) {
		echo "ok";
	} else {
		echo "error";
	}
		
	exit();
	break;
	
	case 'newmsg':
	
	session_start();
	$loginid = $_SESSION['loginid'];
	$hid = $_SESSION['headerid'];
		
	$str = "Select count(id) as cnt from messages where newmsg = 0 and request_header_id = $hid and sender_type = 'U'";
	$query = $conn2->query($str);
	$row  = mysqli_fetch_assoc($query);
	$cnt = $row['cnt'];
	
	if ($cnt > 0) {
		echo "ok";
		$upd_str = "Update messages set newmsg = 1 where request_header_id = $hid and sender_type = 'U'";
		$query_ = $conn2->query($upd_str);
	} else {
		echo "none";
	}
		
	exit();
	break;
	
	case 'checkconfirmed':
	
		$query = "SELECT * from request_header where status = 'CONFIRMED' and notify = 0";
		$query = $conn2->query($query);
		$numrow = mysqli_num_rows($query);
			
			if ($numrow > 0) {
				echo "ok";
				$upd_str = "Update request_header set notify = 1";
				$query_ = $conn2->query($upd_str);
			}
		
	exit();
	break;
	
	case 'updatepoint':
	session_start();
	$loginid = $_SESSION['loginid'];
	$hid = $_SESSION['headerid'];
	// $hid = 2239;
	$at = $_REQUEST['at'];
	$rdid = $_REQUEST['rdid'];
	// echo $headerid;
		if ($at == 1) {	
			$upd_str = "Update request_header set at_pickup = 1, dateTime_updated = '$now', dateTime_pick = '$now' where id = $hid and assigned_driver = $loginid";
		} else if ($at == 2) {	
			$upd_str = "Update request_header set at_dropoff = 1, dateTime_updated = '$now' where id = $hid and assigned_driver = $loginid";
		} else if ($at == 3) {	
			$ch = "SELECT * FROM request_details WHERE request_header_id = $hid AND details_status = 'ACCEPTED'";
			$ch = $conn2->query($ch);
			$numrows = mysqli_num_rows($ch);
			if($numrows == 0){
				$upd_str = "Update request_header set status = 'COMPLETED', dateTime_updated = '".$now."', dateTime_delivered = '".$now."' where id = $hid and assigned_driver = $loginid";
			}else{
				$upt = "UPDATE request_details SET details_status = 'COMPLETED' WHERE id = $rdid";
				$upt = $conn2->query($upt);

				$upd_str = "Update request_header set status = 'ACCEPTED', dateTime_updated = '".$now."', dateTime_delivered = '".$now."' where id = $hid and assigned_driver = $loginid";				
			}
			putAvailable($loginid);
		}
		
		
			$query = $conn2->query($upd_str);
			if ($query) {
				//check again if there is still available drop off
				$ch_ = "SELECT * FROM request_details WHERE request_header_id = $hid AND details_status = 'ACCEPTED'";
				$ch_ = $conn2->query($ch_);
				$numrows_ = mysqli_num_rows($ch_);
				//if no available dropoff, update the main request status
				if($numrows_ == 0){
					$updt_all = "Update request_header set status = 'COMPLETED', dateTime_updated = '".$now."', dateTime_delivered = '".$now."' where id = $hid and assigned_driver = $loginid";
					$updt_all = $conn2->query($updt_all);
				}
			}
			echo "ok";
		
	exit();
	break;
	
	case 'getmobile':
	session_start();
	$hid = $_SESSION['headerid'];
	
	$query = "SELECT requested_by from request_header where id = $hid";
	$query = $conn2->query($query);
	$row = mysqli_fetch_assoc($query);
	$rid = $row['requested_by'];
	
		$query_ = "SELECT mobileno from mst_user where id = $rid";
		$query_ = $conn2->query($query_);
		$row_ = mysqli_fetch_assoc($query_);
		$mobile = $row_['mobileno'];
		$mobile = (int)$mobile;
		echo "+63".$mobile;
	
	exit();
	break;
	
	case 'whatbutton':
	session_start();
	$hid = $_SESSION['headerid'];
	
	$query = "SELECT * from request_header where id = $hid";
	$query = $conn2->query($query);
	$row = mysqli_fetch_assoc($query);
	$status = $row['status'];
	$at_1 = $row['at_pickup'];
	$at_2 = $row['at_dropoff'];
	
		if ($status == "ACCEPTED" && $at_1 == 0 && $at_2 == 0) {
			echo 0;
		} else if ($status == "ACCEPTED" && $at_1 == 1 && $at_2 == 0) {
			echo 1;
		} else if ($status == "ACCEPTED" && $at_1 == 1 && $at_2 == 1) {
			echo 2;
		} else if ($status == "COMPLETED" && $at_1 == 1 && $at_2 == 1) {
			echo 3;
		}
	
	exit();
	break;
	
	case 'rby':
	session_start();
	$hid = $_SESSION['headerid'];
	$rbyname = $_REQUEST['rbyname'];
	
		$query_ = "SELECT requested_by from request_header where id = $hid";
		$query_ = $conn2->query($query_);
		$row_ = mysqli_fetch_assoc($query_);
		$rid = $row_['requested_by'];
		
		$rname = strtoupper(customerInfo($rid,"firstname"));
		$rmobile = customerInfo($rid,"mobileno");
		$rmobile = (int)$rmobile;
			
	$update = "Update request_header set receivedby = '".$rbyname."', dateTime_updated = '".$now."' where id = $hid";
	$query = $conn2->query($update);

			$rname_ = strtoupper($rbyname);
			$karon = date('Ymdhis', strtotime('+8 hours'));

			$number = "63".$rmobile;
			$content = "Hi ".$rname.", your item has been delivered and received by: ".$rname_." on ".$now.". Please check your email to view Delivery Report.";
			$send = sendSMS($content, $number);
				
		if ($query) {	
			echo "ok";
		} else {
			echo "no";
		}
	
	exit();
	break;
	
	case 'checkactiverequest':
	session_start();
	$loginid = $_SESSION['loginid'];
	//$hid = $_SESSION['headerid'];
		
		$query_ = "SELECT * from request_header where assigned_driver = $loginid and status = 'ACCEPTED' order by id DESC";
		$query_ = $conn2->query($query_);
		$row_ = mysqli_fetch_assoc($query_);
		$hid = $row_['id'];
		$_SESSION['headerid'] = $hid;
		
		if (empty($hid)) {
			echo "no";
		} else {
			putunAvailable($loginid);
			echo "yes";
		}
	
	exit();
	break;
}

?> 