<?php

require 'cors.php';
require "db_con.php";

if($_SERVER['REQUEST_METHOD'] === 'GET'){

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

    $response = ['status'=>'error', 'code'=>'404', 'message'=>'No Records Found!'];
    echo json_encode($response);
    return;
}

 }else{
   echo  $response = json_encode(['status' => false, 'code' => 405,  'message' => 'Invalid Request Type']);
   }
 '$db_con->close();'

?>