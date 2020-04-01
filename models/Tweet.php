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
        // $query = 'SELECT c.name as category_name, p.id, p.category_id, p.title, p.body, p.author, p.created_at
        // FROM ' . $this->table . ' p
        // LEFT JOIN
        //   category c ON p.category_id = c.id
        // ORDER BY
        //   p.created_at DESC';

    //prepare statement  && execute
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt;
    }
}