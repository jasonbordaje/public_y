<?php
include '../includes/dbconfig2.php';

session_start();

$loginid = $_SESSION['loginid'];

$query = "SELECT * from request_header where requested_by = $loginid and status <> 'COMPLETED' and status <> 'CANCELLED' ORDER by dateTime_requested DESC";
$query = $conn2->query($query);
$numrows = mysqli_num_rows($query);
$counter = 0;
$counter2 = 0;
$lastdate = date("D F d, Y");
if($numrows > 0){
    while($row = mysqli_fetch_assoc($query)){
       $headerid = $row['id'];  
       $date = strtotime($row['dateTime_requested']);
       $day = date("D F d, Y", $date);
       $today = date("D F d, Y");
       

       $query2 = "SELECT * from request_details where request_header_id = $headerid";
       $query2 = $conn2->query($query2);
       $numrows2 = mysqli_num_rows($query2);

       if($numrows2 > 0){
        while($row2 = mysqli_fetch_assoc($query2)){
            $dayreq = $day;
            $cost = $row2['cost'];
            $distance = $row2['distance'];
            $packtype = $row2['package_type'];

            $pack = "SELECT * from package_type where id = $packtype";
            $pack = $conn2->query($pack);
            $package = mysqli_fetch_assoc($pack);
            
            if($today == $dayreq){
              if($counter == 0){
                $list.='<div class="polaroid"><div class="clearfix" style="background-color: #d9d9d9; padding: 0 15px; color: #737373;">
                          <h6><span class="glyphicon glyphicon-time"></span> TODAY</h6>
                        </div>';
                $counter++;
              }
             $list .= '<div id="'.$row['id'].'" class="clearfix mac" value="'.$row['status'].'" style="border-bottom: #bfbfbf solid 1px; background-color: #efefef;">
                        <div class="clearfix" style="padding: 0 15px">
                          <div class="col-xs-6" style="padding: 0">
                            <h4>
                            '.ucfirst($row2['item']).'</h4>
                            <p style="color: #a6a6a6; font-size: 12px;">
                            '.$package['package_name'].'
                            </p>
                            <p style="color: #a6a6a6; font-size: 12px; color: #006600; font-weight: bold;"><span class="label label-default">Status</span> '.$row['status'].'</p>
                          </div>
                          <div class="col-xs-6" style="padding: 0">
                            <h4 style="text-align: right">&#8369; '.$cost.'</h4>
                            <p style="color: #a6a6a6; font-size: 16px; text-align: right;">'.$distance.' Kilometers</p>
                            <p style="color: #a6a6a6; font-size: 12px; text-align: right;">TAP TO CONTINUE</p>
                          </div>
                        </div>
                      </div>';
            }elseif($lastdate == $day){
              $list .='<div id="'.$row['id'].'" class="clearfix mac" value="'.$row['status'].'" style="border-bottom: #bfbfbf solid 1px; background-color: #efefef">
                        <div class="clearfix" style="padding: 0 15px">
                          <div class="col-xs-6" style="padding: 0">
                            <h4>
                            '.$row2['item'].'</h4>
                            <p style="color: #a6a6a6; font-size: 12px;">
                            '.$package['package_name'].'
                            </p>
                            <p style="color: #a6a6a6; font-size: 12px; color: #006600; font-weight: bold;"><span class="label label-default">Status</span> '.$row['status'].'</p>
                          </div>
                          <div class="col-xs-6" style="padding: 0">
                            <h4 style="text-align: right">&#8369; '.$cost.'</h4>
                            <p style="color: #a6a6a6; font-size: 16px; text-align: right;">'.$distance.' Kilometers</p>
                          </div>
                        </div>
                      </div>';
                      $counter2++;
            }else{
              if($counter > 0){
                $list .= '</div>';
              }
              if($counter2 > 0){
                $list .='</div>';
              }
              $list .= '<br><div class="polaroid"><div class="clearfix" style="background-color: #d9d9d9; padding: 0 15px; color: #737373;">
                          <h6><span class="glyphicon glyphicon-time"></span> '.$dayreq.'</h6>
                        </div>
              <div id="'.$row['id'].'" class="clearfix mac" value="'.$row['status'].'" style="border-bottom: #bfbfbf solid 1px; background-color: #efefef">
                        <div class="clearfix" style="padding: 0 15px">
                          <div class="col-xs-6" style="padding: 0">
                            <h4>
                            '.$row2['item'].'</h4>
                            <p style="color: #a6a6a6; font-size: 12px;">
                            '.$package['package_name'].'
                            </p>
                            <p style="color: #a6a6a6; font-size: 12px; color: #006600; font-weight: bold;"><span class="label label-default">Status</span> '.$row['status'].'</p>
                          </div>
                          <div class="col-xs-6" style="padding: 0">
                            <h4 style="text-align: right">&#8369; '.$cost.'</h4>
                            <p style="color: #a6a6a6; font-size: 16px; text-align: right;">'.$distance.' Kilometers</p>
                          </div>
                        </div>
                      </div>';
            }
            $lastdate = $day;
        }
       }
    }
}else{
  $list .= '<div class="clearfix" style="background-color: #d9d9d9; padding: 0 15px; color: #737373;">
                          <h6><span class="glyphicon glyphicon-time"></span> TODAY </h6>
                        </div><br>
                        <div class="clearfix" style="text-align: center; background-color: #efefef">
                          <h4 style="color: #a6a6a6; color: #737373; font-weight: bold;"> No request found.</h4>
                        </div>';
}

echo $list;


?>