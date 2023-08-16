<?php 

require 'cors.php';
require 'db_con.php';

$data = json_decode(file_get_contents("php://input"));

if($_SERVER['REQUEST_METHOD'] === 'POST'){

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

}else{
   echo  $response = json_encode(['status' => false, 'code' => 405,  'message' => 'Invalid Request Type']);
}

$db_con->close();


?>