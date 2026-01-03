<?php
  class Invite {
    private $db;

    public function __construct(){
      $this->db = new Database;
    }

    public function getInviteById($inviteId){
      $this->db->query('SELECT * FROM invites WHERE invite_id = :invite_id');
      $this->db->bind(':invite_id', $inviteId);

      $row = $this->db->single();
      return $row;
    }

    public function getInviteByUserId($id){
      $this->db->query('SELECT *,
                        invites.id as inviteId,
                        invites.hub_id as hubId,
                        invites.hub_name as hubName,
                        invites.to_id as toId,
                        invites.from_id as fromId,
                        invites.from_name as fromName,
                        invites.invite_id as inviteId,
                        invites.seen as seen,
                        invites.accepted as accepted,
                        invites.declined as declined,
                        invites.created_at as inviteCreated
                        FROM invites
                        WHERE invites.to_id = :id
                        ORDER BY invites.created_at ASC
                        ');

      $this->db->bind(':id', $id);

      $results = $this->db->resultSet();
      return $results;
    }

    public function getNewInvitesByUserId($id){
      $this->db->query('SELECT *,
                        invites.id as inviteId,
                        invites.hub_id as hubId,
                        invites.hub_name as hubName,
                        invites.to_id as toId,
                        invites.from_id as fromId,
                        invites.from_name as fromName,
                        invites.invite_id as inviteId,
                        invites.seen as seen,
                        invites.accepted as accepted,
                        invites.declined as declined,
                        invites.created_at as inviteCreated
                        FROM invites
                        WHERE invites.to_id = :id AND invites.seen = :seen
                        ORDER BY invites.created_at ASC
                        ');

      $this->db->bind(':id', $id);
      $this->db->bind(':seen', 0);

      $results = $this->db->resultSet();
      return $results;
    }

    public function getAllUserInvitesByHubId($data){
      $this->db->query('SELECT *,
                        invites.id as inviteId,
                        invites.hub_id as hubId,
                        invites.hub_name as hubName,
                        invites.to_id as toId,
                        invites.from_id as fromId,
                        invites.from_name as fromName,
                        invites.invite_id as inviteId,
                        invites.seen as seen,
                        invites.accepted as accepted,
                        invites.declined as declined,
                        invites.created_at as inviteCreated
                        FROM invites
                        WHERE invites.to_id = :id AND invites.hub_id = :hub_id
                        ORDER BY invites.created_at ASC
                        ');

      $this->db->bind(':id', $data['id']);
      $this->db->bind(':hub_id', $data['hub_id']);

      $results = $this->db->resultSet();
      return $results;
    }

    public function getAllHubInvites($hubId){
      $this->db->query('SELECT *,
                        invites.id as inviteId,
                        invites.hub_id as hubId,
                        invites.hub_name as hubName,
                        invites.to_id as toId,
                        invites.from_id as fromId,
                        invites.from_name as fromName,
                        invites.invite_id as inviteId,
                        invites.seen as seen,
                        invites.accepted as accepted,
                        invites.declined as declined,
                        invites.created_at as inviteCreated
                        FROM invites
                        WHERE invites.hub_id = :hub_id
                        ORDER BY invites.created_at ASC
                        ');

      $this->db->bind(':hub_id', $hubId);

      $results = $this->db->resultSet();
      return $results;
    }

    public function sendInvite($data){
      $this->db->query('INSERT INTO invites (hub_id, hub_name, to_id, from_id, from_name, invite_id) VALUES(:hub_id, :hub_name, :to_id, :from_id, :from_name, :invite_id)');
      // bind values
      $this->db->bind(':hub_id', $data['hub_id']);
      $this->db->bind(':hub_name', $data['hub_name']);
      $this->db->bind(':to_id', $data['to_id']);
      $this->db->bind(':from_id', $data['from_id']);
      $this->db->bind(':from_name', $data['from_name']);
      $this->db->bind(':invite_id', $data['invite_id']);

      // execute
      if($this->db->execute()){
        return true;
      } else {
        return false;
      }
    }

    public function updateInviteSeenFlag($data){
      $this->db->query('UPDATE invites SET seen = :seen WHERE id = :id');
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

    public function updateInviteResponse($data){
      $this->db->query('UPDATE invites SET accepted = :accepted, declined = :declined WHERE id = :id');
      // bind values
      $this->db->bind(':id', $data['id']);
      $this->db->bind(':accepted', $data['accepted']);
      $this->db->bind(':declined', $data['declined']);

      // execute
      if($this->db->execute()){
        return true;
      } else {
        return false;
      }
    }

    public function deleteInvite($id){
      $this->db->query('DELETE FROM invites WHERE id = :id');
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
