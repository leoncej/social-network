<?php
  class Comment {
    private $db;

    public function __construct(){
      $this->db = new Database;
    }

    public function getComments($id){
      $this->db->query('SELECT *,
                        comments.id as commentId,
                        users.id as userId,
                        comments.post_id as postId,
                        comments.from_id as fromId,
                        comments.from_name as fromName,
                        comments.comment as comment,
                        comments.created_at as commentCreated
                        FROM comments
                        INNER JOIN users
                        ON comments.from_id = users.id
                        WHERE comments.post_id = :post_id
                        ORDER BY comments.created_at ASC
                        ');

      $this->db->bind(':post_id', $id);
      $results = $this->db->resultSet();
      return $results;
    }

    public function getCommentsByHubId($hubId){
      $this->db->query('SELECT *,
                        comments.id as commentId,
                        users.id as userId,
                        comments.post_id as postId,
                        comments.from_id as fromId,
                        comments.from_name as fromName,
                        comments.comment as comment,
                        comments.created_at as commentCreated
                        FROM comments
                        INNER JOIN users
                        ON comments.from_id = users.id
                        WHERE comments.hub_id = :hub_id
                        ORDER BY comments.created_at ASC
                        ');

      $this->db->bind(':hub_id', $hubId);

      $results = $this->db->resultSet();
      return $results;
    }

    public function getUserPostCommentsByHubId($data){
      $this->db->query('SELECT *,
                        comments.id as commentId,
                        users.id as userId,
                        comments.post_id as postId,
                        comments.from_id as fromId,
                        comments.hub_id as hubId,
                        comments.from_name as fromName,
                        comments.comment as comment,
                        comments.seen as seen,
                        comments.created_at as commentCreated
                        FROM comments
                        INNER JOIN users
                        ON comments.from_id = users.id
                        WHERE comments.post_id = :post_id AND comments.hub_id = :hub_id
                        ORDER BY comments.created_at ASC
                        ');

      $this->db->bind(':post_id', $data['post_id']);
      $this->db->bind(':hub_id', $data['hub_id']);

      $results = $this->db->resultSet();
      return $results;
    }

    public function getUserCommentsByHubId($data){
      $this->db->query('SELECT *,
                        comments.id as commentId,
                        users.id as userId,
                        comments.post_id as postId,
                        comments.from_id as fromId,
                        comments.hub_id as hubId,
                        comments.from_name as fromName,
                        comments.comment as comment,
                        comments.seen as seen,
                        comments.created_at as commentCreated
                        FROM comments
                        INNER JOIN users
                        ON comments.from_id = users.id
                        WHERE comments.from_id = :from_id AND comments.hub_id = :hub_id
                        ORDER BY comments.created_at ASC
                        ');

      $this->db->bind(':from_id', $data['from_id']);
      $this->db->bind(':hub_id', $data['hub_id']);

      $results = $this->db->resultSet();
      return $results;
    }

    public function getUnseenCommentsByHubId($data){
      $this->db->query('SELECT *,
                        comments.id as commentId,
                        users.id as userId,
                        comments.post_id as postId,
                        comments.from_id as fromId,
                        comments.hub_id as hubId,
                        comments.from_name as fromName,
                        comments.comment as comment,
                        comments.seen as seen,
                        comments.created_at as commentCreated
                        FROM comments
                        INNER JOIN users
                        ON comments.from_id = users.id
                        WHERE comments.hub_id = :hub_id AND comments.seen = :seen
                        ORDER BY comments.created_at ASC
                        ');

      $this->db->bind(':hub_id', $data['hub_id']);
      $this->db->bind(':seen', $data['seen']);

      $results = $this->db->resultSet();
      return $results;
    }

    public function getCommentsByUserId($id){
      $this->db->query('SELECT *,
                        comments.id as commentId,
                        users.id as userId,
                        comments.post_id as postId,
                        comments.from_id as fromId,
                        comments.from_name as fromName,
                        comments.comment as comment,
                        comments.created_at as commentCreated
                        FROM comments
                        INNER JOIN users
                        ON comments.from_id = users.id
                        WHERE comments.from_id = :from_id
                        ORDER BY comments.created_at ASC
                        ');

      $this->db->bind(':from_id', $id);

      $results = $this->db->resultSet();
      return $results;
    }

    public function getCommentsByPostId($id){
      $this->db->query('SELECT *,
                        comments.id as commentId,
                        users.id as userId,
                        comments.post_id as postId,
                        comments.from_id as fromId,
                        comments.from_name as fromName,
                        comments.comment as comment,
                        comments.created_at as commentCreated
                        FROM comments
                        INNER JOIN users
                        ON comments.from_id = users.id
                        WHERE comments.post_id = :post_id
                        ORDER BY comments.created_at ASC
                        ');

      $this->db->bind(':post_id', $id);

      $results = $this->db->resultSet();
      return $results;
    }

    public function getAllComments(){
      $this->db->query('SELECT * FROM comments');
      $results = $this->db->resultSet();

      return $results;
    }

    public function addComment($data){
      $this->db->query('INSERT INTO comments (post_id, from_id, from_name, hub_id, comment) VALUES(:post_id, :from_id, :from_name, :hub_id, :comment)');
      // bind values
      $this->db->bind(':post_id', $data['post_id']);
      $this->db->bind(':from_id', $data['from_id']);
      $this->db->bind(':from_name', $data['from_name']);
      $this->db->bind(':hub_id', $data['hub_id']);
      $this->db->bind(':comment', $data['comment']);

      // execute
      if($this->db->execute()){
        $id = $this->db->getLastInsertId();
        return $id;
      } else {
        return false;
      }
    }

    public function updateCommentSeenFlag($data){
      $this->db->query('UPDATE comments SET seen = :seen WHERE id = :id');
      // bind values
      $this->db->bind(':id', $data['id']);
      $this->db->bind(':seen', $data['seen']);

      // execute
      if($this->db->execute()){
        return true;
      } else {
        return false;
      }
    }

    public function deleteComment($id){
      $this->db->query('DELETE FROM comments WHERE id = :id');
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
