<?php
include('includes/dbconfig.php');
$current_date= date('Y-m-d H:i', strtotime('+8 hours'));
$query = "SELECT * FROM `request_header` WHERE status = 'SCHEDULED' AND dateTime_scheduled LIKE '%$current_date%'";
$query = $conn->query($query);
if($query->num_rows > 0){
    echo "naa";
    while($row = mysqli_fetch_assoc($query)){
        $date_time_scheduled  = $row["dateTime_scheduled"];
        $id = $row["id"];
        $updt = "UPDATE request_header SET status = 'CONFIRMED' WHERE id = $id";
        $updt = $conn->query($updt);
        echo $date_time_scheduled;
    }
}else{
    echo "No request on this day";
}