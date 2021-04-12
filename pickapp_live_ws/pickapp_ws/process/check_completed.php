<?php
include '../includes/dbconfig2.php';

$headerid = $_REQUEST['headerid'];

$query = "SELECT * from request_header where id = $headerid";
$query = $conn2->query($query);

while($row = mysqli_fetch_assoc($query)){
	if($row['status'] == 'COMPLETED'){
		echo 'DONE';
	}
}

?>