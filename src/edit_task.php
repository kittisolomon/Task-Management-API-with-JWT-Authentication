<?php

require 'cors.php';
require "db_con.php";

$data = json_decode(file_get_contents("php://input"));

$id = $_GET['id'];

if($_SERVER['REQUEST_METHOD'] === 'PUT'){

if(empty($data->task_title) && empty($data->task_description)){

	echo $response = json_encode(['status' => 'error','code'=>'400', 'message' => 'Missing Required Fields']); 
    exit;
}

    $task_title = filter_var($data->task_title, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $task_description = filter_var($data->task_description, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $sql = "UPDATE task  SET task_title = '$task_title', task_description= '$task_description' WHERE id = '$id' ";

    $query = $db_con->query($sql);
    
    if($query){

    echo	$response = json_encode(['status'=>'success', 'code' => '200','message'=> 'Task Editted Successfully']);
    exit;

    }else{

    	echo $response = json_encode(['status'=>'error', 'code' => '500', 'message'=> 'Error Occured, Please Try Again!']);
    }

    }else{
   echo  $response = json_encode(['status' => false, 'code' => 405,  'message' => 'Invalid Request Type']);
   }

    $db_con->close();


?> 