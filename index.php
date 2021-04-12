<?php
session_start();
$id = $_SESSION['id'];
error_reporting(0);

if(!isset($_SESSION['id']) || $_SESSION['id'] == ""){
header("location: ");
}
else{
header("location: dashboard.php");
}
?>
<!DOCTYPE html>
<html>
<title>Login</title>
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
    <script src="js/login.js"></script>
    <!--styles-->
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/login.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="icon" href="favicon.ico">
</head>
<body class="body" style="background: white">
<div class="container" style="height: 100%">
	<div class="login-size">
		<div class="login-size-header">
			<div class="login-size-subheader">
				<div class="login-box">
					<div>
					<img src="images/logo.png" class="img-responsive">
					<hr>
					</div>
					<div class="alert alert-danger" id="error-notif" data-dismiss="alert">
					<strong>Error!</strong> Incorrect Username or Password!
				</div>
				<div class="form-group">
				<h2 class="caption-panel">Login Panel</p></h2>
				</div>
				<div class="form-group">
				<input type="text" class="form-control username" id="username" placeholder="Username">
				</div>
				<div class="form-group">
				<input type="password" class="form-control password" id="password" placeholder="Password">
				</div>
				<div class="form-group">
				<button class="btn btn-primary btn-block login" id="btn-login">Login</button>
				</div>
			</div>
		</div>
	</div>
</div>
</body>
</html>