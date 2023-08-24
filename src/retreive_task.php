<?php

require 'cors.php';
require "db_con.php";

require "../vendor/autoload.php";
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;
use \Firebase\JWT\ExpiredException;

if($_SERVER['REQUEST_METHOD'] === 'GET'){

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

$sql = "SELECT * FROM  task";

$query = $db_con->query($sql);

if( $query->num_rows > 0){

while( $row = $query->fetch_assoc() ){

    $view_json["id"] = $row["id"];
    $view_json["task_title"] = $row["task_title"];
    $view_json["task_description"] = $row["task_description"];
    $view_json["status"] = $row["status"];
    $view_json["date_created"] = $row["date_created"];
    $tasks[] = $view_json;
}

   echo $response = json_encode(['status'=>'success','code'=>'200','task_list'=>$tasks]);
    return;

}else{

    echo $response = json_encode(['status'=>'error', 'code'=>'404', 'message'=>'No Records Found!']);
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
   echo  $response = json_encode(['status' => false, 'code' => 405,  'message' => 'Invalid Request Type']);
   }

  
 $db_con->close();

?>