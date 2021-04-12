<?php
include '../includes/dbconfig2.php';

$query = "SELECT * from payment";
$query = $conn2->query($query);
$result = '<option value="1" selected disabled>Where to collect payment?</option>';

while($row = mysqli_fetch_assoc($query)){
	$result .='<option value="'.$row['id'].'">'.$row['method'].'</option>';
}

echo $result;
?>