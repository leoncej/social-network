<?php
  class Star {
    private $db;

    public function __construct(){
      $this->db = new Database;
    }

    public function getStarsByPostId($id){
      $this->db->query('SELECT * FROM stars WHERE post_id = :post_id');
      $this->db->bind(':post_id', $id);

      $results = $this->db->resultSet();
      return $results;
    }

    public function getStarByUserAndPostId($data){
      $this->db->query('SELECT * FROM stars WHERE post_id = :post_id AND user_id = :user_id');
      $this->db->bind(':post_id', $data['post_id']);
      $this->db->bind(':user_id', $data['user_id']);

      $row = $this->db->single();
      return $row;
    }

    public function starPost($data){
      $this->db->query('INSERT INTO stars (post_id, user_id, user_name) VALUES(:post_id, :user_id, :user_name)');
      // bind values
      $this->db->bind(':post_id', $data['post_id']);
      $this->db->bind(':user_id', $data['user_id']);
      $this->db->bind(':user_name', $data['user_name']);

      // execute
      if($this->db->execute()){
        return true;
      } else {
        return false;
      }
    }

    public function removeStar($data){
      $this->db->query('DELETE FROM stars WHERE post_id = :post_id AND user_id = :user_id');
      // bind values
      $this->db->bind(':post_id', $data['post_id']);
      $this->db->bind(':user_id', $data['user_id']);

      // execute
      if($this->db->execute()){
        return true;
      } else {
        return false;
      }
    }
  }
?>
