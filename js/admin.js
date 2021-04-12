
document.addEventListener('DOMContentLoaded', function() {
    if (Notification.permission !== "granted")
        Notification.requestPermission();
});

var $startDate11 = $("#startDate11");
var $endDate11 = $("#endDate11");
var searchFilter = 0;
var stat, mytime;
var animationName = "animated shake";
var animationName1 = "animated fadeInDown";
var gMarker = [], gMarker1 = [];
var page = 1;
var obj, data1, data2, countdd = 0;
var count, i, clickB, drr, headID = [],
    headID1 = [];
var map, marker1, assignData;
var myLatLng, image, imgVal;
var marker, i, customerPos, marker2;
var icon, icon1, bounds, customerLat, customerLng, icon2, icon3, icon4, icon5, icon6, triggerOpen, requestID, statusName;
myLatLng = {
    lat: 10.2609857,
    lng: 123.8437432
};

$(document).ready(function(){
initMap();

function initMap() {
    bounds = new google.maps.LatLngBounds();
    var directionsDisplay = [];
    var directionsService = new google.maps.DirectionsService;

    map = new google.maps.Map(document.getElementById('map'), {
        center: myLatLng,
        zoom: 5,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    function requestArea() {
        $.ajax({
            cache: false,
            type: "GET",
            url: "requestQuery.php",
            success: function(data) {
                obj = jQuery.parseJSON(data);
                count = obj.length;

                icon = {
                    url: "images/Ripple.gif",
                    scaledSize: new google.maps.Size(35, 35),
                    origin: new google.maps.Point(0, 0),
                    anchor: new google.maps.Point(20, 20)
                };

                icon1 = {
                    url: "images/flower.png",
                    scaledSize: new google.maps.Size(75, 75),
                    origin: new google.maps.Point(0, 0),
                    anchor: new google.maps.Point(40, 50)
                };

                icon2 = {
                    url: "images/document.png",
                    scaledSize: new google.maps.Size(75, 75),
                    origin: new google.maps.Point(0, 0),
                    anchor: new google.maps.Point(40, 50)
                };

                icon3 = {
                    url: "images/food.png",
                    scaledSize: new google.maps.Size(75, 75),
                    origin: new google.maps.Point(0, 0),
                    anchor: new google.maps.Point(40, 50)
                };

                icon4 = {
                    url: "images/gift.png",
                    scaledSize: new google.maps.Size(75, 75),
                    origin: new google.maps.Point(0, 0),
                    anchor: new google.maps.Point(40, 50)
                };

                icon5 = {
                    url: "images/grocery.png",
                    scaledSize: new google.maps.Size(75, 75),
                    origin: new google.maps.Point(0, 0),
                    anchor: new google.maps.Point(40, 50)
                };

                icon6 = {
                    url: "images/parcel.png",
                    scaledSize: new google.maps.Size(75, 75),
                    origin: new google.maps.Point(0, 0),
                    anchor: new google.maps.Point(40, 50)
                };

                for (i = 0; i < count; i++) {
                    if (obj[i].status == "CONFIRMED") {
                        if (headID.indexOf(obj[i].request_header_id) == -1) {
                            headID.push(obj[i].request_header_id);
                            
                            if (Notification.permission !== "granted") {
                                Notification.requestPermission();
                            } else {
                                var notification = new Notification('PickApp Request', {
                                    icon: 'images/logo2.png',
                                    body: "Hey there! A request has been made, please open PickApp admin for details!",
                                });

                                notification.onclick = function() {
                                    window.open('http://test.yellox.ph/dashboard.php');
                                };
                            }
                        }

                        var cont = "<div class='success-alert'><div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><strong>Success!</strong> Message Delivered Successfuly!</div></div><div class='success-alert1'><div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><strong>Success!</strong> Request Cancelled!</div></div><p>Vehicle Type: <b class='item'>" + obj[i].type + "</b></p><p>Tiem of Delivery: <b class='item'>" + obj[i].tod + "</b></p><p>Item: <b class='item'>" + obj[i].item + "</b></p><p>Sender Name: <b class='sender_name'>" + obj[i].sender_name + "</b></p><p>Sender Contact: <b class='sender_name'>" + obj[i].sender_contact + "</b></p><p>Recepient Name: <b class='recepient_name'>" + obj[i].recepient_name + "</b></p><p>Recepient Number: <b>"+obj[i].recepient_number+"</b></p><p>Origin Address: <b class='origin_address'>" + obj[i].origin_address + "</b></p><p>Destination Address: <b class='destination_address'>" + obj[i].destination_address + "</b></p><p>Distance: <b class='distance'>" + obj[i].distance + "</b></p><p>Cost: <b class='cost'>" + obj[i].cost + "</b></p><p>Note: <b class='note'>" + obj[i].note + 
                        "</b></p><button class='btn btn-md btn-primary btn-block' id='btn-sendMessage' name=" + obj[i].requested_by + " value=" + obj[i].firstname + ">Send Message</button><button class='btn btn-md btn-success btn-block' id='btn-completeRequest' name=" + obj[i].request_header_id + " value='confirmed'>Complete Request</button><button class='btn btn-md btn-danger btn-block' id='btn-cancelRequest' name=" + obj[i].request_header_id + " value='confirmed'>Cancel Request</button><p class='requested_by' id=" + obj[i].requested_by + "></p><p class='requestID' id=" + obj[i].request_header_id + "></p>";

                        var infowindow = new google.maps.InfoWindow({
                            content: cont
                        });

                        var a = obj[i].origin_lat;
                        var b = obj[i].origin_lng;

                        marker1 = new google.maps.Marker({
                            position: {
                                lat: Number(a),
                                lng: Number(b)
                            },
                            map: map,
                            icon: icon,
                            optimized: false,
                            zIndex: 100
                        });
                        bounds.extend(marker1.position);
                        google.maps.event.addListener(marker1, 'click', (function(marker1, i, cont) {
                            return function() {
                                infowindow.setContent(cont);
                                infowindow.open(map, marker1, cont);
                            }
                        })(marker1, i, cont));

                    } else if (obj[i].status == "ACCEPTED") {
                        drawRoute(r);
                        if (obj[i].at_pickup == 1) {
                            if (obj[i].at_dropoff == 0) {
                                if (headID.indexOf(obj[i].invoice_no) == -1) {
                                    headID.push(obj[i].invoice_no);
                                    var utterance = new SpeechSynthesisUtterance('Hey there, "' + obj[i].fname + '" has arrived at pick up point.');
                                    window.speechSynthesis.speak(utterance);
                                    if (Notification.permission !== "granted") {
                                        Notification.requestPermission();
                                    } else {
                                        var notification = new Notification('Arrived at Pickup point', {
                                            icon: 'images/logo2.png',
                                            body: "Hey there! " + obj[i].fname + " has arrived at pick up point!",
                                        });
                                        notification.onclick = function() {
                                            window.open('http://test.yellox.ph/dashboard.php');
                                        };
                                    }
                                }
                            }
                        }

                        var cont1 = "<div class='success-alert'><div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><strong>Success!</strong> Message Delivered Successfuly!</div></div><div class='success-alert1'><div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><strong>Success!</strong> Request Cancelled!</div></div><p>Vehicle Type: <b class='item'>" + obj[i].type + "</b></p><p>Time of Delivery: <b class='item'>" + obj[i].tod + "</b></p><p>Item: <b class='item'>" + obj[i].item + "</b></p><p>Sender Name: <b class='sender_name'>" + obj[i].sender_name + "</b></p><p>Sender Contact: <b class='sender_name'>" + obj[i].sender_contact + "</b></p><p>Recepient Name: <b class='recepient_name'>" + obj[i].recepient_name + "</b></p><p>Recepient Number: <b>"+obj[i].recepient_number+"</b></p><p>Origin Address: <b class='origin_address'>" + obj[i].origin_address + "</b></p><p>Destination Address: <b class='destination_address'>" + obj[i].destination_address + "</b></p><p>Distance: <b class='distance'>" + obj[i].distance + "</b></p><p>Cost: <b class='cost'>" + obj[i].cost + "</b></p><p>Note: <b class='note'>" + obj[i].note + 
                        "</b></p><button class='btn btn-md btn-success btn-block' id='btn-completeRequest' name=" + obj[i].request_header_id + " value='ongoing'>Complete Request</button><button class='btn btn-md btn-danger btn-block' id='btn-cancelRequest' name=" + obj[i].request_header_id + " value='ongoing' style='margin-top: 0'>Cancel Request</button>";
                        var infowindow1 = new google.maps.InfoWindow({
                            content: cont1
                        });
                        var a = obj[i].destination_lat;
                        var b = obj[i].destination_lng;
                        var a1 = obj[i].origin_lat;
                        var b1 = obj[i].origin_lng;
                        marker1 = new google.maps.Marker({
                            position: {
                                lat: Number(a1),
                                lng: Number(b1)
                            },
                            map: map,
                            icon: icon,
                            optimized: false,
                            zIndex: 100
                        });

                        if (obj[i].package_name == "Flower") {
                            marker = new google.maps.Marker({
                                position: {
                                    lat: Number(a),
                                    lng: Number(b)
                                },
                                map: map,
                                icon: icon1,
                                optimized: false,
                                zIndex: 100
                            });
                        } else if (obj[i].package_name == "Document") {
                            marker = new google.maps.Marker({
                                position: {
                                    lat: Number(a),
                                    lng: Number(b)
                                },
                                map: map,
                                icon: icon2,
                                optimized: false,
                                zIndex: 100
                            });
                        } else if (obj[i].package_name == "Food") {
                            marker = new google.maps.Marker({
                                position: {
                                    lat: Number(a),
                                    lng: Number(b)
                                },
                                map: map,
                                icon: icon3,
                                optimized: false,
                                zIndex: 100
                            });
                        } else if (obj[i].package_name == "Gift") {
                            marker = new google.maps.Marker({
                                position: {
                                    lat: Number(a),
                                    lng: Number(b)
                                },
                                map: map,
                                icon: icon4,
                                optimized: false,
                                zIndex: 100
                            });
                        } else if (obj[i].package_name == "Grocery") {
                            marker = new google.maps.Marker({
                                position: {
                                    lat: Number(a),
                                    lng: Number(b)
                                },
                                map: map,
                                icon: icon5,
                                optimized: false,
                                zIndex: 100
                            });
                        } else if (obj[i].package_name == "Parcel") {
                            marker = new google.maps.Marker({
                                position: {
                                    lat: Number(a),
                                    lng: Number(b)
                                },
                                map: map,
                                icon: icon6,
                                optimized: false,
                                zIndex: 100
                            });
                        }
                        bounds.extend(marker.position);
                        google.maps.event.addListener(marker, 'click', (function(marker, i, cont1) {
                            return function() {
                                infowindow1.setContent(cont1);
                                infowindow1.open(map, marker, cont1);
                            }
                        })(marker, i, cont1));
                    }
                }
                setTimeout("requestArea()",1000);
            },
            error: function() {
                setTimeout("requestArea()",1000);
            }
        });
    }
    requestArea();

    function driverMove() {
        $.ajax({
            cache: false,
            type: "GET",
            url: "driverLastSeen.php",
            success: function(data) {
                if(data){
                    obj = jQuery.parseJSON(data);
                    count = obj.length;

                    for (var d = 0; d < gMarker.length; d++) {
                        gMarker[d].setMap(null);
                    }

                    for (i = 0; i < count; i++) {
                        if(obj[i].is_online == 1){
                            var a = obj[i].location_lat;
                            var b = obj[i].location_long;

                            icon = {
                                url: "http://test.yellox.ph/pickapp_live_ws/pickapp_ws/" + obj[i].avatar + "",
                                scaledSize: new google.maps.Size(35, 35),
                                origin: new google.maps.Point(0, 0),
                                anchor: new google.maps.Point(20, 20)
                            };

                            marker = new google.maps.Marker({
                                position: {
                                    lat: Number(a),
                                    lng: Number(b)
                                },
                                map: map,
                                icon: icon,
                                animation: google.maps.Animation.BOUNCE,
                                optimized: false
                            });

                            var did = obj[i].Driverid;
                            cont ="<h5>Name: </h5><b>"+obj[i].fname+", "+obj[i].lname+"</b>";

                            infowindow = new google.maps.InfoWindow({
                                content: cont
                            });
                        
                            google.maps.event.addListener(marker, 'click', (function(marker, i, cont) {
                            return function() {
                                infowindow.setContent(cont);
                                infowindow.open(map, marker, cont);
                            }
                            })(marker, i, cont));

                            gMarker.push(marker);
                            bounds.extend(marker.position);
                        }
                        else if(obj[i].is_online == 0){
                            gMarker[i].setMap(null);
                        }
                    }
                }
                setTimeout("driverMove()",1000);
            },
            error: function(){
                setTimeout("driverMove()",1000);
            }
        });
    }
    driverMove();

    var r = 0;

    function drawRoute(r){ 
        $.ajax({
            type: "GET",
            url: "requestQuery.php",
            success: function(data){
                obj = jQuery.parseJSON(data);
                count = obj.length;
                if(count == 0){
                }else{
                var origin = [], destination = [];
                for(i=0;i<count;i++){
                    var e = obj[i].origin_lat;
                    var f = obj[i].origin_lng;
                    var e1 = obj[i].destination_lat;
                    var f1 = obj[i].destination_lng;
                    origin[i] = {lat:Number(e),lng:Number(f)};
                    destination[i] = {lat:Number(e1),lng:Number(f1)};
                }
                directionsDisplay[r] = new google.maps.DirectionsRenderer({
                    suppressMarkers: true,
                    preserveViewport: true
                    });
                  directionsService.route({
                  origin: origin[r],
                  destination: destination[r],
                  optimizeWaypoints: true,
                  travelMode: 'DRIVING'
                }, function(response, status) {
                  
                  if (status === 'OK') {
                    directionsDisplay[r].setDirections(response);
                    r++;
                    if(r<count){
                     drawRoute(r); 
                    }
                    
                  } 
                });
                directionsDisplay[r].setMap(map);    
                }
            }
        });
    }
}

function listDriver(){
    $.ajax({
        type: "GET",
        url: "getDrivers.php",
        success: function(data){
            obj = $.parseJSON(data);
            count = obj.length;
            $("#selectDriver").empty();
            for(var i=0;i<count;i++)
            {
                $("#selectDriver").append("<option value="+obj[i].id+">"+obj[i].fname+", "+obj[i].lname+"</option>");
            }
        }
    });
}

$(document).on("click", "#btn-completeRequest", function(){
    listDriver();
    var idCompleted = this.name;
    $("#completeRequest").modal("show");
    $("#requestHeaderId").val(idCompleted);
});

function sendEmail(idCompleted){
    $.ajax({
        type: "POST",
        url: "sendemail.php",
        data: "idCompleted="+idCompleted,
        success: function(data){
            $("#loader").hide();
        }
    });
}

$("#btncompleterequest").on("click", function(){
    $("#loader").show();
    var idCompleted = $("#requestHeaderId").val();
    var selectDriverid = $("#selectDriver").val();
    var receivedby = $("#receivedby").val();
    var passend = "idCompleted="+idCompleted+"&selectDriverid="+selectDriverid+"&receivedby="+receivedby;
    $.ajax({
        type: "POST",
        url: "completeRequest.php",
        data: passend,
        success: function(data){
            sendEmail(idCompleted);
        }
    });
    sendEmail(idCompleted);
});

$(document).on('click', "#btn-cancelRequest", function() {
    var requestID1 = "", adminPass1 = "";
    requestID = $(this).attr("name");
    statusName = $(this).attr("value");
    requestID1 = $(this).attr("name");
    $("#confirmDriver1").modal("show");

    $(document).on('click', "#btn-yes1", function() {
        $("#inputPass").modal("show");
        $("#confirmDriver1").modal("hide");
        $(document).on("click", "#btn-go", function() {
            $("#loader").show();
            adminPass1 = $("#passtype").val();
            data2 = "requestID=" + requestID + "&adminPass1=" + adminPass1 + "&statusName=" + statusName;
            cancelRequest(data2);
        });
    });

    $(document).on('click', "#btn-no1", function() {
        $("#confirmDriver1").modal("hide");
    });
});

$(document).on("click", "#btn-sendMessage", function() {
    $("#confirmDriver2").modal("show");
    var requestorName = $(this).attr("value");
    $("#requestName").empty();
    $("#requestName").append(requestorName);
});

$(document).on('click', "#btn-yes2", function() {
    $("#loader").show();
    var requestorId = $("#btn-sendMessage").attr("name");
    data1 = "requestorId=" + requestorId;
    sendMessage(data1);
    $.stopSound();
});

$(document).on('click', "#btn-no2", function() {
    $("#confirmDriver2").modal("hide");
});

$(document).on("click","#des", function(){
    var parent = $(this);
    var dropoff = parent.closest('div').find('.drop').text();
    var receip = parent.closest('div').find('.receip').text();
    var dropoffloc = dropoff.split(' ').slice(1).join(' ');
    var receiploc = receip.split(' ').slice(1).join(' ');
    $('.confirmrequestdetails').html('<span><b>'+dropoff.split(" ")[0]+'</b> '+dropoffloc+'</span><br><span><b>'+receip.split(" ")[0]+'</b> '+receiploc+'</span>');
    $('#confirmrequestmodal').modal('show');
});

$(document).on("click",".view-details1",function() {
    var IDRequest1 = this.id;
    $('#loader').show();
    var Rname = $(this).attr("name");
    $("#nameOfRequestor").empty();
    $("#nameOfRequestor").append("<span>" + Rname + "'s</span>");
    $.ajax({
        cache: false,
        type: "POST",
        url: "availableDrivers.php",
        data: "IDRequest1=" + IDRequest1,
        success: function(data) {
            $('#loader').hide();
            obj = jQuery.parseJSON(data);
            count = obj.length;
            var rowNumber = 0;
            $("#driversAvailable").empty();
            for (i = 0; i < count; i++) {
                rowNumber++;
                if (obj[i].declinedStatus == 1 && obj[i].declinedBy == "DRIVER") {
                    $("#driversAvailable").append("<tr><td>" + rowNumber + "</td><td>" + obj[i].fname + "</td><td>" + obj[i].lname + "</td><td>Available</td><td><div class='checkGroup'><input type='checkbox' class='idDriver' value=" + obj[i].id + " id=" + obj[i].id + " disabled></div></td></tr>");
                    $(".checkGroup input:checkbox").click(function() {
                        $(".checkGroup input:checkbox").not(this).prop('checked', false);


                    });
                } else if (obj[i].declinedStatus == 1 && obj[i].declinedBy == "SYSTEM") {
                    $("#driversAvailable").append("<tr><td>" + rowNumber + "</td><td>" + obj[i].fname + "</td><td>" + obj[i].lname + "</td><td>Available</td><td><div class='checkGroup'><input type='checkbox' class='idDriver' value=" + obj[i].id + " id=" + obj[i].id + "></div></td></tr>");
                    $(".checkGroup input:checkbox").click(function() {
                        $(".checkGroup input:checkbox").not(this).prop('checked', false);
                    });
                } else {
                    $("#driversAvailable").append("<tr><td>" + rowNumber + "</td><td>" + obj[i].fname + "</td><td>" + obj[i].lname + "</td><td>Available</td><td><div class='checkGroup'><input type='checkbox' class='idDriver' value=" + obj[i].id + " id=" + obj[i].id + "></div></td></tr>");
                    $(".checkGroup input:checkbox").click(function() {
                        $(".checkGroup input:checkbox").not(this).prop('checked', false);


                    });
                }

            }

        }
    });

    $(document).on("click", ".idDriver", function() {
        if ($(this).prop("checked") == true) {

            $("#noChosenDriver").addClass("animated bounceOut").fadeOut().one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {
                $("#noChosenDriver").removeClass("animated bounceOut");
            });
            driverID = $(this).attr("id");
            passIDRequest = IDRequest1;
            assignData = "driverID=" + driverID + "&passIDRequest=" + passIDRequest;
            lkl = 1;
        }
    });
    $("#assignDriver").modal("toggle");
});

var passIDRequest, driverID, lkl;

$(document).on("click", "#btn-assign", function(e) {
    e.preventDefault();
    $("#noChosenDriver").removeClass("animated bounceOut");
    if ($("input.idDriver").is(":checked")) {
        $('#confirmDriver').modal("show");
    } else {
        $("#noChosenDriver").addClass("animated bounceIn").fadeIn().one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {
            $("#noChosenDriver").removeClass("animated bounceIn");
        });
    }

});

$(document).on("click", "#btn-yes", function() {
    if (lkl == 1) {
        $("#loader").show();
        assignThisDriver(assignData);
        $('#confirmDriver').modal("hide");
    }
});

$(document).on("click","#btn-no",function() {
    $('#confirmDriver').modal("hide");
});

$("#pDrivers").click(function(){
window.location.replace("paDrivers.php");
});

$("#pCustomer").click(function(){
window.location.replace("paCustomer.php");
});

$("#actions").click(function(){
    searchFilter = 1;
    $("#logs").modal("show");
    $("#loader").show();
    $.ajax({
        type: "POST",
        url: "logs.php",
        data: "searchFilter="+searchFilter,
        success: function(data){
            $("#loader").hide();
            var rowNu = 0;
            obj = jQuery.parseJSON(data);
            count = obj.length;
            $("#logsData").empty();
            for(i = 0;i <count; i++){
                rowNu++;
                $("#logsData").append("<tr><td>"+rowNu+"</td><td style='text-transform: capitalize'>"+obj[i].fname+"</td><td style='text-transform: capitalize'>"+obj[i].lname+"</td><td>"+obj[i].log_desc+"</td><td>"+obj[i].requestid+"</td><td style='text-transform: capitalize'>"+obj[i].firstname+" "+obj[i].lastname+"</td><td>"+obj[i].dateTime_created+"</td></tr>");
            }
        }
    });
});

var actionlogsslide = true, loadbalanceslide = true;
$("#loadBalance").click(function(){
    if(loadbalanceslide == true){
        $("#loadBalanceList").slideDown();
        $("#angleDown1").removeClass("fa fa-angle-down");
        $("#angleDown1").addClass("fa fa-angle-up");
        loadbalanceslide = false;
    }else{
        $("#loadBalanceList").slideUp();
        $("#angleDown1").removeClass("fa fa-angle-up");
        $("#angleDown1").addClass("fa fa-angle-down");
        loadbalanceslide = true;
    }
});

$("#btn-register, #chatDriver, #btn-logout, #actionlogs, #btn-create").click(function(){
    if(loadbalanceslide == false){
        $("#loadBalanceList").slideUp();
        $("#angleDown1").removeClass("fa fa-angle-up");
        $("#angleDown1").addClass("fa fa-angle-down");
        loadbalanceslide = true;
    }
});

$("#actionlogs").click(function(){
    if(actionlogsslide == true){
        $("#logsList").slideDown();
        $("#angleDown").removeClass("fa fa-angle-down");
        $("#angleDown").addClass("fa fa-angle-up");
        actionlogsslide = false;
    }else{
        $("#logsList").slideUp();
        $("#angleDown").removeClass("fa fa-angle-up");
        $("#angleDown").addClass("fa fa-angle-down");
        actionlogsslide = true;
    }
});

$("#btn-register, #chatDriver, #btn-logout, #loadBalance, #btn-create").click(function(){
    if(actionlogsslide == false){
        $("#logsList").slideUp();
        $("#angleDown").removeClass("fa fa-angle-up");
        $("#angleDown").addClass("fa fa-angle-down");
        actionlogsslide = true;
    }
});

$("#btn-query").on("click", function(){
    searchFilter = 2;
    var start11 = $("#startDate11").val();
    var end11 = $("#endDate11").val();
    if(start11 == "" && end11 == ""){
        alert("Could not search empty date!");
    }else{
    $("#btn-export-to-excel").attr("disabled", false);
    $("#loader").show();
    var queryFilter = "start11="+start11+"&end11="+end11+"&searchFilter="+searchFilter;
    $.ajax({
        type: "POST",
        url: "logs.php",
        data: queryFilter,
        success: function(data){
            $("#loader").hide();
            var rowNu = 0;
            obj = jQuery.parseJSON(data);
            count = obj.length;
            $("#logsData").empty();
            for(i = 0;i <count; i++){
                rowNu++;
                $("#logsData").append("<tr><td>"+rowNu+"</td><td style='text-transform: capitalize'>"+obj[i].fname+"</td><td style='text-transform: capitalize'>"+obj[i].lname+"</td><td>"+obj[i].log_desc+"</td><td>"+obj[i].requestid+"</td><td style='text-transform: capitalize'>"+obj[i].firstname+" "+obj[i].lastname+"</td><td>"+obj[i].dateTime_created+"</td></tr>");
            }
        }
    });
    }

});

$.ajax({
  type: "GET",
  url: "getDrivers.php",
  success: function(data){
    obj = jQuery.parseJSON(data);
    count = obj.length;

    for(i=0;i<count;i++){
      $("#drivers-assign").append("<option value="+obj[i].id+">"+obj[i].fname+", "+obj[i].lname+"</option>");
    }
  }
});


var loadContent = "page=" + 1;
load_data();

$("#chatDriver").on("click", function(){
    var paramId = 1;
    window.location.replace("chat.php?paramId="+paramId);
});

$("#createReport").click(function() {
    $("#fileInput").modal("show");
    var startDate = $("#startDate").val();
    var endDate = $("#endDate").val();
    var driverVal = $("#drivers-assign").val();
    $("#statusCheck").val(action);
    $("#filename1").val(startDate);
    $("#filename2").val(endDate);
    $("#filename3").val(driverVal);
});

function load_data(page) {
    $.ajax({
        cache: false,
        url: "pagination.php",
        method: "POST",
        data: {
            page: page
        },
        success: function(data) {
            $("#pagination-data").html(data);
        }
    });
}

var dataTable = $('#tableID').DataTable({
    'processing': true,
    'serverMethod': 'post',
    'searching': true, 
    'ajax': {
        url: 'filter.php',
        data: function(data){
            var startDate = $('#startDate').val();
            var endDate = $('#endDate').val();
            var driverAssign = $('#drivers-assign').val();
            var status = action;

            data.drr = status;
            data.startDate = startDate;
            data.endDate = endDate;
            data.driverVal = driverAssign;
        }
        },
        'columns': [
        { data: 'lineNo'},
        { data: 'driverAssigned'},
        { data: 'requestedBy'},
        { data: 'itemRequested'},
        { data: 'originAddress'},
        { data: 'destinationAddress'},
        { data: 'distance'},
        { data: 'cost'},
        { data: 'dateRequested'},
        { data: 'dateDelivered'},
        { data: 'timeCompleted'},
        ]
});

function changeDisplayStatus(action){
    var rlstatus = $('.rl-status');
    $('#statusCheck').val(action);
    switch(Number(action)){
        case 1:
            rlstatus.html('(Completed)');
        break;
        case 2:
            rlstatus.html('(Cancelled)');
        break;
        case 3:
            rlstatus.html('(Ongoing)');
        break;
    }
}

var action = 0;
$(document).on('click', '#btn-search', function(){
    action = $(this).attr('value');
    changeDisplayStatus(action);
    dataTable.draw();
    dataTable.ajax.reload();
});

$(document).on('click', '.pagination_link', function() {
    $("#loader").show();
    page = $(this).attr("id");
    loadContent = "page=" + page;
    loadRequestCompleted(loadContent);
});

$(document).on('focus', '.pagination_link', function() {

    $(this).addClass("active");
});

$(document).on('blur', '.pagination_link', function() {
    $(this).removeClass("active");
});

$("#btn-register").click(function() {
    $("#registeredUser").modal("show");
});

var loadRegDrivers = $('#tableID1').DataTable({
        'processing': true,
        'serverMethod': 'post',
        'searching': true, 
        'ajax': {
            url: 'loadRegisteredDrivers.php'
          },
          'columns': [
            { data: 'lineNo'},
            { data: 'fname'},
            { data: 'lname'},
            { data: 'contact_no'},
            { data: 'email_add'},
            { data: 'licenseno'},
            { data: 'dateTime_created'},
            { data: 'google_api_key'}
          ]
});

function updateDriverDetails(driverData) {
    $("#loader").show();
    $.ajax({
        cache: false,
        type: "POST",
        url: "updateDriverDetails.php",
        data: driverData,
        success: function(data) {
            if (data == "updated") {
                $("#loader").hide();
                alert("Updated!");
            }
        }
    });
}

function driverRejected(assignData) {
    $.ajax({
        cache: false,
        type: "POST",
        url: "driverReject.php",
        data: assignData,
        success: function(data) {
            obj = jQuery.parseJSON(data);
            if (obj.isDeclined == 1 && obj.declinedBy == "DRIVER") {
                $("#statusRejectAccept").modal("show");
                $("#driverResponse").empty();
                $("#requestContent").empty();
                $("#driverResponse").append("<span><span class='fa fa-exclamation-triangle'></span> Rejected</span>");
                $("#requestContent").append("<span><b>" + obj.fname + "</b> rejected the request you assigned!</span>");
                $("div#assignContentHeader").css({
                    "background": "#e63939"
                });
                $("#btn-ok").click(function() {
                    $("#statusRejectAccept").modal("hide");
                });
            } else if (obj.isDeclined == 1 && obj.declinedBy == "SYSTEM") {
                $("#statusRejectAccept").modal("show");
                $("#driverResponse").empty();
                $("#requestContent").empty();
                $("#driverResponse").append("<span><span class='fa fa-exclamation-triangle'></span> Rejected</span>");
                $("#requestContent").append("<span><b>The System automatically</b> rejected the request assigned to <span><b>" + obj.fname + "</b></span>, Due to insufficient balance!</span>");
                $("#btn-ok").click(function() {
                    $("#statusRejectAccept").modal("hide");
                });
            } else if (obj.isConfirmed == 1) {
                $("#statusRejectAccept").modal("show");
                $("#driverResponse").empty();
                $("#requestContent").empty();
                $("#driverResponse").append("<span><span class='fa fa-check'></span>Accepted</span>");
                $("#requestContent").append("<span><b>" + obj.fname + "</b> accepted the request you assigned!</span>");
                $("#btn-ok").click(function() {
                    $("#statusRejectAccept").modal("hide");
                    $('#assignDriver').modal("hide");
                });
            } else if (obj.isConfirmed == 0) {
                driverRejected(assignData);
            } else if (obj.isDeclined != 1) {
                driverRejected(assignData);
            }
        }
    });
}

function loadPages(identifierSearch) {
    $.ajax({
        cache: false,
        type: "POST",
        url: "pagination1.php",
        data: identifierSearch,
        success: function(data) {
            $("#pagination-data").html(data);
        }

    });
}

function getOngoingRequest(spanDate) {
    $.ajax({
        cache: false,
        type: "POST",
        url: "filter.php",
        data: spanDate,
        success: function(data) {
            obj = jQuery.parseJSON(data);
            count = obj.length;

            if (count == 0) {
                $("#createReport").attr("disabled", true);
                $("#tableID").css({
                    "height": "415px"
                });
                $("#reqComplete").html("Ongoing Request");
                $("#complete").css({
                    "background": "#0095da"
                }).addClass(animationName1);
                $(".reqHeader").css({
                    "background": "#0095da ",
                    "color": "white",
                    "transition": "0.6s"
                });
                $("#loader").hide();
                $("#tableData").empty();
                $("#tableData").append("<tr><td colspan='11'>No ongoing request.</td></tr>");
            } else {
                $("#createReport").attr("disabled", true);
                $("#tableID").css({
                    "height": "365px"
                });
                $("#startDate, #endDate").css({
                    "border": "1px solid gray"
                });
                $("#reqComplete").html("Ongoing Request");
                $("#complete").css({
                    "background": "#0095da"
                }).addClass(animationName1);
                $(".reqHeader").css({
                    "background": "#0095da ",
                    "color": "white",
                    "transition": "0.6s"
                });
                $("#loader").hide();
                var noCount = 0;
                var color;
                $("#tableData").empty();
                for (i = 0; i < count; i++) {
                    noCount++;

                    $("#tableData").append("<tr><td>" + noCount + "</td><td>" + obj[i].driverAssigned + ", " + obj[i].driverAssigned1 + "</td><td>" + obj[i].requestedBy + ", " + obj[i].requestedBy1 + "</td><td>" + obj[i].itemRequested + "</td><td>" + obj[i].originAddress + "</td><td>" + obj[i].destinationAddress + "</td><td>" + obj[i].distance + "</td><td>" + obj[i].cost + "</td><td>" + obj[i].dateRequested + "</td><td>Unavailable</td><td>Unavailable</td></tr>");
                }
            }
        }
    });
}

$("#startDate, #endDate").datepicker({
    dateFormat: "yy-mm-dd"
});

$("#startDate11, #endDate11").datepicker({
    dateFormat: "yy-mm-dd"
});

$(".hoverArrow").click(function() {
    $("#arrow").removeClass('animated bounce');
});

$(".hoverArrow").mouseleave(function() {
    $("#arrow").addClass('animated bounce');
});

$(".hoverArrow1").click(function() {
    $("#arrow1").removeClass('animated bounce');
});

$(".hoverArrow1").mouseleave(function() {
    $("#arrow1").addClass('animated bounce').css({
        "-webkit-animation-iteration-count": "infinite"
    });
});

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#upload-photo-alt').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}

$("#upload-photo").change(function() {
    readURL(this);
    imgVal = this.value.split('\\').pop();

});

$("#myCarousel, #requestCarousel").carousel({
    interval: false
});

$("#upload-photo-alt").on('click', function(e) {
    e.preventDefault();
    $("#upload-photo:hidden").trigger('click');
});

$("#btn-logout").click(function() {
    alert("thank you!");
    window.location.replace('logout.php');
});

window.onclick = function(event) {
    if (!event.target.matches('.dropbtn')) {
        var dropdowns = document.getElementsByClassName("dropdown-content");
        var i;
        for (i = 0; i < dropdowns.length; i++) {
            var openDropdown = dropdowns[i];
            if (openDropdown.classList.contains('show')) {
                openDropdown.classList.remove('show');
            }
        }
    }
}

function requestDetails() {
    $.ajax({
        cache: false,
        type: "GET",
        url: "requestOrigin.php",
        success: function(data) {
            obj = jQuery.parseJSON(data);
            count = obj.length;
            $("#request-section").empty();
            for (i = 0; i < count; i++) {
                if (obj[i].status == "ACCEPTED") {
                    if (obj[i].at_dropoff == 1) {
                        if (headID1.indexOf(obj[i].id) == -1) {
                            headID1.push(obj[i].id);
                            var utterance = new SpeechSynthesisUtterance('Hey there! "' + obj[i].fname + '" has arrived at drop off point!');
                            window.speechSynthesis.speak(utterance);
                            if (Notification.permission !== "granted") {
                                Notification.requestPermission();
                            } else {
                                var notification = new Notification('Arrived at Dropoff point', {
                                    icon: 'images/logo2.png',
                                    body: "Hey there! " + obj[i].fname + " has arrived at drop off point!",
                                });

                                notification.onclick = function() {
                                    window.open('http://test.yellox.ph/dashboard.php');
                                };

                            }
                        }
                    }
                    stat = "ACCEPTED";
                    $("#request-section").prepend("<div class='request-details' id=" + obj[i].destination_lat + " name=" + obj[i].destination_lng + "><p class='requestor-name' style='text-transform: capitalize;'>" + obj[i].firstname + " " + obj[i].lastname + "</p><p class='view-details' style=' font-size:15px; color: #505050' >Item type: <b>" + obj[i].package_name + "</b></p><div class='exchange-bg' name=" + obj[i].firstname + " id=" + obj[i].id + " value=" + obj[i].driverid + "><span class='fa fa-exchange fa-2x'></span></div></div>");
                }
            }
            $(".exchange-bg").on("click", function() {
                $("#assignDriver1").modal("toggle");
                var radioTransID = '';
                $("input[name='transferDriver']").prop("checked", false);
                var custName = $(this).attr("name");
                var requestHeaderID = $(this).attr("id");
                var currentDriverID = $(this).attr("value");
                $("#nameOfRequestor1").html(custName);
                $.ajax({
                    cache: false,
                    type: "POST",
                    data: "requestHeaderID=" + requestHeaderID + "&currentDriverID=" + currentDriverID,
                    url: "trasnferRequest.php",
                    success: function(data) {
                        obj = jQuery.parseJSON(data);
                        count = obj.length;
                        rowNumber = 0;
                        $("#driversAvailable1").empty();
                        for (i = 0; i < count; i++) {
                            rowNumber++;
                            if (obj[i].driverStatus == "ongoing") {
                                $("#driversAvailable1").append("<tr><td>" + rowNumber + "</td><td>" + obj[i].fname + "</td><td>" + obj[i].lname + "</td><td>Available</td><td><div class='checkGroup'><center><input disabled type='radio' name='transferDriver' class='idDriver1' value=" + obj[i].id + " id=" + obj[i].id + "></center></div></td></tr>");

                                $(".idDriver1").on("click", function() {
                                    alert(obj[i].fname + " is currently the driver of " + custName + ", you cannot transfer this request to itself!");
                                });
                            } else if (obj[i].driverStatus == "available") {
                                $("#driversAvailable1").append("<tr><td>" + rowNumber + "</td><td>" + obj[i].fname + "</td><td>" + obj[i].lname + "</td><td>Available</td><td><div class='checkGroup'><center><input type='radio' name='transferDriver' class='idDriver' value=" + obj[i].id + " id=" + obj[i].id + "></center></div></td></tr>");
                            }
                        }
                        $(".idDriver").on("click", function() {
                            var trans = '';
                            trans = this.id;
                            $("#btn-assign1").on("click", function() {
                                $("#inputPass1").modal("show");
                                $("#btn-go1").on("click", function(){
                                  var passtype = $("#passtype1").val();
                                  radioTransID = $("input[name='transferDriver']:checked").val();
                                  var transData = "requestHeaderID=" + requestHeaderID + "&radioTransID=" + radioTransID + "&currentDriverID=" + currentDriverID + "&passtype="+passtype;
                                  transferThisDriver(transData);  
                                });
                            });
                        });
                    }
                });
            });
            var colcounter = 0;
            for (i = 0; i < count; i++) {
                colcounter++;
                if (obj[i].status == "CONFIRMED") {
                    $.playSound('audio/confirmed_request.mp3');
                    stat = "CONFIRMED";
                    $("#request-section").prepend("<div class='request-details' style='background: #0cca12' id=" + obj[i].origin_lat + " name=" + obj[i].origin_lng + "><p class='requestor-name' style='text-transform: capitalize;'>" + obj[i].firstname + ", " + obj[i].lastname + "</p><hr style='margin: 10px'><center class='row' id='tt' style='margin: 0;'><div class='col-sm-6'><p data-toggle='collapse' style='cursor: pointer' data-target='#destin"+colcounter+"' id='des'>View</p><div style='display: none'><div class='drop'><b>Drop-off:</b> "+obj[i].destination_address+"</div><div class='receip'><b>Recepient: </b>"+obj[i].recepient_name+"</div></div></div><div class='col-sm-6'><p class='view-details1' style='color: #ff6962; font-size:12px; font-family:tahoma; font-weight: bold; cursor: pointer; text-align:left' id=" + obj[i].id + " name=" + obj[i].firstname + " >Assign</p></div></center></div>");
                }
            }
            $(".request-details").click(function() {
                if (stat == "ACCEPTED") {
                    origin_lat = this.id;
                    origin_lng = $(this).attr("name");
                    customerPos = {
                        lat: Number(origin_lat),
                        lng: Number(origin_lng)
                    };
                    var x;
                    var y = 12;
                    map.panTo(customerPos);
                    map.setZoom(18);
                } else if (stat == "CONFIRMED") {
                    triggerOpen = "openME";
                    origin_lat = this.id;
                    origin_lng = $(this).attr("name");
                    customerPos = {
                        lat: Number(origin_lat),
                        lng: Number(origin_lng)
                    };
                    var x;
                    var y = 12;
                    map.panTo(customerPos);
                    map.setZoom(18);
                }
            });
            setTimeout("requestDetails()",1000);
        },
        error: function() {
            setTimeout("requestDetails()",1000);
        }
    });
}
requestDetails();

function transferThisDriver(transData) {
    $("#loader").show();
    $.ajax({
        cache: false,
        type: "GET",
        url: "transferDriver.php",
        data: transData,
        success: function(data) {
            if(data == "save"){
                $("#success-transfer").fadeIn();
                $("#inputPass1").modal("hide");
                $("#loader").hide();
            }else if(data == "error"){
                alert("Wrong password!");
                $("#loader").hide();
            }
            
        }
    });
}

function assignThisDriver(assignData) {
    $.ajax({
        cache: false,
        type: "POST",
        url: "assignThisDriver.php",
        data: assignData,
        success: function(data) {
            $("#loader").hide();
            if (data == "Error") {
                alert("Driver already declined, you cannot force him to do so.");
            } else if (data == "ongoing") {
                $("#statusRejectAccept").modal("show");
                $("#driverResponse").empty();
                $("#requestContent").empty();
                $("#driverResponse").append("<span><span class='fa fa-exclamation-triangle'></span> Error</span>");
                $("#requestContent").append("<span>You already assign this driver to this request, please wait for his response. Thankyou!</span>");
                $("#btn-ok").click(function() {
                    $("#statusRejectAccept").modal("hide");
                });
                driverRejected(assignData);
            } else {
                driverRejected(assignData);
            }
        }
    });
}

function driverStats() {
    $.ajax({
        cache: false,
        type: "GET",
        url: "driversDetails.php",
        success: function(data) {
            obj = jQuery.parseJSON(data);
            count = obj.length;
            var countMsg, holdC;
            $("#drivers-section").empty();
            for (i = 0; i < count; i++) {

                //check
                holdC = Number(obj[i].msgCount);
                if(holdC > 0){
                    countMsg = "<span class='badge' id='msgCount'>"+obj[i].msgCount+"</span>";
                    var paramId = obj[i].id;

                if (headID.indexOf(obj[i].id) == -1) {
                    headID.push(obj[i].id);
                    var utterance = new SpeechSynthesisUtterance('Hey there, "' + obj[i].fname + '", sent a message!');
                    window.speechSynthesis.speak(utterance);
                    if (Notification.permission !== "granted") {
                        Notification.requestPermission();
                    } else {
                        var notification = new Notification('Driver Message', {
                            icon: "http://test.yellox.ph/pickapp_live_ws/pickapp_ws/" + obj[i].avatar + "",
                            body: "Hey there! "+obj[i].fname+", sent a message!",
                        });

                        notification.onclick = function(event) {
                            window.open('http://test.yellox.ph/chat.php?paramId='+paramId);
                        };

                    }
                }
                }else{
                    countMsg = '';
                }
                //end check
                if (obj[i].is_online == 0 && obj[i].is_available == 0) {
                    $("#drivers-section").append("<div class='drivers-details' style='background: white' name='offline' id=" + obj[i].id + "><div class='media'><div class='media-right'><img src='http://test.yellox.ph/pickapp_live_ws/pickapp_ws/" + obj[i].avatar + "' id='driver-image' width='50' height='50'/></div><div class='media-body' style='vertical-align: middle;padding-left: 10px;'><p class='drivers-name'>" + obj[i].fname + "</p><p class='offline'>Driver offline</p></div></div><div style='color: #333; text-align:left; font-size: 12px; margin-top: 5px'>Balance: <b>&#8369; "+Number(obj[i].balance).toFixed(2)+"</b></div></div>"+countMsg+"");
                } else if (obj[i].is_online == 1 && obj[i].is_available == 1) {

                    $("#drivers-section").append("<div class='drivers-details' name='available' style='background: white' id=" + obj[i].id + "><div class='media'><div class='media-right'><img src='http://test.yellox.ph/pickapp_live_ws/pickapp_ws/" + obj[i].avatar + "' id='driver-image' width='50' height='50'/></div><div class='media-body' style='vertical-align: middle;padding-left: 10px;'><p class='drivers-name'>" + obj[i].fname + "</p><p class='available'>Driver Available</p></div></div><div style='color: #333; text-align:left; font-size: 12px; margin-top: 5px'>Balance: <b>&#8369; "+Number(obj[i].balance).toFixed(2)+"</b></div></div>"+countMsg+"");
                } else if (obj[i].is_online == 1 || obj[i].is_available == 0) {

                    $("#drivers-section").append("<div class='drivers-details' name='ongoing' style='background: white;border-left: 5px solid #ffcc00;' id=" + obj[i].id + "><div class='media'><div class='media-right'><img src='http://test.yellox.ph/pickapp_live_ws/pickapp_ws/" + obj[i].avatar + "' id='driver-image' width='50' height='50'/></div><div class='media-body' style='vertical-align: middle;padding-left: 10px;'><p class='drivers-name'>" + obj[i].fname + "</p><p class='ongoing' onclick=\"driverOngoing()\">Ongoing Delivery</p></div></div><div style='color: #333; text-align:left; font-size: 12px; margin-top: 5px'>Balance: <b>&#8369; "+Number(obj[i].balance).toFixed(2)+"</b></div></div>"+countMsg+"");

                }
            }
            $(".drivers-details").on("click", function(){
                var paramId = this.id;
                window.location.replace("chat.php?paramId="+paramId);
            });

            setTimeout("driverStats()",1000);
        },
        error: function() {
            setTimeout("driverStats()",1000);
        }
    });
}

driverStats();

function sendMessage(data1) {
    $.ajax({
        cache: false,
        type: "POST",
        url: "sendErrSms.php",
        data: data1,
        success: function(data) {
            if (data) {
                $("#loader").hide();
                $(".success-alert").fadeIn();
                $("#confirmDriver2").modal("hide");
            }

        }
    });
}

function cancelRequest(data2) {
    $.ajax({
        cache: false,
        type: "POST",
        url: "cancelRequest.php",
        data: data2,
        success: function(data) {
            //alert(data + " " +data2);
            if (data == "error") {
                $("#loader").hide();
                alert("Wrong Password!");
            } else {
                $("#loader").hide();
                $("#inputPass, #confirmDriver1").modal("hide");
                $(".success-alert1").fadeIn();
                setTimeout(function(){
                    location.reload();
                },500);
            }

        }
    });
}
});

$(document).on('click', '#myDropdown', function (e) {
    e.stopPropagation();
  });

function myFunction() {
    document.getElementById("myDropdown").classList.toggle("show");

}