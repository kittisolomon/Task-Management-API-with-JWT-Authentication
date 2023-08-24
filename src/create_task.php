<?php 

require 'cors.php';
require 'db_con.php';

require "../vendor/autoload.php";
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;
use \Firebase\JWT\ExpiredException;

$data = json_decode(file_get_contents("php://input"));

if($_SERVER['REQUEST_METHOD'] === 'POST'){

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

    echo  $response = json_encode(['status' => false, 'code' => 400,  'message' => 'PLease Fill All Required Fields']);

   }else{

   $task_title = filter_var($data->task_title, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

  $task_description = filter_var($data->task_description, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

   $status = 'Not Completed';

  $date_created = date('Y-m-d');

$sql = "INSERT INTO task (task_title,task_description,status,date_created)
        VALUES('$task_title', '$task_description', '$status', '$date_created')";

$query = $db_con->query($sql);

if($query){

   echo $response = json_encode(['status' => true, 'code' => 200, 'message' => 'Task Created Sucessfully']);

}else{

    echo $response = json_encode(['status' => false, 'code' => 500,  'message' => 'Task Not Created']);

}

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