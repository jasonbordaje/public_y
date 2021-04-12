$(document).ready(function(){

	var username, password;

	$("#btn-login").on("click",function(){
		 username = $("#username").val();
		 password = $("#password").val();
	$.ajax({
		type: "POST",
		url: "login.php",	
		data: "username="+username+"&password="+password,
		success: function(data){
			if(data == 1){
				$("#error-notif").fadeOut();
				window.location.replace("dashboard.php");
				
			}
			else{
				$("#error-notif").fadeIn();
			}
			
		},
		error:function(result){
			alert(result.responseText);
		}
	});


	});

});