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
        echo $this->category_id;
        $this->tweet_category_name = $out['tweet_category_name'];
    }
    // create a tweet POST Method
    public function create_tweet(){
        $query = "INSERT INTO " . $this->table. "
        SET 
            title = :title,
            body = :body,
            author = :author,
            category_id = :category_id";
        //prepare statement && clean inseted data by user 
        $stmt = $this->conn->prepare($query);

        // clear users' input 
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->body = htmlspecialchars(strip_tags($this->body));
        $this->author = htmlspecialchars(strip_tags($this->author));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));
        //bindParams to SQL query
        $stmt->bindParam(':title',$this->title);
        $stmt->bindParam(':body',$this->body);
        $stmt->bindParam(':author',$this->author);
        $stmt->bindParam(':category_id', $this->category_id);
        echo "rzuc mi kategorie__".print_r($stmt->bindParam(':category_id',$this->category_id));

        if($stmt->execute()){
            return true;
        }
        //print error 
        printf("Error: ", $stmt->error);
        return false;
    }
    //UPDATE existing tweet
    public function update_tweet(){
        $query = "UPDATE " . $this->table. "
        SET 
            title = :title,
            body = :body,
            author = :author,
            category_id = :category_id
            WHERE 
                id = :id";
        //prepare statement && clean inseted data by user 
        $stmt = $this->conn->prepare($query);

        // clear users' input 
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->body = htmlspecialchars(strip_tags($this->body));
        $this->author = htmlspecialchars(strip_tags($this->author));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));
        $this->id = htmlspecialchars(strip_tags($this->id));
        //bindParams to SQL query
        $stmt->bindParam(':title',$this->title);
        $stmt->bindParam(':body',$this->body);
        $stmt->bindParam(':author',$this->author);
        $stmt->bindParam(':category_id', $this->category_id);
        $stmt->bindParam(':id',$this->id);
        echo "rzuc mi kategorie__".print_r($stmt->bindParam(':category_id',$this->category_id));

        if($stmt->execute()){
            return true;
        }
        //print error 
        printf("Error: ", $stmt->error);
        return false;

    }
    // DELETE tweet
    public function delete_tweet(){
        $query = "DELETE FROM " . $this->table . "
                    WHERE id = :id";
        //clean input
        $stmt = $this->conn->prepare($query);
        $this->id = htmlspecialchars(strip_tags($this->id));
        //bind params
        $stmt->bindParam(':id',$this->id);
        //execute query
        if($stmt->execute()){
            return true;
        }
        printf("Error: ", $stmt->error);
        return false;
    }
}