<?php 

require 'cors.php';
require 'db_con.php';

$data = json_decode(file_get_contents("php://input"));

if($_SERVER['REQUEST_METHOD'] === 'POST'){

if(empty($data->firstname)  && empty($data->lastname) && empty($data->email) && empty($data->password) ){
    echo  $response = json_encode(['status' => false, 'code' => 400,  'message' => 'PLease Fill All Required Fields']);
}else{

$firstname = filter_var($data->firstname, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
 $lastname = filter_var($data->lastname, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$email =  filter_var($data->email, FILTER_SANITIZE_EMAIL);
$password = filter_var($data->password, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$date_created = date('Y-m-d');

$password_hash = password_hash($password, PASSWORD_BCRYPT);

$sql = "INSERT INTO users (firstname, lastname, email, password, date_created)
        VALUES('$firstname', '$lastname', '$email','$password_hash', '$date_created')";

$query = $db_con->query($sql);

if($query){
   echo $response = json_encode(['status' => true, 'code' => 200, 'message' => 'Signup Sucessful']);
}else{
    echo $response = json_encode(['status' => false, 'code' => 500,  'message' => 'Error Ocurred, Please Try Again!']);
}

}

}else{
   echo  $response = json_encode(['status' => false, 'code' => 405,  'message' => 'Invalid Request Type']);
}

$db_con->close();


?>