<?php
require "cors.php";
require "db_con.php";
require "../vendor/autoload.php";
use \Firebase\JWT\JWT;
//header('Authorization: Bearer token');

$secret_key = "s54vdbwjs567sdnsdgsjh3746ejhdhsd3874jfnd";

$jwt = null;


$data = json_decode(file_get_contents("php://input"));

$authHeader = $_SERVER['HTTP_AUTHORIZATION'];

$arr = explode(" ", $authHeader);


/*echo json_encode(array(
    "message" => "sd" .$arr[1]
));*/

$jwt = $arr[1];

if($jwt){

    try {

        $decoded = JWT::decode($jwt, $secret_key, $headers = new stdClass());

        // Access is granted. Add code of the operation here 

        echo json_encode(array(
            "message" => "Access granted:",
            "error" => $e->getMessage()
        ));

    }catch (Exception $e){

    http_response_code(401);

    echo json_encode(array(
        "message" => "Access denied.",
        "error" => $e->getMessage()
    ));
}

}
?>