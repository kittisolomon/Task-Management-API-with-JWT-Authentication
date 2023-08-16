<?php 
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'task_mgt';

$db_con =  mysqli_connect($host,$user,$password,$database);


if($db_con){

	//echo 'Database Connected Successfully';
}else{

	die('Cannot Connect to Database');
}




?>