	//variabhles
	var pickupPointPlace, dropoffPointPlace, place, lat, lng, place1, lat1, lng1, sendersBal;
	var $pickupPoint = $("#pickupPoint");
	var $dropoffPoint = $("#dropoffPoint");	 
	var calcPick, calcDrop, pickUpArea, dropOffArea;
	var directionsService, val, dlValues, getNum, counter = 0, dd, ee;
	var cbbxVal,geocoder;

	//functions
	function initMap(){
	geocoder = new google.maps.Geocoder();
	directionsService = new google.maps.DirectionsService();
	var options = {
	componentRestrictions: {country: 'ph'}
	};

	pickupPointPlace= new google.maps.places.Autocomplete(pickupPoint, options);
	dropoffPointPlace = new google.maps.places.Autocomplete(dropoffPoint, options);
	}

	function calcRoute() {
	var request = {
	    origin: pickUpArea, 
	    destination: dropOffArea, 
	    optimizeWaypoints: true,
	    travelMode: google.maps.DirectionsTravelMode.DRIVING
	};
	directionsService.route(request, function(response, status) {
	  if (status == google.maps.DirectionsStatus.OK) {
	    var route = response.routes[0];
	    var rlegs = route.legs.length;
	    dist = route.legs[0].distance.text;
	    dd = parseFloat(dist);
	    $("#rDistance").html(parseFloat(dist));
	    var pcost = 60 + (parseFloat(dist) * 10);
	    var rembal;
	    if(sendersBal >= pcost){
	    	var dc = pcost * 0.10;
	    	cost = pcost - dc; 
	    	rembal = sendersBal - cost;
	    }else{
	    	cost = pcost;
	    	rembal = sendersBal;
	    }
	    console.log(pcost);
	    $("#remBal").html(parseFloat(rembal));
	    $("#rCost").html(parseFloat(cost));
	    ee = parseFloat(cost);
	  } else {
	    alert("directions response "+status);
	  }
	});
	}


	function getContactNum(getNum){
		$.ajax({
			type: "POST",
			url: "getNum.php",
			data: getNum,
			success: function(data){
				var obj = jQuery.parseJSON(data);
				$("#receiverContact").val(parseInt(obj.mobileno));
			}
		});
	}

	function loadItems(){
		$.ajax({
			type: "GET",
			url: "loadItems.php",
			success: function(data){
				var obj = jQuery.parseJSON(data);
				var count = obj.length;
				for(var i=0;i<count;i++){
				$("#itemList").append("<option id="+obj[i].id+" value='"+obj[i].package_name+"'>");
				}
			}
		});
	}
loadItems();

//document ready for DOM elements
$(document).ready(function(){
var dynamicVal, dynamicID, dynamicItemID;
var mobileNo, tr, idd, lats, lats1, lngs, lngs1;
var interval = 0;

// $("#pickupPoint").on("change", function(){
	var soptions = {
		componentRestrictions: {country: "ph"}
	};
	var searchBox = new google.maps.places.Autocomplete(document.getElementById('pickupPoint'), soptions);
	searchBox.addListener('place_changed', function() {
	var place = searchBox.getPlace();
	lats = place.geometry.location.lat();
	lngs = place.geometry.location.lng();
	$('#pckpupptlat').val(lats);
	$('#pckpupptlng').val(lngs);
	});
// });

// $("#dropoffPoint").on("change", function(){
	var soptions1 = {
		componentRestrictions: {country: "ph"}
	}; 
	var searchBox1 = new google.maps.places.Autocomplete(document.getElementById('dropoffPoint'), soptions1);
	searchBox1.addListener('place_changed', function() {
	var place1 = searchBox1.getPlace();
	lats1 = place1.geometry.location.lat();
	lngs1 = place1.geometry.location.lng();
	$('#drpoffptlat').val(lats1);
	$('#drpoffptlng').val(lngs1);
	});
	// var pickadd = $(this).val();
	// geocoder.geocode( { 'address': pickadd}, function(results, status) {
	//   if (status == google.maps.GeocoderStatus.OK) {
	//     lat1 = results[0].geometry.location.lat();
	//     lng1 = results[0].geometry.location.lng();
	//     // alert(lat1 +" : "+lng1);
	//   } 
	// }); 
// });

$("#btn-submit").click(function(){
 		var empty = $(".textBoxes input[type=text]").filter(function() {
            return this.value === "";
        });
		$('.details').css("display", "block");
        if(empty.length) {
            alert("Please fill up all fields!");
        }else{
			$(".emptyPe").css({"display":"none","transition":"0.5s"});	
			$(".headerCaption").fadeIn("medium");
			$("#btn-confirm").attr("disabled", false);
			$("#btn-confirm").fadeIn("medium");
			var pickUpLat = $('#pckpupptlat').val(), pickUpLng = $('#pckpupptlng').val(), dropOffLat = $('#drpoffptlat').val(), dropOffLng = $('#drpoffptlng').val();
			pickUpArea = $("#pickupPoint").val();
			dropOffArea =  $("#dropoffPoint").val();
			var sendersName = $("#sendersName").val();
			var deliveryTime = $("#deliveryTime").val();
			var senderContact = $("#senderContact").val();
			var receiversName = $("#receiversName").val();
			var receiverContact = parseInt($("#receiverContact").val());
			var itemType = $("#itemType").val();
			var note = $("#Note").val();
			var accountID = dynamicID;
			var sendData = "accountID="+accountID;
			var confirmData = "accountID="+accountID+"&itemType="+itemType+"&sendersName="+sendersName+"&senderContact="+senderContact+"&receiversName="+receiversName+"&receiverContact="+receiverContact+"&pickUpLat="+pickUpLat+"&pickUpLng="+pickUpLng+"&dropOffLat="+dropOffLat+"&dropOffLng="+dropOffLng+"&pickUpArea="+pickUpArea+"&dropOffArea="+dropOffArea+"&note="+note+"&deliveryTime="+deliveryTime;
			calcRoute();

			counter++;
			$("#accordion").prepend("<div class='row bgReq panel'>" +
				"<h4 style='margin: 3% 5%;'>"+receiversName+"<a href='#cols"+counter+"' data-toggle='collapse' data-parent='#accordion'><span class='fa fa-angle-down pull-right' id='ang'></span></a><i class='fa fa-times-circle' id='re'></i></h4>" +
				"<ul class='detailsWrap collapse in' id='cols"+counter+"'>" +
				"<li><p>Time of Delivery: <span class='content' id='rToD'>"+deliveryTime+"</span></p></li>" +
				"<li><p>PickUp Point: <span class='content' id='rPick'>"+pickUpArea+"</span></p></li>" +
				"<li><p>Drop-off Point: <span class='content' id='rDrop'>"+dropOffArea+"</span></p></li>" +
				"<li><p>Sender's Name: <span class='content' id='rSender'>"+sendersName+"</span></p></li>" +
				"<li><p>Contact Number: <span class='content' id='rSContact'>"+senderContact+"</span></p></li>" +
				"<li><p>Receivers Name: <span class='content' id='rReceiver'>"+receiversName+"</span></p></li>" +
				"<li><p>Contact Number: <span class='content' id='rRContact'>"+receiverContact+"</span></p></li>" +
				"<li><p>Item Type: <span class='content' id='rDocument'>"+itemType+"</span></p></li>" +
				"<li><p>Note: <span class='content' id='rNote'>"+note+"</span></p></li>" +
				"<li><p>Distance: <span class='content' id='rDistance'></span></p></li>" +
				"<li style='display:none;'><p>Plat: <span class='content' id='rPlat'>"+pickUpLat+"</span></p></li>" +
				"<li style='display:none;'><p>Plong: <span class='content' id='rPlng'>"+pickUpLng+"</span></p></li>" +
				"<li style='display:none;'><p>Dlat: <span class='content' id='rDlat'>"+dropOffLat+"</span></p></li>" +
				"<li style='display:none;'><p>Dlng: <span class='content' id='rDlng'>"+dropOffLng+"</span></p></li>" +
				"<li><p>Cost: <span class='content' id='rCost'></span></p></li>" +
				"<li style='display: none;'><p>Rembal: <span class='content' id='remBal'></span></p></li>" +
				"</ul>" +
				"</div>");
			$(".btn-wrap").show();

			$(".row.bgReq").on("click", function(){
				var $this = $(this);

				$this.find("ul.detailsWrap").on('shown.bs.collapse', function(){
				$this.find("#ang").addClass("fa-angle-up").removeClass("fa-angle-down");
				});

				$this.find("ul.detailsWrap").on('hidden.bs.collapse', function(){
				$this.find("#ang").addClass("fa-angle-down").removeClass("fa-angle-up");
				});

			});

			$("i.fa.fa-times-circle").on("click", function(){
			var $dets = $(".details");
			var d = $dets.find("div").length - 1;
			if(d == 0){
				$(this).closest("div").remove();
				$(".headerCaption").css({"display":"none"});
				$("#btn-confirm").css({"display":"none"});
				$(".emptyPe").fadeIn("slow");
			}else{
				$(this).closest("div").fadeOut("slow", function(){$(this).closest("div").remove(); });
			}
			});

        }

});

$("#btn-confirm").on("click", function(){
	var $dets = $(".details");
	var d = $dets.find("div").length;
	var pickUpLat = lat, pickUpLng = lng, dropOffLat = lat1, dropOffLng = lng1;
	pickUpArea = $("#pickupPoint").val();
	dropOffArea =  $("#dropoffPoint").val();
	var sendersName = $("#sendersName").val();
	var deliveryTime = $("#deliveryTime").val();
	var senderContact = $("#senderContact").val();
	var receiversName = $("#receiversName").val();
	var receiverContact = parseInt($("#receiverContact").val());
	var itemType = $("#itemType").val();
	var note = $("#Note").val();
	var accountID = $(".corpID").attr("id");
	var sendData = "accountID="+accountID;
	var distance = $("#rDistance").text();

	$.each($(".detailsWrap").get().reverse(),function(){
	var tod = $(this).children().find("span").eq(0).text();
	var pa = $(this).children().find("span").eq(1).text();
	var da = $(this).children().find("span").eq(2).text();
	var sn = $(this).children().find("span").eq(3).text();
	var sc = $(this).children().find("span").eq(4).text();
	var rn = $(this).children().find("span").eq(5).text();
	var rc = $(this).children().find("span").eq(6).text();
	var it = $(this).children().find("span").eq(7).text();
	var n = $(this).children().find("span").eq(8).text();
	var d1 = $(this).children().find("span").eq(9).text();
	var plt = $(this).children().find("span").eq(10).text();
	var plng = $(this).children().find("span").eq(11).text();
	var dlt = $(this).children().find("span").eq(12).text();
	var dlng = $(this).children().find("span").eq(13).text();
	var costs = $(this).children().find("span").eq(14).text();
	var rbal = $(this).children().find("span").eq(15).text();

	var confirmData = "idd="+idd+"&accountID="+accountID+"&itemType="+it+
	"&sendersName="+sn+"&senderContact="+sc+"&receiversName="+rn+
	"&receiverContact="+rc+"&pickUpLat="+plt+"&pickUpLng="+plng+"&dropOffLat="+dlt+
	"&dropOffLng="+dlng+"&pickUpArea="+pa+"&dropOffArea="+da+"&note="+n+"&deliveryTime="+tod+
	"&distance="+d1+"&counter="+counter+"&cost="+costs+"&rbal="+rbal;
		$.ajax({
			type: "POST",
			url: "confirm.php",
			data: confirmData,
			success: function(data){
				alert(data);
				idd = "";
				$(".headerCaption").hide();
				$(".btn-wrap").fadeOut();
				$("#btn-create").fadeIn();
				$(".details").find(".row.bgReq").remove();
				$(".details").css("display", "none");
			}
		});
	});

});

$(function(){
$("#deliveryTime").datetimepicker();
});

$(document).on("change", ".corpID", function(){
	dynamicVal = $(this).val();
	var sendersNumber = $(this).attr("data-mobnum");
	sendersBal = $(this).attr("data-bal");
	$("#sendersName").val(dynamicVal);
	$("#senderContact").val(sendersNumber);
	$("#bal").val(sendersBal);
	$("#accountIdentifier").html(" ("+dynamicVal+")");
	dynamicID = $(this).attr("id");
});

$("#btn-proceed").click(function(){
$("#listOfUsers").modal("hide");
$("#btn-create").focus();
});

$("#btn-cancel").click(function(){
$("input").val("");
});

$("#btn-create").on("click", function(){
var accountID = dynamicID;
var sendData = "accountID="+accountID;

if(accountID == undefined){
// alert("Please choose an account type!");
$("#accountTypes").focus();
}else{
$.ajax({
	type: "POST",
	url: "req.php",
	data: sendData,
	success: function(data){
		idd = data;
		if(cbbxVal == "1"){
		$(".emptyPe").show();
		$("#btn-create").hide();
		$("#deliveryTime").attr("disabled", false);
		$("#pickupPoint").attr("disabled", false);
		$("#dropoffPoint").attr("disabled", false);
		$("#sendersName").attr("disabled", false);
		$("#senderContact").attr("disabled", false);
		$("#receiversName").attr("disabled", false);
		$("#receiverContact").attr("disabled", false);
		$("#itemType").attr("disabled", false);
		$("#Note").attr("disabled", false);
		$("#btn-submit").attr("disabled", false);
		}else{
		$(".emptyPe").show();
		$("#btn-create").hide();
		$("#deliveryTime").attr("disabled", false);
		$("#pickupPoint").attr("disabled", false);
		$("#dropoffPoint").attr("disabled", false);
		$("#sendersName").attr("disabled", false);
		$("#senderContact").attr("disabled", false);
		$("#receiversName").attr("disabled", false);
		$("#receiverContact").attr("disabled", false);
		$("#itemType").attr("disabled", false);
		$("#Note").attr("disabled", false);
		$("#btn-submit").attr("disabled", false);
		}
	}
});
}

});

// $("#combobox").on("change", function(){
// 	cbbxVal =  $(this).val();
// 	if(cbbxVal == "1"){
// 		$(this).hide();
// 		$(".requestInputsWrapper").fadeIn();
// 		$("#listOfUsers").modal("show");
// 		mobileNo = "";

// 		$.ajax({
// 		type: "GET",
// 		url: "getRegAcct.php",
// 		success: function(data){
// 			$("#deliveryTime").attr("disabled", false);
// 			$("#accountName").html("");
// 			$("#accountName").html("Regular Account");
// 			$("#accountTypes").val("Regular Account");
// 			var obj = jQuery.parseJSON(data);
// 			var counts = obj.length;
// 			$("#accountList").empty();
// 			for(var i=0; i<counts; i++){
// 				//mobileNo = obj[i].mobileno;
// 				$("#accountList").append("<tr><td style='display: flex'><input type='radio' style='height: 20px' name='corp' class='corpID' id="+obj[i].id+" data-mobnum = "+obj[i].mobileno+" data-bal = "+obj[i].balance+" value='"+obj[i].firstname+" "+obj[i].mi+" "+obj[i].lastname+"'>"+obj[i].firstname+" "+obj[i].mi+" "+obj[i].lastname+"</td><td><p style='text-align: center'>Regular</p></td></tr>");

// 			}
// 		}
// 	});
// 	}else{
// 		$("#acctName").attr("disabled", true);
// 		$(this).hide();
// 		$(".requestInputsWrapper").fadeIn();
// 		$("#listOfUsers").modal("toggle");
// 		mobileNo = "";
// 		$.ajax({
// 			type: "GET",
// 			url: "getList.php",
// 			success: function(data){
// 				$("#accountName").html("");
// 				$("#accountName").html("Corporate Account");
// 				$("#accountTypes").val("Corporate Account");
// 				var obj = jQuery.parseJSON(data);
// 				var counts = obj.length;
// 				$("#accountList").empty();
// 				for(var i=0; i<counts; i++){
// 					mobileNo = obj[i].mobileno;
// 					$("#accountList").append("<tr><td><input type='radio' name='corp' class='corpID' id="+obj[i].id+" value='"+obj[i].firstname+" "+obj[i].mi+" "+obj[i].lastname+"'>"+obj[i].firstname+" "+obj[i].mi+" "+obj[i].lastname+"</td><td><p style='text-align: center'>Corporate</p></td></tr>");

// 				}
// 			}
// 		});
// 	}
// });


$("#acctName").on("keyup", function(){
var typeName = $(this).val();
$.ajax({
	type: "POST",
	url: "getNames.php",
	data: "typeName="+typeName,
	success: function(data){
		var obj = jQuery.parseJSON(data);
		var counts = obj.length;
		$("#accountList").empty();
		for(var i=0; i<counts; i++){
			$("#accountList").append("<tr><td style='display: flex;' name='bordered'><input type='radio' style='height: 20px;width: 20px;outline: none !important;border: 0 !important;box-shadow: none !important;' name='corp' class='form-control corpID' id="+obj[i].id+" data-mobnum = "+obj[i].mobileno+" data-bal = "+obj[i].balance+" value='"+obj[i].firstname+" "+obj[i].mi+" "+obj[i].lastname+"'><div class='username'>"+obj[i].firstname+" "+obj[i].mi+". "+obj[i].lastname+"</div></td><td><p style='text-align: center'>Regular</p></td></tr>");

		}
	}
});
});

var regularaccounts = $(function(){
$('#listOfUsers').modal('show');
$.ajax({
	type: "GET",
	url: "getRegAcct.php",
	success: function(data){
		$("#deliveryTime").attr("disabled", false);
		var obj = jQuery.parseJSON(data);
		var counts = obj.length;
		$("#accountList").empty();
		for(var i=0; i<counts; i++){
			$("#accountList").append("<tr><td style='display: flex;' name='bordered'><input type='radio' style='height: 20px;width: 20px;outline: none !important;border: 0 !important;box-shadow: none !important;' name='corp' class='form-control corpID' id="+obj[i].id+" data-mobnum = "+obj[i].mobileno+" data-bal = "+obj[i].balance+" value='"+obj[i].firstname+" "+obj[i].mi+" "+obj[i].lastname+"'><div class='username'>"+obj[i].firstname+" "+obj[i].mi+". "+obj[i].lastname+"</div></td><td><p style='text-align: center'>Regular</p></td></tr>");

		}
	}
});
});

});
