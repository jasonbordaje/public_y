<?php
$conn = mysql_connect('localhost', 'yellohot_yellox', '3aFchBj}.0=!');
if (!$conn) { die('Not connected : ' . mysql_error());}
//SELECT
$db = mysql_select_db('yellohot_yelloxdb_test', $conn);
if (!$db) { die ('Can\'t use database : ' . mysql_error());}
error_reporting(E_ALL ^ E_NOTICE);	/*this will turn off all annoying error*/
header('Access-Control-Allow-Origin: *');
?>
