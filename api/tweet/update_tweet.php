<?php
//headers
header('Access-Control-Allow-Origin: *');
header('Content-Type:application/json');
header('Access-Control-Allow-Methods:PUT');
header('Access-Control-Allow-Headers:Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,X-Requested-With');

//import files
include_once'../../configuration/Database.php';
include_once'../../models/Tweet.php';

//connect to DB && bring Tweet/instatiate
$database = new Database();
$db = $database->connect();
$tweet = new Tweet($db);
//get user's input using php://input insted of $_POST/$_GET
$data = json_decode(file_get_contents("php://input"));
//print_r($data);
//get id to update specific tweet
$tweet->id = $data->id;
$tweet->title = $data->title;
$tweet->body = $data->body;
$tweet->author = $data->author;
$tweet->category_id = $data->category_id;

//update tweet
if($tweet->update_tweet()){
    echo json_encode(array("Message"=>"Tweet has been updated"));
}else{
    echo json_encode(array("Message"=>"Tweet HAS NOT BEEN updated"));
}


