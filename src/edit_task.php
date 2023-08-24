<?php

require 'cors.php';
require "db_con.php";

require "../vendor/autoload.php";
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;
use \Firebase\JWT\ExpiredException;

//$data = json_decode(file_get_contents("php://input"));

$id = $_GET['id'];

if($_SERVER['REQUEST_METHOD'] === 'PUT'){

    $header = apache_request_headers();

    if(!isset($header['Authorization'])){
    
      echo $response = json_encode(['status'=>'error', 'code'=>'401', 'message'=>'Access to this end-point denied!']);
      return;
    
    }else{
    
      $header = $header['Authorization'];
    
    try{
    
    $algorithm = "HS256";
     
    $secret_key = "s5ZS5tgjh";
    
    $decode = JWT::decode($header, new Key($secret_key, $algorithm));
    
     $token_expire_time = $decode->exp;
    
     $current_time = time();

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

}catch (ExpiredException $expiredException){

    echo $response = json_encode(['status'=>'error', 'code'=>'401', 'message'=>'Token expired, Please login.']);
      return;
} catch (Exception $e){
  
    echo $response = json_encode(['status'=>'error', 'code'=>'401', 'message'=>'Error decoding or verifying token.']);
      return;
  
  }
  
  }

    }else{
   echo  $response = json_encode(['status' => false, 'code' => 405,  'message' => 'Invalid Request Type']);
   }

    $db_con->close();


?> 