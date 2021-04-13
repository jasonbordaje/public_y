<?php

session_start();
$id = $_SESSION['id'];
error_reporting(0);
$successSession = $_SESSION["success"];
$errorSession = $_SESSION["error"];

if($successSession){
include('admin/dashboard.php');
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
    <script src="js/jquery.playSound.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <script src="//cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBX8YQ91wJ8aX3yz_CtplmZ8hjUq9qHbQs&libraries=places&callback=initMap"></script>
    <script src="js/admin.js"></script>
    <script src="js/autoassign.js"></script>
    <!--styles-->
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/jquery-ui.min.css">
    <link rel="stylesheet" href="css/jquery-ui.theme.min.css">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/admin.css">
    <link rel="stylesheet" href="css/animate.min.css">
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
    <link href="//cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
    <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <title>Admin Panel</title>
</head>
<body class="body">
<div class="loader1" id="loader">
</div>
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
                <h5 class="account dropbtn" onclick="myFunction()">Account <span class="fa fa-caret-down"></span></h5>
                <div id="myDropdown" class="dropdown-content">
                    <div class="navigation-wrapper">
                        <a href="#register" class="a" id="btn-register"><span class="fa fa-user"></span> Register User</a>
                        
                        <a href="createRequest.php" class="a" id="btn-create"><span class="fa fa-plus"></span> Create Request</a>
                        
                        <a href="#" class="a" id="chatDriver"><span class="fa fa-comment"></span> Chat Driver</a>
                        
                        <a href="#logsWrapper" class="a" id="actionlogs"><span class="fa fa-th-list"></span> Logs <span class="fa fa-angle-down" id="angleDown"></span></a>
                        <ul class="logsWrapper" style="display: none;" id="logsList">
                            <li id="actions" style="cursor: pointer;"><span class="fa fa-handshake-o"></span> Action Logs</li>
                            <li id="reqLogs" data-target="#requestLogs" data-toggle="modal" style="cursor: pointer;"><span class="fa fa-list" ></span> Request Logs</li>
                            <li id="wowLogs" data-target="#wowreports" data-toggle="modal" style="cursor: pointer;"><span class="fa fa-list" ></span> WoW Report</li>
                            <li id="driverr" data-target="#driverrating" data-toggle="modal" style="cursor: pointer;"><span class="fa fa-list" ></span> Driver Rating</li>
                        </ul>
                        
                        <a href="#loadBalance" class="a" id="loadBalance"><span class="fa fa-money"></span> Load Balance <span class="fa fa-angle-down" id="angleDown1"></span></a>
                        <ul class="loadBalanceWrapper" id="loadBalanceList" style="display: none;">
                            <li id="pDrivers" style="cursor: pointer;"><span class="fa fa-id-card"></span> PA Driver</li>
                            <li id="pCustomer" style="cursor: pointer;"><span class="fa fa-users"></span> PA Customer</li>
                        </ul>
                        
                        <a href="#logout" class="a" id="btn-logout"><span class="fa fa-sign-out"></span> Logout</a>
                        
                    </div>
                </div>
            </div>
            </div>
            </div>
        </div>
    </nav>
<!--endnavbar-->
<!--map-->
<div id="map"></div>
<!--end map-->
<div class="container" style="width: 100%">
    <div class="row">
        <div class="col-md-2 col-sm-2">
            <div class="drivers-hider">
                <div class="drivers-available">
                    <!--p class="caption">PICKAPP <b style="font-size:18px">Drivers</b></p-->
                    <p class="caption"><b style="font-size: 16px">Yello - X Drivers</b></p>
                </div>
                <div class="drivers-section" id="drivers-section">

                </div>
            </div>
        </div>
        <div class="col-md-2 col-sm-2 pull-right pos">
            <div class="drivers-available1">
                <p class="caption"><b style="font-size: 16px">Yello - X Request</b></p>
            </div>
            <div class="request-section pull-right" id="request-section">

            </div>
        </div>
    </div>
</div>

<div data-backdrop="static" class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog" id="registerDriverNew">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Register User</h4>
            </div>
            <div class="modal-body carousel slide" id="myCarousel" data-ride="carousel">
                <form enctype="multipart/form-data" action="register.php" method="POST">
                    <input type="file" id="upload-photo" name="uploadP" style="display: none;" accept="image/*">
                    <center class="user-avatar"><img src="images/user.png" id="upload-photo-alt" width="100" height="100" class="img-hover">
                        <hr>
                    </center>
                    <div class="carousel-inner">
                        <div class="item active">
                            <div class="user-type">
                                <label>User type</label>
                                <select class="form-control usertype" name="usertype" required="">
                  <option value="1">Admin</option>
                  <option value="2">Driver</option>
                  <option value="3">Affiliate Driver</option>
                </select>
                            </div>
                            <div class="user-name">
                                <label>Username</label>
                                <input type="text" class="form-control username" name="username" placeholder="Username" required="">
                            </div>
                            <div class="pass-word">
                                <label>Password</label>
                                <input type="password" class="form-control password" name="password" placeholder="Password" required="">
                            </div>
                            <div class="">
                                <button type="button" data-target="#myCarousel" data-slide="next" class="btn btn-primary btn-block" id="btn-proceed">Proceed</button>
                            </div>
                        </div>
                        <div class="item" id="second">
                            <div class="f-name">
                                <label>First Name</label>
                                <input type="text" class="form-control fname" name="fname" placeholder="First Name" required="">
                            </div>
                            <div class="l-name">
                                <label>Last Name</label>
                                <input type="text" class="form-control lname" name="lname" placeholder="Last Name" required="">
                            </div>
                            <div class="m-name">
                                <label>Middle Name</label>
                                <input type="text" class="form-control mname" name="mname" placeholder="Middle Name" required="">
                            </div>
                            <div class="contact-number">
                                <label>Contact Number</label>
                                <input type="number" class="form-control contactnumber" name="contactnumber" placeholder="Contact Number" required="">
                            </div>
                            <div class="email-add">
                                <label>Email Address</label>
                                <input type="email" class="form-control emailadd" name="emailadd" placeholder="Email Address" required="">
                            </div>
                            <div class="license-no">
                                <label>License Number</label>
                                <input type="text" class="form-control licenseno" name="licenseno" placeholder="License Number" required="">
                            </div>
                            <div class="api-key">
                                <label>Google Api Key</label>
                                <input type="text" class="form-control apikey" name="apikey" placeholder="Api Key" required="">
                            </div>
                            <button type="button" data-target="#myCarousel" data-slide="prev" class="btn btn-primary">Previous</button>
                            <input type="submit" class="btn btn-primary pull-right" value="Register" />
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>

<!--request logs-->
<div class="modal fade" id="requestLogs" role="dialog">
    <div class="modal-dialog" style="width: 90%">
        <div class="modal-content" id="requestHistory" id="requestHistory">
            <div id="requestCarousel" class="carousel slide" data-ride="carousel" data-interval="false">
                <div class="carousel-inner">
                    <div class="item active">
                        <div class="modal-header" id="complete">
                            <div class="modal-title">
                                <h4 style="text-align: center;" id="reqComplete">Requests Logs <span class="rl-status">(Completed)</span>
                                <button type="button" data-dismiss="modal" class="close">×</button></h4>
                            </div>
                        </div>
                        <div class="modal-body" id="bodyModal">
                            <div class="filter">
                                <div id="datepicker1">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <label>Start Date</label>
                                            <input type="text" id="startDate" class="form-control">
                                        </div>
                                        <div class="col-sm-3">
                                            <label>End Date</label>
                                            <input type="text" id="endDate" class="form-control">
                                        </div>
                                        <div class="col-sm-3">
                                            <label>Assigned Driver</label>
                                            <select id="drivers-assign"  class="form-control">
                                                <option value="0" selected="">Show All</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="dropdown" id="drop">
                                                <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" style="margin: 20px 0"><span class="fa fa-search"></span> Display<span class="caret"></span></button>
                                                <button type="button" class="btn btn-success btn-md" id="createReport" style="background: #333">Excel Report</button>
                                                <ul class="dropdown-menu">
                                                    <li><a href="#" id="btn-search" value="1">Completed</a>
                                                    </li>
                                                    <li><a href="#" id="btn-search" value="2">Cancelled</a></li>
                                                    <li><a href="#" id="btn-search" value="3">Ongoing</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr class="top-diver">
                            <!-- <div class="table-responsive" id="pagination-data" style="overflow: hidden">
                            </div> -->
                            <table class="table table-striped" id="tableID">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Driver Assigned</th>
                                        <th>Requested By</th>
                                        <th>Item Requested</th>
                                        <th>Origin Address</th>
                                        <th>Destination Address</th>
                                        <th>Distance</th>
                                        <th>Cost</th>
                                        <th>Date Requested</th>
                                        <th>Date Delivered</th>
                                        <th>Hours / Minutes Completed</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <div class="item">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!--request logs-->
<div class="modal fade" id="registeredUser" role="dialog">
    <div class="modal-dialog" style="width: 90%">
        <div class="modal-content" id="requestHistory" id="requestHistory">
            <div id="requestCarousel" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    <div class="item active">
                        <div class="modal-header" id="complete1">
                            <div class="modal-title">
                                <h4 style="text-align: center;" id="reqComplete">Registered User 
                                <button type="button" data-dismiss="modal" class="close">×</button></h4>
                            </div>
                        </div>
                        <div class="modal-body" id="bodyModal">
                            <button type="button" class="btn btn-primary " data-target="#myModal" id="registerNew" data-toggle="modal">Register new Driver</button>
                            <hr class="top-diver1">
                            <table class="table table-striped" id="tableID1">
                                <thead>
                                    <tr class="reqHeader1">
                                        <th>No.</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Contact No.</th>
                                        <th>Email Add.</th>
                                        <th>License No.</th>
                                        <th>Date Registered</th>
                                        <th>Google Api Key</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!--assign driver-->
<!--assign driver-->
<div data-backdrop="static" class="modal fade" id="assignDriver" role="dialog">
    <div class="ad-wrapper">
    <div class="ad-subwrapper">
    <div class="modal-dialog">
        <div class="modal-content" id="assignContent">
            <div class="modal-header" id="coloHeader">
                <button type="button" data-dismiss="modal" class="close">&times;</button>
                <div class="modal-title">
                    <h4 class="h4">Assign Driver</h4>
                </div>
            </div>
            <div class="modal-body" id="assignDriverBody">
                <div class="alert alert-danger alert-dismissable fade in" id="noChosenDriver" style="display: none; text-align: center;">
                    <strong>Error!</strong> Please choose a driver.
                </div>
                <p id="assignCaption">Assign <b id="nameOfRequestor"></b> request to this driver: </p>
                <table class="table table-striped" id="bottomMarging">
                    <tr>
                        <th colspan="5">
                            <center>Available PickApp Drivers</center>
                        </th>
                    </tr>
                    <tr>
                        <th>No.</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Status</th>
                        <th>Assign</th>
                    </tr>
                    <tbody id="driversAvailable">
                    </tbody>

                </table>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary btn-block" id="btn-assign">Assign</button>
            </div>
        </div>
    </div>
    </div>
    </div>
</div>


<!--Transfer request-->
<div data-backdrop="static" class="modal fade" id="assignDriver1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content" id="assignContent">
            <div class="modal-header" id="coloHeader">
                <button type="button" data-dismiss="modal" class="close">&times;</button>
                <div class="modal-title">
                    <h4 class="h4">Transfer Driver</h4>
                </div>
            </div>
            <div class="modal-body" id="assignDriverBody">
                <div class="alert alert-danger alert-dismissable fade in" id="noChosenDriver" style="display: none; text-align: center;">
                    <strong>Error!</strong> Please choose a driver.
                </div>
                <div class="alert alert-success" id="success-transfer" style="display: none;"><a href="#" class="close" data-dismiss="alert" aria-label="close">×</a><strong>Success!</strong> Request Transferred!</div>
                <p id="assignCaption">Transfer <b id="nameOfRequestor1"></b> request to this driver: </p>
                <table class="table table-striped" id="bottomMarging">
                    <tr>
                        <th colspan="5">
                            <center>Available PickApp Drivers</center>
                        </th>
                    </tr>
                    <tr>
                        <th>No.</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Status</th>
                        <th>Assign</th>
                    </tr>
                    <tbody id="driversAvailable1">
                    </tbody>

                </table>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary btn-block" id="btn-assign1">Transfer</button>
            </div>
        </div>
    </div>
</div>

<!--CONFIRMATION-->
<div data-backdrop="static" class="modal fade" id="confirmDriver" role="dialog">
    <div class="cd-wrapper">
    <div class="cd-subwrapper">
    <div class="modal-dialog">
        <div class="modal-content" id="assignContent1">
            <div class="modal-header" id="assignContentHeader">
                <button type="button" data-dismiss="modal" class="close">&times;</button>
                <div class="modal-title">
                    <h4><span class='fa fa-question-circle'></span> Confirm</h4>
                </div>
            </div>
            <div class="modal-body" id="assignDriverBody">
                <h4 id="caption-confirmation"> Do you want this driver to take this request?</h4>
            </div>
            <div class="modal-footer center-block">
                <div class="row">
                    <div class="col-sm-6">
                        <button class="btn btn-primary btn-block" id="btn-yes">Yes</button>
                    </div>
                    <div class="col-sm-6">
                        <button class="btn btn-danger btn-block" id="btn-no">No</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
</div>

<!--CONFIRMATION-->
<div data-backdrop="static" class="modal fade" id="confirmDriver1" role="dialog">
    <div class="cd-wrapper">
        <div class="cd-subwrapper">
    <div class="modal-dialog">
        <div class="modal-content" id="assignContent1">
            <div class="modal-header" id="assignContentHeader">
                <button type="button" data-dismiss="modal" class="close">&times;</button>
                <div class="modal-title">
                    <h4><span class='fa fa-question-circle'></span> Confirm</h4>
                </div>
            </div>
            <div class="modal-body" id="assignDriverBody">
                <h4 id="caption-confirmation">Are you sure you want to cancel this request?</h4>
            </div>
            <div class="modal-footer center-block">
                <div class="row">
                    <div class="col-sm-6">
                        <button class="btn btn-primary btn-block" id="btn-yes1">Yes</button>
                    </div>
                    <div class="col-sm-6">
                        <button class="btn btn-danger btn-block" id="btn-no1">No</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>

<div data-backdrop="static" class="modal fade" id="confirmDriver2" role="dialog">
    <div class="cd-wrapper">
        <div class="cd-subwrapper">
    <div class="modal-dialog">
        <div class="modal-content" id="assignContent1">
            <div class="modal-header" id="assignContentHeader">
                <button type="button" data-dismiss="modal" class="close">&times;</button>
                <div class="modal-title">
                    <h4><span class='fa fa-question-circle'></span> Confirm</h4>
                </div>
            </div>
            <div class="modal-body" id="assignDriverBody">
                <h4 id="caption-confirmation">Are you sure you want to send a message to <b id="requestName"></b>?</h4>
            </div>
            <div class="modal-footer center-block">
                <div class="row">
                    <div class="col-sm-6">
                        <button class="btn btn-primary btn-block" id="btn-yes2">Yes</button>
                    </div>
                    <div class="col-sm-6">
                        <button class="btn btn-danger btn-block" id="btn-no2">No</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>

<div data-backdrop="static" class="modal fade" id="inputPass" role="dialog">
    <div class="ip-wrapper">
        <div class="ip-subwrapper">
    <div class="modal-dialog">
        <div class="modal-content" id="assignContent2">
            <div class="modal-header" id="assignContentHeader">
                <button type="button" data-dismiss="modal" class="close">&times;</button>
                <div class="modal-title">
                    <h4><span class="fa fa-exclamation-triangle"></span> Password Required</h4>
                </div>
            </div>
            <div class="modal-body" id="assignDriverBody">
                <h5>Please type your password to Cancel the Request</h5>
                <label>Input password: </label>
                <input type="password" id="passtype" class="btn-block" placeholder="Input password">
                <button class="btn btn-primary btn-block" id="btn-go">Proceed</button>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>
</div>

<div data-backdrop="static" class="modal fade" id="inputPass1" role="dialog">
    <div class="ip-wrapper">
        <div class="ip-subwrapper">
    <div class="modal-dialog">
        <div class="modal-content" id="assignContent2">
            <div class="modal-header" id="assignContentHeader">
                <button type="button" data-dismiss="modal" class="close">&times;</button>
                <div class="modal-title">
                    <h4><span class="fa fa-exclamation-triangle"></span> Password Required</h4>
                </div>
            </div>
            <div class="modal-body" id="assignDriverBody">
                <h5 id="ccc">Please type your password to Transfer the Request</h5>
                <label>Input password: </label>
                <input type="password" id="passtype1" class="btn-block" placeholder="Input password" style="padding: 5px">
                <button class="btn btn-primary btn-block" id="btn-go1" style="margin-top: 10px">Proceed</button>
            </div>
        </div>
    </div>
</div>
</div>
</div>

<!--ACCEPTED or REJECTED-->
<div data-backdrop="static" class="modal fade" id="statusRejectAccept" role="dialog" style="background: rgba(0, 0, 0, 0.25);">
    <div class="sra-wrapper">
    <div class="sra-subwrapper">
    <div class="modal-dialog">
        <div class="modal-content" id="assignContent1">
            <div class="modal-header" id="assignContentHeader">
                <button type="button" data-dismiss="modal" class="close">&times;</button>
                <div class="modal-title">
                    <h4 id="driverResponse"></h4>
                </div>
            </div>
            <div class="modal-body" id="assignDriverBody">
                <h4 id="requestContent"></h4>
            </div>
            <div class="modal-footer center-block">
                <div class="row">
                    <div class="col-sm-6 pull-right">
                    <button class="btn btn-primary btn-block" id="btn-ok">Ok</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
</div>


<div data-backdrop="static" class="modal fade" id="fileInput" role="dialog">
    <div class="dialog-wrapper">
        <div class="dialog-subwrapper">
            <div class="modal-dialog">
                <div class="modal-content" id="assignContent3">
                    <div class="modal-header" id="assignContentHeader">
                        <button type="button" data-dismiss="modal" class="close">&times;</button>
                        <div class="modal-title">
                            <h4><span class="fa fa-file-excel-o"></span> Document Filename</h4>
                        </div>
                    </div>
                    <div class="modal-body" id="assignDriverBody">
                        <label>Input Filename: </label>
                        <form method="POST" action="export.php">
                            <div class="form-group">
                                <input type="hidden" class="btn-block" placeholder="Filename" id="statusCheck" name="drr">
                                <input type="hidden" class="btn-block" placeholder="Filename" id="filename1" name="startDate1">
                                <input type="hidden" class="btn-block" placeholder="Filename" id="filename2" name="endDate1">
                                <input type="hidden" class="btn-block" placeholder="Filename" id="filename3" name="driverVal1">
                                <input type="text" class="btn-block form-control" placeholder="Filename" id="filename" name="filename">
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-primary btn-block btn-lg" name="btn-download" id="btn-downloads" value="Download">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--logs-->
<div data-backdrop="static" class="modal fade" id="logs" role="dialog">
    <div class="middle-wrapper">
        <div class="middle-subwrapper">
    <div class="modal-dialog">
        <div class="modal-content" id="logsContent">
            <div class="modal-header" id="logsHeader">
                <button type="button" data-dismiss="modal" class="close">&times;</button>
                <div class="modal-title">
                    <h4 class="h4">Logs</h4>
                </div>
            </div>
            <form method="POST" action="logs_export.php">
            <div class="modal-body" id="logsBody">
                <div id="datepicker1" class="datepickerwrap">
                    <label>Start Date</label>
                    <input type="text" id="startDate11" name="starts"> &bull;
                    <label>End Date</label>
                    <input type="text" id="endDate11" name="ends">
                    <div class="dropdown pull-right" id="drop">
                        <button class="btn btn-primary dropdown-toggle" id="btn-query" type="button"><span class="fa fa-search"></span>Search</button>
                    </div>
                </div>
                <div class="export-to-excel">
                        <input type="submit" class="btn btn-success btn-md" id="btn-export-to-excel" name="export-data" value="Export to Excel" disabled="">
                </div>
                <table class="table table-striped" id="">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Action taken</th>
                            <th>Request Id</th>
                            <th>Requested By</th>
                            <th>Date/Time Performed</th>
                        </tr>
                    </thead>
                    <tbody id="logsData">
                    </tbody>
                </table>
            </div>
            </form>
        </div>
    </div>
</div>
</div>
</div>

<div class="modal fade" id="confirmrequestmodal">
    <div class="sra-wrapper">
        <div class="sra-subwrapper">
            <div class="modal-dialog">
                <div class="modal-content" style="width: 20em;font-size: 18px;margin: auto">
                    <div class="modal-header">
                        <button type="button" data-dismiss="modal" class="close">×</button>
                        <h3 class="modal-title" style="text-align: center">Request Details</h3>
                    </div>
                    <div class="modal-body">
                        <div class="confirmrequestdetails">                            
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary btn-lg btn-block" data-dismiss="modal">Ok</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--wow reports-->
<div class="modal fade" id="wowreports">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Week on Week Reports 
                <button class="close" data-dismiss="modal">x</button></h3>
            </div>
            <div class="modal-body">
                <form method="POST" action="wow.php">
                    <div class="form-group">
                        <label>Start Date</label>
                        <input type="date" class="form-control" name="sd">
                    </div>
                    <div class="form-group">
                        <label>End Date</label>
                        <input type="date" class="form-control" name="ed">
                    </div>
                    <div class="form-group">
                        <button type="submit" name="dp" class="btn btn-primary">Download Report</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!--Driver Rating-->
<div class="modal fade" id="driverrating">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Driver Rating 
                <button class="close" data-dismiss="modal">x</button></h3>
            </div>
            <div class="modal-body">
                <table class="table table-striped" id="tabledriverrating">
                    <thead>
                        <tr class="driverratingtb">
                            <th>Driver Name</th>
                            <th>Rating</th>
                            <th>Remarks</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
<?php
include("completeRequestModal.php");
?>

</body>
</html>
