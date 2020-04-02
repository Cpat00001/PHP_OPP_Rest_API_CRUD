<?php

class Tweet{
    //DB elements
    private $conn;
    private $table = "tweets";

    //Tweet props
    public $id;
    public $category_id;
    public $category_name;
    public $title;
    public $body;
    public $author;
    public $created_at;

    //constructor 
    public function __construct($db){
        $this->conn = $db;
    }
    public function read(){
            //prepare query
        $query = "SELECT 
        c.name as tweet_category_name,
        t.id,
        t.category_id,
        t.title,
        t.body,
        t.author,
        t.created_at
        FROM  " . $this->table . "  t
        LEFT JOIN category AS c
        ON t.category_id = c.id
        ORDER BY t.created_at DESC";
        
    //prepare statement  && execute
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt;
    }
    // query to get single_tweet from DB
    public function single_tweet(){
        $query = "SELECT 
        c.name as tweet_category_name,
        t.id,
        t.category_id,
        t.title,
        t.body,
        t.author,
        t.created_at
        FROM  " . $this->table . "  t
        LEFT JOIN category AS c
        ON t.category_id = c.id
        WHERE t.id = ?
        LIMIT 1";
        //prepare,bindParam to ? and execute statement 
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1,$this->id);
        $stmt->execute();
        
        $out = $stmt->fetch(PDO::FETCH_ASSOC);
        //set properties to results you get from $out
        $this->title = $out['title'];
        $this->body = $out['body'];
        $this->author = $out['author'];
        $this->category_id = $out['category_id'];
        $this->tweet_category_name = $out['tweet_category_name'];
    }
}