<?php
include '../includes/dbconfig2.php';

 $query = "SELECT * from driver_availability where is_online = 1";
 $query = $conn2->query($query);
 $numrows = mysqli_num_rows($query);

 if($numrows > 0){
 	echo "OK";
 }else{
 	echo "NO";
 }
// echo "OK";
?>