<?php
  class Hub {
    private $db;

    public function __construct(){
      $this->db = new Database;
    }

    public function getHubById($id){
      $this->db->query('SELECT * FROM hubs WHERE id = :id');
      $this->db->bind(':id', $id);
      $row = $this->db->single();

      return $row;
    }

    public function updateHubname($data){
      $this->db->query('UPDATE hubs SET name = :name WHERE id = :id');
      // bind values
      $this->db->bind(':id', $data['id']);
      $this->db->bind(':name', $data['name']);

      // execute
      if($this->db->execute()){
        return true;
      } else {
        return false;
      }
    }

    public function addHub($data){
      $this->db->query('INSERT INTO hubs (name) VALUES(:name)');
      // bind values
      $this->db->bind(':name', $data['hubname']);

      // execute
      if($this->db->execute()){
        $id = $this->db->getLastInsertId();
        return $id;
      } else {
        return false;
      }
    }

    public function joinHub($id){
      $this->db->query('UPDATE hubs SET id = :id');
      // bind values
      $this->db->bind('id', $id);

      // execute
      if($this->db->execute()){
        return true;
      } else {
        return false;
      }
    }

    public function deleteHub($id){
      $this->db->query('DELETE FROM hubs WHERE id = :id');
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
