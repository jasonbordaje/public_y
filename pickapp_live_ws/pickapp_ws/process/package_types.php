<?php
include '../includes/dbconfig2.php';

$query = "SELECT * from package_type";
$query = $conn2->query($query);
$result = "";

while($row = mysqli_fetch_assoc($query)){
	$result .='<option value="'.$row['id'].'">'.$row['package_name'].'</option>';
}

echo $result;
?>