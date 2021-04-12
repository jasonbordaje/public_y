<?php
include '../includes/dbconfig3.php';

session_start();

$loginid = $_SESSION['loginid'];

$query = "SELECT * from abln_manufacturers";
$query = $conn3->query($query);
$numrows = mysqli_num_rows($query);

if($numrows > 0){
    while($row = mysqli_fetch_assoc($query)){
       $manid = $row['manufacturer_id'];  
       $manname = $row['name'];
       
       $query2 = "SELECT resource_id from abln_resource_map where object_name = 'manufacturers' and object_id = $manid ";
       $query2 = $conn3->query($query2);
       $numrows2 = mysqli_num_rows($query2);

        while($row2 = mysqli_fetch_assoc($query2)){
            $resource_id = $row2['resource_id'];
            
            $pack = "SELECT resource_path from abln_resource_descriptions where resource_id = $resource_id";
            $pack = $conn3->query($pack);
            $package = mysqli_fetch_assoc($pack);
            $path = $package['resource_path'];
            
             $list .= '<div id="pickappVendor" style="width:386px; height:203px; background-color: #efefef;) no-repeat;">
             <a href="vendorItems.html?vid='.$resource_id.'"><img src="http://store.cssolutions.ph/resources/image/'.$path.'" /></a>
             </div>
             <div style="height:20px; width:98%; margin-left:5px;"><span style="color: #a6a6a6; color: #737373; font-size:20px; font-weight:bold;">'.$manname.'</span>&nbsp;&nbsp;&nbsp;<span style="font-size:14px;">Min order: Php 300.00</span></div>
             <div style="height:20px; width:98%; margin-left:5px;"></div>';
        }
    }
}else{
  $list .= '<div style="border-bottom: #bfbfbf solid 1px; width: 386px; height: 203px; background-color: #efefef;">
                        <div class="clearfix" style="text-align: center; background-color: #efefef">
                          <h4 style="color: #a6a6a6; color: #737373; font-weight: bold;"> No available vendor.</h4>
                        </div>';
}

echo $list;


?>