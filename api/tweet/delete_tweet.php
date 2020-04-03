<?php
//headers
header('Access-Control-Allow-Origin:*');
header('Content-Type:application/json');
header('Access-Control-Allow-Methods:DELETE');

//bring filed DB and Tweet
include_once'../../configuration/Database.php';
include_once'../../models/Tweet.php';


//connect DB and pass parameter to Tweet instantiation
$database = new Database();
$db = $database->connect();
$tweet = new Tweet($db);

//get data from user's input
$data = json_decode(file_get_contents('php://input'));
//get id
$tweet->id = $data->id;

//throw a message if tweet_deleted() has been/NOT executed
if($tweet->delete_tweet()){
    echo json_encode(array("Message"=>"Tweet has been deleted"));
}else{
    echo json_encode(array("Message"=>"Tweet has NOT BEEN deleted"));
}
