<?php
require 'cors.php';
require "db_con.php";

require "../vendor/autoload.php";
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;
use \Firebase\JWT\ExpiredException;

//$data = json_decode(file_get_contents("php://input"));

$id = $_GET['id'];

if($_SERVER['REQUEST_METHOD'] === 'DELETE'){

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

$sql = "DELETE FROM task  WHERE id = '$id'";

$query = $db_con->query($sql);

if($query){

  echo  $response = json_encode(['status'=>'success', 'code' => '200',"message"=>"Deleted Sucessfully"]);

    return;
}else {

  echo  $response = json_encode(['status'=>'error', 'code' => '500', 'message'=> 'Error Occured, Please Try Again!']);

    return;
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

   echo $response = json_encode(['status' => false, 'code' => 405,  'message' => 'Invalid Request Type']);

    return;
}


$db_con->close();

?>