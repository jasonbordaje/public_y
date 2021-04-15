<?php
    include('../includes/global.php');
?>
<nav class="navbar navbar-header navbar-fixed-top" style="margin-bottom: 0;">
        <div class="row" style="height: 100%; margin: 0">
            <div class="row1">
            <div class="row2">
            <div class="col-sm-1" style="text-align: center; left: 1em">
                <a href="dashboard.php"><img src="<?php echo $url_home; ?>/images/title.png" class="logo" style="margin: 10px"></a>
            </div>
            <div class="col-sm-2">
                <h5 class="admin">&nbsp;&nbsp;Admin</h5>
            </div>
            <div class="col-sm-2" style="text-align: center; float: right">
                <h5 class="account dropbtn" onclick="myFunction()">Account <span class="fa fa-caret-down"></span></h5>
                <div id="myDropdown" class="dropdown-content">
                    <div class="navigation-wrapper">
                        <a href="#register" class="a" id="btn-register"><span class="fa fa-user"></span> Register User</a>
                        <a href="maintenance/location/index.php" target="_blank">Add Location</a>
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