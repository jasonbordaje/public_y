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
    <!--styles-->
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/jquery-ui.min.css">
    <link rel="stylesheet" href="css/jquery-ui.theme.min.css">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/admin.css">
    <link rel="stylesheet" type="text/css" href="css/paDrivers.css">
    <link rel="stylesheet" href="css/animate.min.css">
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
    <title>Admin Panel</title>
</head>
<body class="body" id="body">
<div class="loader1" id="loader"></div>
  <div class="whole-div" style="overflow: visible;" >
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
            </div>
            </div>
            </div>
        </div>
    </nav>
<!--endnavbar-->
<div class="container">
<div class="row" id="chatUI">
    <div class="col-sm-4">
    <h5 class="pickapp-drivers"><b>PICK</b>APP Drivers</h5>
      <div class="driversArea" id="allDrivers">
      </div>
    </div>

    <div class="col-sm-8">
      <h5 class="user-messages">User Messages</h5>
      <div class="chat-area-bg">
        <h5 class="current-chat-driver" id="currentDriver"> 
        </h5>
<!--         <div style="width:100%;height:100%" class="lds-rolling" style="display: none;">
        <div></div>
        </div> -->
        <div class="scroll" id="style-scroll">
          <div class="sender-receiver-convo" id="senderReceiver"> 
          </div>
        </div>
        <div class="for-chat">
        <div class="media">
          <div class="media-left">
            <textarea class="type-mess" placeholder="Write Message" id="write_message"/></textarea>
          </div>
          <div class="media-body">
          </div>
        </div>
        </div>
      </div>
    </div>
    
  </div>
  </div>
    <!--scripts-->
  <script src="js/jquery-3.2.1.min.js"></script>  
  <script src="js/bootstrap.min.js"></script>
  <script src="js/admin.js"></script>
  <script src="js/jquery.playSound.js"></script>
  <script src="js/jquery-ui.min.js"></script>
  <script>
    //get parameter url
  function getParameterByName(name, url) {
  if (!url) {
    url = window.location.href;
  }
  name = name.replace(/[\[\]]/g, "\\$&");
  var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
      results = regex.exec(url);
  if (!results) return null;
  if (!results[2]) return '';
  return decodeURIComponent(results[2].replace(/\+/g, " "));
  }

 paramId = getParameterByName('paramId');
  //declare global variables
  var obj,count = 0,i, is_online, is_available;
  var $allDrivers = $("#allDrivers"), $chatDriver, driver_id = paramId, query_id = "driver_id="+driver_id, $currentDriver = $("#currentDriver"), message_query, send, $senderReceiver = $("#senderReceiver"), loginid, senderid, intervalMess, interValDrivers, page = $("html, body"), intervalName, message, messageCont, paramId, did = [];

  //load available and ongoing drivers
  // interValDrivers = setInterval(function(){
  function driversList(){

      $.ajax({
      type: "GET",
      url: "drivers_list.php"
    }).done(function(data){
       obj = jQuery.parseJSON(data);
       count = obj.length;
       $allDrivers.empty();
       for(i=0;i<count;i++){
        message = obj[i].message;
        loginid = obj[i].login_id;
        senderid = obj[i].sender_id
        if(message == null){
          messageCont = "No convos yet";
        }else{
          if(loginid == senderid){
            messageCont = "You: "+message;
          }else{
            messageCont = message;
          }
          
        }
        is_online = obj[i].is_online;
        is_available = obj[i].is_available;
        if(is_online == 1 && is_available == 1){
          $allDrivers.append("<div class='media driver-bg' id='"+obj[i].driver_id+"'><div class='media-left'><img src='http://ws.yellox.ph/pickapp_ws/"+obj[i].avatar+"' width='50' height='50' style='border-radius: 50px' id='driver-avatar'></div><div class='media-body'><div class='driver-convo-wrapper'><h5 class='driver-name' style='white-space:nowrap;'>"+obj[i].fname+", "+obj[i].lname+" <span class='fa fa-circle' style='color: #00f700;'></span></h5><p class='prev-convo'>"+messageCont+"</p></div></div></div>");
        }else if(is_online == 1 && is_available == 0){
          $allDrivers.append("<div class='media driver-bg' id='"+obj[i].driver_id+"'><div class='media-left'><img src='http://ws.yellox.ph/pickapp_ws/"+obj[i].avatar+"' width='50' height='50' style='border-radius: 50px' id='driver-avatar'></div><div class='media-body'><div class='driver-convo-wrapper'><h5 class='driver-name' style='white-space:nowrap;'>"+obj[i].fname+", "+obj[i].lname+" <span class='fa fa-circle' style='color: #3f5eff;'></span></h5><p class='prev-convo'>"+messageCont+"</p></div></div></div>");
        }else{
          $allDrivers.append("<div class='media driver-bg' id='"+obj[i].driver_id+"'><div class='media-left'><img src='http://ws.yellox.ph/pickapp_ws/"+obj[i].avatar+"' width='50' height='50' style='border-radius: 50px' id='driver-avatar'></div><div class='media-body'><div class='driver-convo-wrapper'><h5 class='driver-name' style='white-space:nowrap;'>"+obj[i].fname+", "+obj[i].lname+" <span class='fa fa-circle' style='color: #242f3e;'></span></h5><p class='prev-convo'>"+messageCont+"</p></div></div></div>");
        }
       }

         $chatDriver = $(".media.driver-bg");
         $chatDriver.on("click", function(){
          driver_id = this.id;
          // $chatDriver.removeClass('active-convo');
          // $(this).addClass('active-convo');
          query_id = "driver_id="+driver_id;
          loadName(query_id);
          });

    });
  }
  driversList();
  // },3000);


  // intervalName = setInterval(function(){
  function loadName(query_id){
    $.ajax({
      type: "GET",
      url: "driver_name.php",
      data: query_id
    }).done(function(data){
        obj = jQuery.parseJSON(data);
        is_online = obj.is_online;
        is_available = obj.is_available;

        $currentDriver.empty();
        if(is_online == 1 && is_available == 1){
          $currentDriver.append("<img src='http://ws.yellox.ph/pickapp_ws/"+obj.avatar+"' width='50' height='50' style='border-radius: 50%;'> <span>"+obj.fname+", "+obj.lname+" (Available) <span class='fa fa-circle' style='color: #00f700;'></span>");

        }else if(is_online == 1 && is_available == 0){
          $currentDriver.append("<img src='http://ws.yellox.ph/pickapp_ws/"+obj.avatar+"' width='50' height='50' style='border-radius: 50%;'> <span>"+obj.fname+", "+obj.lname+" (Ongoing Delivery) <span class='fa fa-circle' style='color: #3f5eff;'></span>");
        }else{
          $currentDriver.append("<img src='http://ws.yellox.ph/pickapp_ws/"+obj.avatar+"' width='50' height='50' style='border-radius: 50%;'> <span>"+obj.fname+", "+obj.lname+" (Offline) <span class='fa fa-circle' style='color: #242f3e;'></span>");
        }
 
      });
  }

  loadName(query_id);
  // },3000);

  //sendMessage
  function sendMessage(send){
    $.ajax({
      type: "GET",
      url: "sendMessage.php",
      data: send
    }).done(function(data){
        loadConvos(query_id);

      });
  }


  // intervalMess = setInterval(function(){
    function loadConvos(query_id){  
      $.ajax({
        type: "GET",
        url: "loadConvos.php",
        data: query_id
      }).done(function(data){
          console.log(query_id);
          obj = jQuery.parseJSON(data);
          count = obj.length;
          $senderReceiver.empty();
          for(i=0;i<count;i++){
            loginid = obj[i].loginid;
            senderid = obj[i].sender_id;
            if(loginid == senderid){
              $senderReceiver.append("<div class='row message-wrapper'><h5 class='pull-right sender-message'>"+obj[i].message+"</h5></div>");
            }else{
              $senderReceiver.append("<div class='row message-wrapper1'><h5 class='pull-left receiver-message'>"+obj[i].message+"</h5></div>");
            }
            
          }
        });
    }

    loadConvos(query_id);
// }, 3000);



  $("#write_message").on("keydown", function(e){
    var message = $("#write_message").val();
    if(e.keyCode == 10 || e.keyCode == 13){
      e.preventDefault();
      send = "driver_id="+driver_id+"&message="+message;
      $("#write_message").val('');
      sendMessage(send);
    }
  });

  </script>
  </body>
  </html>




