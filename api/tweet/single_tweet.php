<?php

// as it is API using http to access need to prepare headers
header('Access-Control-Allow-Origin:*'); //everyone can have an access n tokens
header('Content-Type: application/json');

include_once '../../configuration/Database.php';
include_once '../../models/Tweet.php';

//connect to DB
$database = new Database();
$db = $database->connect();
//bring Tweet mode and pass DB connection
$tweet = new Tweet($db);

//get ID passed in URL if not passed then die() terminate current script
$tweet->id = isset(htmlspecialchars($_GET['id']))? $_GET['id'] : die();
//$tweet->id = isset($_GET['id'])?$_GET['id']: die();
//call method to execute query
$tweet->single_tweet();
//assign result to php array and after convert result as php array into JSON array
$tweet_arr = array(
    'id'=>$tweet->id,
    'category_id'=>$tweet->category_id,
    'title'=>$tweet->title,
    'body'=>$tweet->body,
    'author'=>$tweet->author,
    'created_at'=>$tweet->created_at,
    'tweet_category_name'=>$tweet->tweet_category_name
);
print_r(json_encode($tweet_arr));






