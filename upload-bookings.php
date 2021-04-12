<?php
include 'includes/dbconfig.php';
$now = date("Y-m-d H:i:s", strtotime('+8 hours'));

function lastId() {
	include 'includes/dbconfig.php';
	$query = "SELECT id FROM `request_header` order by id desc limit 1";
	$query = $conn->query($query);
	$row = mysqli_fetch_assoc($query);
	return $row['id']; 
}

function createInvoice($id) {
	include 'includes/dbconfig.php';
	
	if (strlen($id) < 4) {
		$invoice = '0'.$id;
	} else {
		$invoice = $id;
	}
	
	$query = "Update request_header set invoice_no='$invoice' where id = $id";
	$query = $conn->query($query);
}

if (isset($_POST['upload'])) {
extract($_POST);

	$uploaddir = "upload/";
	$filename = str_replace(" ","_",basename( $_FILES['csv']['name']));
	$csv = $uploaddir .  rand(1,999) ."_". $filename;
	move_uploaded_file($_FILES['csv']['tmp_name'], $csv);
		$handle = fopen($csv, "r");
			while (($data = fgetcsv($handle)) !== FALSE) {
				
				$itemdesc = addslashes($data[0]);
				$sender = addslashes($data[1]);
				$sendermobile = $data[2];
				$receiver = addslashes($data[3]);
				$receivermobile = $data[4];
				$packagetype = $data[5];
				$originlat = $data[6];
				$originlng = $data[7];
				$destinationlat = $data[8];
				$destinationlng = $data[9];
				$origin_desc = addslashes($data[10]);
				$destination_desc = addslashes($data[11]);
				$distance = $data[12];
				$userid = $data[13];
				$note = addslashes($data[14]);
				$tod = $data[15];
				$tod = date("Y-m-d H:i:s", strtotime($tod));
				$driver = $data[16];
				
				//do the header first
				$insert = "INSERT into request_header (requested_by, status, dateTime_requested, assigned_driver, dateTime_assigned, transtype, transpoType,corporate) values ($userid, 'ACCEPTED', '$now', $driver,'$now',0,1,1)";
				$insert = $conn->query($insert);
				$id = lastId();
				createInvoice($id);
				//end header
				
				//do details
				$insert_details = "INSERT into request_details (request_header_id, item, sender_name, sender_contact, recepient_name, recepient_number, package_type,origin_lat,origin_lng,destination_lat,destination_lng,origin_address,destination_address,distance,cost,note,tod) values ($id,'$itemdesc','$sender','$sendermobile','$receiver','$receivermobile',$packagetype,'$originlat','$originlng','$destinationlat','$destinationlng','$origin_desc','$destination_desc','$distance',0.00,'$note','$tod')";
				$insert_details = $conn->query($insert_details);
				//end detais
	
			}

}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Upload Corporate Bookings</title>
</head>

<body>
<form method="post" enctype="multipart/form-data" name="form1" id="form1">
  <table width="50%" border="0" cellspacing="1" cellpadding="1">
    <tbody>
      <tr>
        <td width="18%">Select CSV File</td>
        <td width="82%"><input type="file" name="csv" id="csv"></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td><input type="submit" name="upload" id="upload" value="Press to Upload Data"></td>
      </tr>
    </tbody>
  </table>
</form>
</body>
</html>