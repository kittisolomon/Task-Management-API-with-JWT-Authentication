<?php
require "db_con.php";

$data = json_decode(file_get_contents("php://input"));

$id = $_GET['id'];

if($_SERVER['REQUEST_METHOD'] === 'DELETE'){

$sql = " DELETE FROM task  WHERE id = '$id' ";

$query = $db_con->query($sql);

if($query){

  echo  $response = json_encode(['status'=>'success', 'code' => '200',"message"=>"Deleted Sucessfully"]);

    return;
}else {

  echo  $response = json_encode(['status'=>'error', 'code' => '500', 'message'=> 'Error Occured, Please Try Again!']);

    return;
}


}else{

   echo $response = json_encode(['status' => false, 'code' => 405,  'message' => 'Invalid Request Type']);

    return;
}


$db_con->close();

?>