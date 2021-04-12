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
    <script src="js/moment.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/createRequest.js"></script>
    <script src="js/jquery.playSound.js"></script>
    <script src="js/bootstrap-datetimepicker.min.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <!--styles-->
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/jquery-ui.min.css">
    <link rel="stylesheet" href="css/jquery-ui.theme.min.css">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/admin.css">
    <link rel="stylesheet" type="text/css" href="css/createRequest.css">
    <link rel="stylesheet" href="css/animate.min.css">
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
    <link rel="stylesheet" href="css/bootstrap-datetimepicker.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <title>Admin Panel</title>
</head>
<body class="body">
<div class="loader1" id="loader"></div>
<!--navbar-->
<nav class="navbar navbar-header" style="margin-bottom: 0;">
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
          <h5 class="account dropbtn" onclick="location.replace('dashboard.php')">Home <span class="fa fa-home"></span></h5>
        </div>
      </div>
    </div>
  </div>
</nav>
<!--end navbar-->
<div class="container">
  <div class="row requestAreas">
    <!--col-md-6-->
    <div class="col-md-6">
      <div class="requestInputsWrapper">
        <div class="requestInputSubwrapper">
          <h4 class="createRequest">Create Request <b id="accountIdentifier"></b></h4>
          <div class="textBoxes">
            <input type="hidden" id="bal" class="form-control" disabled="disabled">
            <input type="text" id="deliveryTime" class="form-control" placeholder="Delivery Time" disabled="disabled">
            <input type="text" id="pickupPoint" class="form-control" placeholder="Pickup Point" disabled="disabled">
            <input type="hidden" id="pckpupptlat">
            <input type="hidden" id="pckpupptlng">
            <input type="text" id="dropoffPoint" class="form-control" placeholder="Drop-off Point" disabled="disabled">
            <input type="hidden" id="drpoffptlat">
            <input type="hidden" id="drpoffptlng">
            <input type="text" id="sendersName" class="form-control" placeholder="Sender's Name" disabled="disabled">
            <input type="text" id="senderContact" class="form-control" placeholder="Contact Number" disabled="disabled">
            <input type="text" list="recepientNames" id="receiversName" class="form-control" placeholder="Receiver's Name" disabled="disabled">
            <datalist id="recepientNames">
            </datalist>
            <input type="text" id="receiverContact" class="form-control" placeholder="Contact Number" disabled="disabled">
            <input type="text" list="itemList" id="itemType" class="form-control" placeholder="Item Type" disabled="disabled">
            <datalist id="itemList">
            </datalist>
            <input type="text" id="Note" class="form-control" placeholder="Note" disabled="disabled">
            <div class="buttonsWrapper">
              <button type="button" class=" btn btn-lg btn-cancel" id="btn-cancel">Cancel</button>
              <button type="button" class=" btn btn-lg btn-submit" id="btn-submit" disabled="disabled">Submit</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--end col-md-6-->
    <!--col-md-6-->
    <div class="col-md-6">
      <div class="requestInputsWrapper">
        <div class="requestInputSubwrapper">
          <div class="pr">
            <h5 class="headerCaption" style="display: none;">Pending Request</h5>
            <div class="requestPendingDetails">
                <div class="details" id="accordion">
                </div>
                <div class="btn-wrap" style="display: none;">
                  <button class="btn btn-confirm btn-lg " id="btn-confirm">Confirm Request</button>
                </div>
            </div>
          </div>
          <div class="npr">
            <h5 class="emptyPe" style="display: none;">No pending Request!</h5>
          </div>
          <div class="crh-button">
            <button class="btn btn-primary btn-lg" id="btn-create" type="button">Create Request Header</button>
          </div>
        </div>
      </div>
      <div class="requestPendingWrapper">
      </div>
    </div>
    <!--end col-md-6-->
  </div>
</div>


<div data-backdrop="static" class="modal fade" id="listOfUsers" tabindex="-1" role="dialog" aria-labelledby="listOfUsers" aria-hidden="true">
  <div class="listOfUsersWrapper">
    <div class="requestInputSubwrapper">
      <div class="modal-dialog" role="document">
        <div class="modal-content" id="listContent">
          <div class="modal-header" id="listHeader">
            <h5 class="modal-title" id="exampleModalLabel">Choose a User </h5>
          </div>
          <div class="modal-body" id="mbody">
            <div class="controls">
              <h6 style="font-size: 16px" id="accountName">Regular Account</h6>
              <input class="form-control" placeholder="Search Account Name" id="acctName">
            </div>
            <table class="table table-striped table-custom-style">
              <thead>
                <tr>
                  <th>Account Name</th>
                  <th>Account Type</th>
                </tr>
              </thead>
              <tbody id="accountList">
                <tr>
                  <td colspan="2" style="text-align:center">No Data Available!</td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="btn-proceed">Proceed</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBX8YQ91wJ8aX3yz_CtplmZ8hjUq9qHbQs&libraries=places&callback=initMap" async defer></script>
  </body>
  </html>




