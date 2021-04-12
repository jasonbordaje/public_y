<?php

session_start();
header("Content-Type: application/vnd.ms-excel");
header("Content-disposition: attachment; filename=spreadsheet.xls");
include("includes/dbconfig.php");

$startDate = $_POST['starts'];
$endDate = $_POST['ends'];
$count = 1;
$filename = "Logs for ".$startDate." to ".$endDate;

$id = $_SESSION['id'];

if(isset($_POST['export-data'])){

	$queryName = "SELECT fname FROM mst_admin_user WHERE id = $id";
	$queryName = $conn->query($queryName);
	$row = mysqli_fetch_assoc($queryName);
	$name = $row['fname'];

	$sql = "SELECT log.log_desc, log.dateTime_created, log.requestid, mst_admin_user.fname, mst_admin_user.lname FROM log LEFT JOIN mst_admin_user ON log.userid = mst_admin_user.id WHERE log.dateTime_created BETWEEN '$startDate' AND '$endDate' ORDER BY log.id DESC";
	$sql = $conn->query($sql);
	$output .= '
	<table>
		<thead>
			<tr>
                <th>No.</th>
	            <th>First Name</th>
	            <th>Last Name</th>
	            <th>Action taken</th>
	            <th>Request Id</th>
	            <th>Requested By</th>
	            <th>Date/Time Performed</th>
            </tr>
		</thead>

	';
	while($row = mysqli_fetch_assoc($sql)){
			$requestid = $row['requestid'];

			$sql1 = "SELECT requested_by FROM request_header WHERE id = $requestid";
			$sql1 = $conn->query($sql1);
			$row1 = mysqli_fetch_assoc($sql1);
			$requested_by = $row1['requested_by'];

			$sql2 = "SELECT firstname, lastname FROM mst_user WHERE id = $requested_by";
			$sql2 = $conn->query($sql2);
			$row2 = mysqli_fetch_assoc($sql2);

			$output .= '
					<tr>
						<td>'.$count++.'</td>
						<td>'.$row["fname"].'</td>
						<td>'.$row["lname"].'</td>
						<td>'.$row["log_desc"].'</td>
						<td>'.$row["requestid"].'</td>
						<td>'.$row2["firstname"].' '.$row2["lastname"].'</td>
						<td>'.$row["dateTime_created"].'</td>
					</tr>
			';
	}

	$output .= '</table>';
	echo $output;
	//echo "<script>window.location.replace('dashboard.php')</script>";
}
?>