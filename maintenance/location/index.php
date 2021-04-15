<?php
session_start();
$id = $_SESSION['id'];
error_reporting(0);
$successSession = $_SESSION["success"];
$errorSession = $_SESSION["error"];
include('../../includes/global.php');

?>
<!DOCTYPE html>
<html>
<head>
	<link href="<?php echo $url_home ?>/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo $url_home ?>/css/admin.css">
    <link rel="stylesheet" href="<?php echo $url_home ?>/css/animate.min.css">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo $url_home ?>/favicon.ico">
    <link href="//cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
    

    <link href="//cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
    <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap.min.css">
    <script src="js/admin.js"></script>
</head>

<body>
	<?php include('../../layout/header.php') ?>
	<div class="container">

		<div class=>
			
		</div>
		<h3>kdkdk</h3>
	</div>
</body>
</html>