<?php
  class Activity {
    private $db;

    public function __construct(){
      $this->db = new Database;
    }

    public function getActivitiesByHubId($hubId){
      $this->db->query('SELECT *,
                        activities.id as activityId,
                        activities.hub_id as hubId,
                        activities.user_id as userId,
                        activities.user as user,
                        activities.type as type,
                        activities.created_at as activityCreated
                        FROM activities
                        WHERE activities.hub_id = :hub_id
                        ORDER BY activities.created_at DESC
                        ');

      $this->db->bind(':hub_id', $hubId);

      $results = $this->db->resultSet();
      return $results;
    }

    public function getActivitiesByPostId($postId){
      $this->db->query('SELECT *,
                        activities.id as activityId,
                        activities.hub_id as hubId,
                        activities.post_id as postId,
                        activities.user_id as userId,
                        activities.user as user,
                        activities.type as type,
                        activities.created_at as activityCreated
                        FROM activities
                        WHERE activities.post_id = :post_id
                        ORDER BY activities.created_at DESC
                        ');

      $this->db->bind(':post_id', $postId);

      $results = $this->db->resultSet();
      return $results;
    }

    public function getActivitiesByCommentId($commentId){
      $this->db->query('SELECT *,
                        activities.id as activityId,
                        activities.hub_id as hubId,
                        activities.post_id as postId,
                        activities.comment_id as commentId,
                        activities.user_id as userId,
                        activities.user as user,
                        activities.type as type,
                        activities.created_at as activityCreated
                        FROM activities
                        WHERE activities.comment_id = :comment_id
                        ORDER BY activities.created_at DESC
                        ');

      $this->db->bind(':comment_id', $commentId);

      $results = $this->db->resultSet();
      return $results;
    }

    public function getActivitiesByToId($data){
      $this->db->query('SELECT *,
                        activities.id as activityId,
                        activities.hub_id as hubId,
                        activities.post_id as postId,
                        activities.user_id as userId,
                        activities.user as user,
                        activities.type as type,
                        activities.to_id as toId,
                        activities.seen as seen,
                        activities.created_at as activityCreated
                        FROM activities
                        WHERE activities.to_id = :to_id AND activities.seen = :seen
                        ORDER BY activities.created_at DESC
                        ');

      $this->db->bind(':to_id', $data['to_id']);
      $this->db->bind(':seen', $data['seen']);

      $results = $this->db->resultSet();
      return $results;
    }

    public function getActivitiesByNotifyUser($data){
      $this->db->query('SELECT *,
                        activities.id as activityId,
                        activities.hub_id as hubId,
                        activities.post_id as postId,
                        activities.user_id as userId,
                        activities.user as user,
                        activities.type as type,
                        activities.to_id as toId,
                        activities.seen as seen,
                        activities.notify_user as notifyUser,
                        activities.created_new_hub as createdNewHub,
                        activities.created_at as activityCreated
                        FROM activities
                        WHERE activities.notify_user = :notify_user AND activities.seen = :seen
                        ORDER BY activities.created_at DESC
                        ');

      $this->db->bind(':notify_user', $data['notify_user']);
      $this->db->bind(':seen', $data['seen']);

      $results = $this->db->resultSet();
      return $results;
    }

    public function addActivity($data){
      $this->db->query('INSERT INTO activities (hub_id, hub, user_id, user, type, to_id, post_id, comment_id, remover_id, remover_name, notify_user) VALUES(:hub_id, :hub, :user_id, :user, :type, :to_id, :post_id, :comment_id, :remover_id, :remover_name, :notify_user)');
      // bind values
      $this->db->bind(':hub_id', $data['hub_id']);
      $this->db->bind(':hub', $data['hub']);
      $this->db->bind(':user_id', $data['user_id']);
      $this->db->bind(':user', $data['user']);
      $this->db->bind(':type', $data['type']);
      $this->db->bind(':to_id', $data['to_id']);
      $this->db->bind(':post_id', $data['post_id']);
      $this->db->bind(':comment_id', $data['comment_id']);
      $this->db->bind(':remover_name', $data['remover_name']);
      $this->db->bind(':remover_id', $data['remover_id']);
      $this->db->bind(':notify_user', $data['notify_user']);

      // execute
      if($this->db->execute()){
        return true;
      } else {
        return false;
      }
    }

    public function addRemoverActivity($data){
      $this->db->query('INSERT INTO activities (hub_id, hub, user_id, user, to_id, type, remover_id, remover_name, notify_user, created_new_hub, post_id, comment_id) VALUES(:hub_id, :hub, :user_id, :user, :to_id, :type, :remover_id, :remover_name, :notify_user, :created_new_hub, :post_id, :comment_id)');
      // bind values
      $this->db->bind(':hub_id', $data['hub_id']);
      $this->db->bind(':hub', $data['hub']);
      $this->db->bind(':user_id', $data['user_id']);
      $this->db->bind(':user', $data['user']);
      $this->db->bind(':to_id', $data['to_id']);
      $this->db->bind(':type', $data['type']);
      $this->db->bind(':remover_id', $data['remover_id']);
      $this->db->bind(':remover_name', $data['remover_name']);
      $this->db->bind(':notify_user', $data['notify_user']);
      $this->db->bind(':created_new_hub', $data['created_new_hub']);
      $this->db->bind(':post_id', $data['post_id']);
      $this->db->bind(':comment_id', $data['comment_id']);

      // execute
      if($this->db->execute()){
        return true;
      } else {
        return false;
      }
    }

    public function addPostActivity($data){
      $this->db->query('INSERT INTO activities (hub_id, hub, user_id, user, to_id, type, post_id, comment_id, remover_id, remover_name, notify_user) VALUES(:hub_id, :hub, :user_id, :user, :to_id, :type, :post_id, :comment_id, :remover_id, :remover_name, :notify_user)');
      // bind values
      $this->db->bind(':hub_id', $data['hub_id']);
      $this->db->bind(':hub', $data['hub']);
      $this->db->bind(':user_id', $data['user_id']);
      $this->db->bind(':user', $data['user']);
      $this->db->bind(':to_id', $data['to_id']);
      $this->db->bind(':type', $data['type']);
      $this->db->bind(':post_id', $data['post_id']);
      $this->db->bind(':comment_id', $data['comment_id']);
      $this->db->bind(':remover_id', $data['remover_id']);
      $this->db->bind(':remover_name', $data['remover_name']);
      $this->db->bind(':notify_user', $data['notify_user']);

      // execute
      if($this->db->execute()){
        return true;
      } else {
        return false;
      }
    }

    public function addCommentActivity($data){
      $this->db->query('INSERT INTO activities (hub_id, hub, user_id, user, to_id, post_id, type, comment_id, remover_id, remover_name, notify_user) VALUES(:hub_id, :hub, :user_id, :user, :to_id, :post_id, :type, :comment_id, :remover_id, :remover_name, :notify_user)');
      // bind values
      $this->db->bind(':hub_id', $data['hub_id']);
      $this->db->bind(':hub', $data['hub']);
      $this->db->bind(':user_id', $data['user_id']);
      $this->db->bind(':user', $data['user']);
      $this->db->bind(':to_id', $data['to_id']);
      $this->db->bind(':post_id', $data['post_id']);
      $this->db->bind(':type', $data['type']);
      $this->db->bind(':comment_id', $data['comment_id']);
      $this->db->bind(':remover_id', $data['remover_id']);
      $this->db->bind(':remover_name', $data['remover_name']);
      $this->db->bind(':notify_user', $data['notify_user']);

      // execute
      if($this->db->execute()){
        return true;
      } else {
        return false;
      }
    }

    public function updatePostActivitySeenFlag($data){
      $this->db->query('UPDATE activities SET seen = :seen WHERE id = :id');
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

    public function deleteActivity($id){
      $this->db->query('DELETE FROM activities WHERE id = :id');
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
