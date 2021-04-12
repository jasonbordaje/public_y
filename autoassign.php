<?php
include('includes/dbconfig.php');

$query = "SELECT rh.id as rhid, rh.requested_by, rd.cost, rd.origin_lat, rd.origin_lng, rd.destination_lat, rd.destination_lng FROM request_header as rh LEFT JOIN request_details as rd ON rh.id = rd.request_header_id WHERE rh.status = 'CONFIRMED' AND rh.assigned_driver = 0 AND (rd.origin_lat IS NOT NULL AND rd.origin_lng IS NOT NULL AND rd.destination_lat IS NOT NULL AND rd.destination_lng IS NOT NULL)";

$query = $conn->query($query);
if($query->num_rows > 0){
    $row=mysqli_fetch_assoc($query);
    $request_id = $row["rhid"];
    $origin_lng = $row["origin_lng"];
    $origin_lat = $row["origin_lat"];
    $cost = $row["cost"];

    $checkledger = checkLedger($conn, $origin_lng, $origin_lat, $cost,$request_id);
}else{
    echo "No Confirmed!";
}

function checkLedger($conn, $origin_lng, $origin_lat, $cost,$request_id){
    $query_ledger = "SELECT * FROM request_ledger WHERE request_header_id = $request_id";
    $query_ledger = $conn->query($query_ledger);
    $driver_id = 0;
    $exist_driver_array = [];
    $count = 0;
    $condition = '';
    if($query_ledger->num_rows>0){
        while($qlrow = mysqli_fetch_assoc($query_ledger)){
            $exist_driver_array[$count] = $qlrow["driver_id"];
            $count++;
        }
        $condition = "AND da.driver_id <> ".implode(" AND da.driver_id <> " ,$exist_driver_array);
    }else{
        $condition = checkDriverIsConfirmedIsDeclined($conn,$request_id);
    }
    
    $pickdriver = chooseDriver($conn, $origin_lng, $origin_lat, $cost,$request_id, $condition);
}

function checkDriverIsConfirmedIsDeclined($conn,$request_id){
    $createdate= date('Y-m-d');
    $query_ledger = "SELECT * FROM request_ledger WHERE isConfirmed = 0 AND isDeclined = 0 AND request_header_id = $request_id AND dateTime_added LIKE '%$createdate%'";
    $query_ledger = $conn->query($query_ledger);
    $driver_id = 0;
    $exist_driver_array = [];
    $count = 0;
    $condition = '';
    if($query_ledger->num_rows>0){
        while($row=mysqli_fetch_assoc($query_ledger)){
            $exist_driver_array[$count] = $row["driver_id"];
            $count++;
        }
        $condition = "AND da.driver_id <> ".implode(" AND da.driver_id <> " ,$exist_driver_array);
    }

    return $condition;
}

function sendSMSNotif($name, $number){
    include('sms/sms_function.php');
    $number = '63'.(int)$number;
    $message = "Hey ".$name." a booking has been assigned to you. Please open Yello X app to accept.";
    $send = sendSMS($message, $number);
}

function chooseDriver($conn, $origin_lng, $origin_lat, $cost,$request_id, $condition){
    $getdriver = "SELECT da.driver_id, mau.balance FROM driver_availability as da LEFT JOIN mst_admin_user as mau ON da.driver_id = mau.id WHERE (da.is_online = 1 AND da.is_available =1) AND mau.user_type = 2 ".$condition."";
    $getdriver = $conn->query($getdriver);
    $distancearray = [];
    $driverarray = [];
    $driverbalance = [];
    $count = 0;

    if($getdriver->num_rows > 0){
        while($row=mysqli_fetch_assoc($getdriver)){
            $driverid = $row["driver_id"];
            $balance = $row["balance"];
            $distance = getlocation($conn, $driverid, $origin_lng, $origin_lat);
            $distancearray[$count] = $distance;
            $driverarray[$count] = $driverid;
            $driverbalance[$count] = $balance;
            $count++;
        }

        $smallest_distance = min($distancearray);
        $index = array_search(min($distancearray), $distancearray);
        $driver = $driverarray[$index];
        $driverbal = $driverbalance[$index];

        $assign = assignDriver($conn, $driver, $origin_lng, $origin_lat, $smallest_distance, $cost, $request_id,$driverbal);

        echo $assign;
    }else{
        echo "No Drivers!";
    }
}

function assignDriver($conn, $driver, $origin_lng, $origin_lat,  $smallest_distance, $cost, $request_id,$driverbal){
    $createdate= date('Y-m-d H:i:s', strtotime('+8 hours'));
    $message = '';

    $checkBal = checkBalance($conn, $driver, $cost, $request_id,$driverbal);

    switch($checkBal){
        case 0:
            $call_again = checkLedger($conn, $origin_lng, $origin_lat, $cost,$request_id);
            $message = "Declined low Balance or Already Assigned!";
        break;
        case 1:  
            $updaterh = "UPDATE request_header SET assigned_driver = $driver WHERE id = $request_id";
            $updaterh = $conn->query($updaterh);
            
            $insertledger = "INSERT INTO request_ledger (request_header_id, driver_id, dateTime_added) VALUES($request_id, $driver, '$createdate')";
            $insertledger = $conn->query($insertledger);
            $message = "Inserted Successfuly!";

            $name = getDriverDetails($conn, $driver);

            $drivername = $name[0];
            $mobile = $name[1];
            sendSMSNotif($drivername, $mobile);
        break;
    }

    echo $message;
}

function getDriverDetails($conn, $driverid){
    $driverquery = "SELECT * FROM mst_admin_user WHERE id = $driverid";
    $driverquery = $conn->query($driverquery);
    $row = mysqli_fetch_assoc($driverquery);
    $firstname = $row["fname"];
    $lastname = $row["lname"];
    $fullname = $firstname." ".$lastname;
    $mobile = $row["contact_no"];
    $details = [$fullname, $mobile];
    return $details;
}

function checkBalance($conn, $driver, $cost, $request_id,$driverbal){
    $comm = $cost * .3;
    $message = '';
    if($driverbal < $comm){
        $query = "UPDATE request_header set assigned_driver = 0 where id = $request_id";
        $query = $conn2->query($query);

        $update = "UPDATE request_ledger set declined_by = 'SYSTEM', isDeclined = 1, dateTime_updated = '$newTime' where request_header_id = $request_id and  driver_id = $driver";
        $conn->query($update);

        $message = 0;
    }else{
        $message = 1;
    }

    return $message;
}

function getlocation($conn, $driverid, $origin_lng, $origin_lat){
    $driverloc = "SELECT * FROM delivery_tracking WHERE driver_id = $driverid ORDER BY id DESC LIMIT 1";
    $driverloc = $conn->query($driverloc);

    $row = mysqli_fetch_assoc($driverloc);
    $driver_lat = $row["location_lat"];
    $driver_lng = $row["location_long"];

    $distance = haversineGreatCircleDistance($origin_lat, $origin_lng, $driver_lat, $driver_lng);
    $inkm = $distance / 1000;

    return number_format($inkm,2);
}

function haversineGreatCircleDistance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371000)
  {
    // convert from degrees to radians
    $latFrom = deg2rad($latitudeFrom);
    $lonFrom = deg2rad($longitudeFrom);
    $latTo = deg2rad($latitudeTo);
    $lonTo = deg2rad($longitudeTo);
  
    $latDelta = $latTo - $latFrom;
    $lonDelta = $lonTo - $lonFrom;
  
    $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
      cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
    return $angle * $earthRadius;
  }