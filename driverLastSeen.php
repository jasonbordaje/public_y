<?php
include('includes/dbconfig.php');

$result = [];
$count = 0;

$sql = "SELECT m1.* FROM delivery_tracking m1 LEFT JOIN delivery_tracking m2 ON (m1.driver_id = m2.driver_id AND m1.id < m2.id) WHERE m2.id IS NULL order BY m2.id DESC";

$sql = $conn->query($sql);

while($row = mysqli_fetch_assoc($sql)){
 $driver_id = $row['driver_id'];

 $sql1 = "SELECT * FROM mst_admin_user LEFT JOIN driver_availability ON mst_admin_user.id = driver_availability.driver_id WHERE mst_admin_user.id = $driver_id";
 $sql1 = $conn->query($sql1);
 $row1 = mysqli_fetch_assoc($sql1);

 $result[$count]['trackingID'] = $row['id'];
 $result[$count]['location_lat'] = $row['location_lat'];
 $result[$count]['location_long'] = $row['location_long'];
 $result[$count]['Driverid'] = $row1['id'];
 $result[$count]['fname'] = $row1['fname'];
 $result[$count]['lname'] = $row1['lname'];
 $result[$count]['is_online'] = $row1['is_online'];
 $result[$count]['username'] = $row1['username'];
 $result[$count]['avatar'] = $row1['avatar'];

 $count++;

}

echo json_encode($result);
?>