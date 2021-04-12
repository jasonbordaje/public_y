<?php
session_start();


echo "<script>window.location.replace('index.php')</script>";

session_destroy();
?>