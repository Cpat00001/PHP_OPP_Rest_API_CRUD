<?php
//headers
header('Access-Control-Allow-Origin: *');
header('Content-Type:application/json');
header('Access-Control-Allow-Methods:POST');
header('Access-Control-Allow-Headers:Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,X-Requested-With');

include_once'../../configuration/Database.php';
include_once'../../models/Tweet.php';

$database = new Database();
$db = $database->connect();

$tweet = new Tweet($db);

//get data send from POSTMAN/user/JSON encoded string and converts it into a PHP variable
$data = json_decode(file_get_contents("php://input"));
print_r($data);

$tweet->title = $data->title;
$tweet->body = $data->body;
$tweet->author = $data->author;
$tweet->category_id = $data->category_id;

//create tweet
if($tweet->create_tweet()){
    echo json_encode(array("Message"=>"Tweet created"));
}else{
    echo json_encode(array("Message"=>"Tweet NOT created"));
}




