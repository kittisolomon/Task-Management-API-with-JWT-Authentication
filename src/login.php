<?php
require "cors.php";
require "db_con.php";
require "../vendor/autoload.php";
use \Firebase\JWT\JWT;

$data = json_decode(file_get_contents("php://input"));

if($_SERVER["REQUEST_METHOD"] === "POST"){

 if(empty($data->email) && empty($data->password)){

    echo  $response = json_encode(['status' => false, 'code' => 400,  'message' => 'PLease Fill All Required Fields']);

 }else{

    $email =  filter_var($data->email, FILTER_SANITIZE_EMAIL);
    $password = filter_var($data->password, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $sql = "SELECT  id, email, password FROM users WHERE email = '$email'";

    $query = $db_con->query($sql);

    if($query->num_rows > 0 ){

    $row = $query->fetch_assoc();

    $user_id = $row["id"];

    $user_email = $row['email'];

    $user_password = $row['password'];

    if(password_verify($password, $user_password) && $email === $user_email ){

        $algorithm = "HS256";
        $secret_key = "s54vdbwjs567sdnsdgsjh3746ejhdhsd3874jfnd44dhdgellkgi5l";
        $issuer_claim = "http://localhost/";
        $issuedat_claim = time();
        $notbefore_claim = $issuedat_claim + 10;
        $expire_claim = $issuedat_claim + 180;

        $token = [
            "iss" => $issuer_claim,
            "iat" => $issuedat_claim,
            "nbf" => $notbefore_claim,
            "exp" => $expire_claim,
            "data" => [
                "id" => $user_id,
                "email" => $user_email

            ]

        ];

        $jwt = JWT::encode($token, $secret_key, $algorithm);

      echo  $response = json_encode(["status" => true, "code" => 200, "message" => "Login Successful", "jwt" => $jwt]);

    }else{
        echo  $response = json_encode(['status' => false, 'code' => 401,  'message' => 'Invalid User Credentials']);
       }

   }

}

}else{
    echo  $response = json_encode(['status' => false, 'code' => 405,  'message' => 'Invalid Request Type']);
}

?>