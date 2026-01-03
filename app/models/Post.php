<?php
  class Post {
    private $db;

    public function __construct(){
      $this->db = new Database;
    }

    public function getPostsByHubId($hubId){
      $this->db->query('SELECT *,
                        posts.id as postId,
                        users.id as userId,
                        posts.created_at as postCreated,
                        users.created_at as userCreated,
                        posts.img as postImg,
                        posts.stars as postStars
                        FROM posts
                        INNER JOIN users
                        ON posts.user_id = users.id
                        WHERE posts.hub_id = :hub_id
                        ORDER BY posts.created_at DESC
                        ');

      $this->db->bind(':hub_id', $hubId);

      $results = $this->db->resultSet();
      return $results;
    }

    public function getUserPostsByHubId($data){
      $this->db->query('SELECT *,
                        posts.id as postId,
                        users.id as userId,
                        posts.user_id as userId,
                        posts.created_at as postCreated,
                        users.created_at as userCreated
                        FROM posts
                        INNER JOIN users
                        ON posts.user_id = users.id
                        WHERE posts.hub_id = :hub_id AND posts.user_id = :user_id
                        ORDER BY posts.created_at DESC
                        ');

      $this->db->bind(':hub_id', $data['hub_id']);
      $this->db->bind(':user_id', $data['user_id']);

      $results = $this->db->resultSet();
      return $results;
    }

    public function getPosts(){
      $this->db->query('SELECT *,
                        posts.id as postId,
                        users.id as userId,
                        posts.created_at as postCreated,
                        users.created_at as userCreated
                        FROM posts
                        INNER JOIN users
                        ON posts.user_id = users.id
                        ORDER BY posts.created_at DESC
                        ');

      $results = $this->db->resultSet();
      return $results;
    }

    public function addPost($data){
      $this->db->query('INSERT INTO posts (title, body, img, user_id, user_colour, edited, hub_id) VALUES(:title, :body, :img, :user_id, :user_colour, :edited, :hub_id)');
      // bind values
      $this->db->bind(':title', $data['title']);
      $this->db->bind(':body', $data['body']);
      $this->db->bind(':img', $data['img']);
      $this->db->bind(':user_id', $data['user_id']);
      $this->db->bind(':user_colour', $data['user_colour']);
      $this->db->bind(':edited', $data['edited']);
      $this->db->bind(':hub_id', $data['hub_id']);

      // execute
      if($this->db->execute()){
        $id = $this->db->getLastInsertId();
        return $id;
      } else {
        return false;
      }
    }

    public function addPostBackup($data){
      $this->db->query('INSERT INTO posts (title, img, user_id, body, hub_id) VALUES(:title, :img, :user_id, :body, :hub_id)');
      // bind values
      $this->db->bind(':title', $data['title']);
      $this->db->bind(':img', $data['img']);
      $this->db->bind(':user_id', $data['user_id']);
      $this->db->bind(':body', $data['body']);
      $this->db->bind(':hub_id', $data['hub_id']);

      // execute
      if($this->db->execute()){
        $id = $this->db->getLastInsertId();
        return $id;
      } else {
        return false;
      }
    }

    public function updatePost($data){
      $this->db->query('UPDATE posts SET title = :title, img = :img, edited = :edited WHERE id = :id');
      // bind values
      $this->db->bind(':id', $data['id']);
      $this->db->bind(':title', $data['title']);
      $this->db->bind(':img', $data['img']);
      $this->db->bind(':edited', $data['edited']);

      // execute
      if($this->db->execute()){
        return true;
      } else {
        return false;
      }
    }

    public function updatePostStars($data){
      $this->db->query('UPDATE posts SET stars = :stars WHERE id = :id');
      // bind values
      $this->db->bind(':id', $data['id']);
      $this->db->bind(':stars', $data['stars']);

      // execute
      if($this->db->execute()){
        return true;
      } else {
        return false;
      }
    }

    public function getPostById($id){
      $this->db->query('SELECT * FROM posts WHERE id = :id');
      $this->db->bind(':id', $id);

      $row = $this->db->single();
      return $row;
    }

    public function getPostsByUserId($id){
      $this->db->query('SELECT *,
                        posts.id as postId,
                        users.id as userId,
                        posts.hub_id as hubId,
                        posts.created_at as postCreated,
                        users.created_at as userCreated
                        FROM posts
                        INNER JOIN users
                        ON posts.user_id = users.id
                        WHERE posts.user_id = :user_id
                        ORDER BY posts.created_at DESC
                        ');

      $this->db->bind(':user_id', $id);

      $results = $this->db->resultSet();
      return $results;
    }

    public function deletePost($id){
      $this->db->query('DELETE FROM posts WHERE id = :id');
      // bind values
      $this->db->bind(':id', $id);

      // execute
      if($this->db->execute()){
        return true;
      } else {
        return false;
      }
    }
  }
?>
