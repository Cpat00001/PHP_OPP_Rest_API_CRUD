<?php

// as it is API using http to access need to prepare headers
header('Access-Control-Allow-Origin:*'); //everyone can have an access n tokens
header('Content-Type: application/json');

//bring files
include_once'../../configuration/Database.php';
include_once'../../models/Tweet.php';

//DB instantiation + connect
$database = new Database();
$db = $database->connect();
//Tweet instatation
$tweet = new Tweet($db);
//call Tweet query to execute and get all tweets using read()
$result = $tweet->read();
//print_r($result);
//get a number of rows, then check if more than 0
$number = $result->rowCount();
if($number > 0){
    //create array with results then convert to JSON Array
    $tweet_arr = array();
    $tweet_arr['data'] = array();
    //loop throught the result and fetch associative array
    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
        //explode($row); / ta funkcja byla bledna - powodowala zamet - rozbija string 
        extract($row);

        $tweet_item = array(
            'id'=>$row['id'],
            'title'=>$row['title'],
            'body'=>html_entity_decode($row['body']),
            'author'=>$row['author'],
            'category_id'=>$row['category_id'],
            'tweet_category_name'=>$row['tweet_category_name']
        );
        //Push tweet_item into tweet_arr array
        array_push($tweet_arr['data'],$tweet_item);
    }
    //change php array into JSON format
    echo json_encode($tweet_arr);
}else{
        // if not tweets display message
        echo json_encode(array("Message"=>"Not tweets found"));
}


$str = 'one|two|three|four';

// positive limit
print_r(explode('|', $str, 2));




