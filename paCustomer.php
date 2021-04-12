<?php
session_start();

$id = $_SESSION['id'];
error_reporting(0);
$successSession = $_SESSION["success"];
$errorSession = $_SESSION["error"];

if($successSession){
include('admin/addCredit.php');
}

else{
  echo "<script>window.location.replace('checkSession.php')</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
  <!--meta-->
  <meta charset="utf-8" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="format-detection" content="telephone=no" />
    <meta name="msapplication-tap-highlight" content="no" />
    <meta name="viewport" content="user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1, width=device-width"/>
    <meta name="viewport" content="initial-scale=1.0">
    <meta charset="utf-8">
  <!--scripts-->
  <script src="js/jquery-3.2.1.min.js"></script>  
    <script src="js/bootstrap.min.js"></script>
    <script src="js/admin.js"></script>
    <script src="js/jquery.playSound.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <!--styles-->
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/jquery-ui.min.css">
    <link rel="stylesheet" href="css/jquery-ui.theme.min.css">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/admin.css">
    <link rel="stylesheet" type="text/css" href="css/paDrivers.css">
    <link rel="stylesheet" href="css/animate.min.css">
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <title>Admin Panel</title>
</head>
<body>
<div class="loader1" id="loader"></div>
<!--navbar-->
<nav class="navbar navbar-header navbar-fixed-top" style="margin-bottom: 0;">
  <div class="row" style="height: 100%; margin: 0">
      <div class="row1">
      <div class="row2">
      <div class="col-sm-1" style="text-align: center; left: 1em">
          <a href="dashboard.php"><img src="images/title.png" class="logo" style="margin: 10px"></a>
      </div>
      <div class="col-sm-2">
          <h5 class="admin">&nbsp;&nbsp;Admin</h5>
      </div>
      <div class="col-sm-2" style="text-align: center; float: right">
                <h5 class="account dropbtn" >Customer Credit </h5>
      </div>
      </div>
  </div>
</nav>
<!--endnavbar-->
<div class="container">
  <div class="ac-wrapper">
    <div class="ac-subwrapper">
      <div class="form-wrapper">
          <h4 class="credits">Add credits</h4>
            <form method="POST" action="addCustomerCredit.php">
                <div class="input-groups">
                  <div class="form-group">
                      <select class="form-control select-driver input-lg" id="driver-list" name="driver">
                      <option disabled="disabled" selected="selected" >Select Customer</option>
                      </select>
                  </div>
                  <div class="form-group">
                    <input type="text" class="form-control input-lg" id="old-balance" step="0.01"  readonly="readonly" placeholder="Old Customer Balance">
                  </div>
                  <div class="form-group">
                    <input type="text" class="form-control input-lg" id="amountEntered" name="amount" step="0.01" required="required" placeholder="New Customer Balance">
                  </div>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary btn-block input-lg credits-submit" value="Submit" on> 
                </div>
            </form>
      </div>
    </div>
  </div>
</div>
  <script>
    var obj, count = 0, i;

    $.ajax({
      type: "GET",
      url: "getCustomer.php",
      success: function(data){
        obj = jQuery.parseJSON(data);
        count = obj.length;

        for(i=0;i<count;i++){
          $("#driver-list").append("<option value="+obj[i].id+">"+obj[i].fname+", "+obj[i].lname+"</option>");
        }

        $("#driver-list").on('change', function(){
          $("#loader").show();
          var id = $("#driver-list").val();
          var data = "id="+id;
          checkBal(data);
        });
      }
    });

    function checkBal(data){  
      $.ajax({
        type: "POST",
        url: "checkBalCustomer.php",
        data: data,
        success: function(data){
          $("#loader").hide();
          $("#old-balance").val(Number(data));
        }
      });
    }
  </script>
  </body>
  </html>




