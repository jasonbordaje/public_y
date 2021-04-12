<?php
include("includes/dbconfig.php");
$driver_id = $_REQUEST['driver_id'];
$sql = "SELECT mst_admin_user.id, mst_admin_user.fname, mst_admin_user.lname, mst_admin_user.avatar, driver_availability.is_online, driver_availability.is_available FROM mst_admin_user LEFT JOIN driver_availability ON mst_admin_user.id = driver_availability.driver_id  WHERE mst_admin_user.user_type = 2 AND mst_admin_user.id = $driver_id";
$sql = $conn->query($sql);
$row = mysqli_fetch_assoc($sql);
echo json_encode($row);
?>