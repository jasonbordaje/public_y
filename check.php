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
    <!--styles-->
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/error.css">
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
	<title>Error</title>

</head>
<body>
<style>
center.error-login {
    -webkit-box-shadow: 1px 4px 27px -5px rgba(0,0,0,1);
    -moz-box-shadow: 1px 4px 27px -5px rgba(0,0,0,1);
    box-shadow: 1px 4px 27px -5px rgba(0,0,0,1);
    top: 50%;
    left: 50%;
    width: 40em;
    height: 30em;
    margin-top: -15em;
    margin-left: -20em;
    border: 1px solid: white;
    background-color: white;
    position: fixed;
}

button#btn-login {
    width: 50%;
}

img {
    margin-bottom: -55px;
}

</style>
<center class="error-login">
<div class="wrapper">
<img src="images/error.jpg" width="300">
<h1>You're not login</h1>
<button class="btn btn-primary btn-lg" id="btn-login">Login</button>
</div>
</center>
<script>
	$("#btn-login").click(function(){
		window.location.replace("index.php");
	});
</script>
</body>
</html>