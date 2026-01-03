<?php
  class Message {
    private $db;

    public function __construct(){
      $this->db = new Database;
    }

    public function getMessages($data){
      $this->db->query('SELECT *,
                        messages.id as messageId,
                        users.id as userId,
                        messages.to_id as toId,
                        messages.to_name as toName,
                        messages.from_id as fromId,
                        messages.from_name as fromName,
                        messages.chat_id as chatId,
                        messages.message as message,
                        messages.img as img,
                        messages.hub_id as messageHubId,
                        messages.created_at as messageCreated
                        FROM messages
                        INNER JOIN users
                        ON messages.from_id = users.id
                        WHERE (messages.from_id = :user_id OR messages.to_id = :user_id) AND messages.hub_id = :hub_id
                        ORDER BY messages.created_at ASC
                        ');

      $this->db->bind(':user_id', $data['id']);
      $this->db->bind(':hub_id', $data['hub_id']);

      $results = $this->db->resultSet();
      return $results;
    }

    public function getAllUserMessages($id){
      $this->db->query('SELECT *,
                        messages.id as messageId,
                        users.id as userId,
                        messages.to_id as toId,
                        messages.to_name as toName,
                        messages.from_id as fromId,
                        messages.from_name as fromName,
                        messages.chat_id as chatId,
                        messages.message as message,
                        messages.img as img,
                        messages.hub_id as messageHubId,
                        messages.created_at as messageCreated
                        FROM messages
                        INNER JOIN users
                        ON messages.from_id = users.id
                        WHERE messages.from_id = :user_id OR messages.to_id = :user_id
                        ORDER BY messages.created_at ASC
                        ');

      $this->db->bind(':user_id', $id);

      $results = $this->db->resultSet();
      return $results;
    }

    public function getAllUnseenUserMessages($data){
      $this->db->query('SELECT *,
                        messages.id as messageId,
                        users.id as userId,
                        messages.to_id as toId,
                        messages.to_name as toName,
                        messages.from_id as fromId,
                        messages.from_name as fromName,
                        messages.chat_id as chatId,
                        messages.message as message,
                        messages.img as img,
                        messages.seen as seen,
                        messages.hub_id as messageHubId,
                        messages.created_at as messageCreated
                        FROM messages
                        INNER JOIN users
                        ON messages.from_id = users.id
                        WHERE (messages.from_id = :user_id OR messages.to_id = :user_id) AND messages.seen = :seen AND messages.hub_id = :hub_id
                        ORDER BY messages.created_at ASC
                        ');

      $this->db->bind(':user_id', $data['id']);
      $this->db->bind(':seen', $data['seen']);
      $this->db->bind(':hub_id', $data['hub_id']);

      $results = $this->db->resultSet();
      return $results;
    }

    public function getMessageChain($data){
      $this->db->query('SELECT *,
                        messages.id as messageId,
                        users.id as userId,
                        messages.to_id as toId,
                        messages.to_name as toName,
                        messages.from_id as fromId,
                        messages.from_name as fromName,
                        messages.chat_id as chatId,
                        messages.message as message,
                        messages.seen_at as messageSeen,
                        messages.img as img,
                        messages.hub_id as messageHubId,
                        messages.created_at as messageCreated
                        FROM messages
                        INNER JOIN users
                        ON messages.from_id = users.id
                        WHERE messages.chat_id = :chat_id AND messages.hub_id = :hub_id
                        ORDER BY messages.created_at ASC
                        ');

      $this->db->bind(':chat_id', $data['chat_id']);
      $this->db->bind(':hub_id', $data['hub_id']);

      $results = $this->db->resultSet();
      return $results;
    }

    public function updateMessageSeenFlag($data){
      $this->db->query('UPDATE messages SET seen = :seen, seen_at = :seen_at WHERE id = :id');
      // bind values
      $this->db->bind(':id', $data['id']);
      $this->db->bind(':seen', $data['seen']);
      $this->db->bind(':seen_at', $data['seen_at']);

      // execute
      if($this->db->execute()){
        return true;
      } else {
        return false;
      }
    }

    public function send($data){
      $this->db->query('INSERT INTO messages (to_id, to_name, from_id, from_name, chat_id, message, img, hub_id) VALUES(:to_id, :to_name, :from_id, :from_name, :chat_id, :message, :img, :hub_id)');
      // bind values
      $this->db->bind(':to_id', $data['to_id']);
      $this->db->bind(':to_name', $data['to_name']);
      $this->db->bind(':from_id', $data['from_id']);
      $this->db->bind(':from_name', $data['from_name']);
      $this->db->bind(':chat_id', $data['chat_id']);
      $this->db->bind(':message', $data['message']);
      $this->db->bind(':img', $data['img']);
      $this->db->bind(':hub_id', $data['hub_id']);

      // execute
      if($this->db->execute()){
        return true;
      } else {
        return false;
      }
    }

    public function deleteMessage($id){
      $this->db->query('DELETE FROM messages WHERE id = :id');
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
