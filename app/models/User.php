<?php
  class User {
    private $db;

    public function __construct(){
      $this->db = new Database;
    }

    // register user
    public function register($data){
      $this->db->query('INSERT INTO users (name, last_name, email, password, about, location, colour, img, img2, img3, hub, hub_id, hub_1_id, hub_2_id, hub_3_id, hub_4_id, hub_5_id, removed_hub) VALUES(:name, :last_name, :email, :password, :about, :location, :colour, :img, :img2, :img3, :hub, :hub_id, :hub_1_id, :hub_2_id, :hub_3_id, :hub_4_id, :hub_5_id, :removed_hub)');
      // bind values
      $this->db->bind(':name', $data['name']);
      $this->db->bind(':last_name', $data['last_name']);
      $this->db->bind(':email', $data['email']);
      $this->db->bind(':password', $data['password']);
      $this->db->bind(':about', $data['about']);
      $this->db->bind(':location', $data['location']);
      $this->db->bind(':colour', $data['colour']);
      $this->db->bind(':img', $data['img']);
      $this->db->bind(':img2', $data['img2']);
      $this->db->bind(':img3', $data['img3']);
      $this->db->bind(':hub', $data['hubname']);
      $this->db->bind(':hub_id', $data['hub_id']);
      $this->db->bind(':hub_1_id', $data['hub_1_id']);
      $this->db->bind(':hub_2_id', $data['hub_2_id']);
      $this->db->bind(':hub_3_id', $data['hub_3_id']);
      $this->db->bind(':hub_4_id', $data['hub_4_id']);
      $this->db->bind(':hub_5_id', $data['hub_5_id']);
      $this->db->bind(':removed_hub', $data['removed_hub']);

      // execute
      if($this->db->execute()){
        $id = $this->db->getLastInsertId();
        return $id;
      } else {
        return false;
      }
    }

    // login user
    public function login($email, $password){
      $this->db->query('SELECT * FROM users WHERE email = :email');
      $this->db->bind(':email', $email);

      $row = $this->db->single();

      // check if entered password matches hashed password in db
      $hashed_password = $row->password;
      if(password_verify($password, $hashed_password)){
        return $row;
      } else {
        return false;
      }
    }

    public function updateUser($data){
      $this->db->query('UPDATE users SET img = :img, colour = :colour, name = :name, last_name = :last_name, about = :about, location = :location WHERE id = :id');
      // bind values
      $this->db->bind(':id', $data['id']);
      $this->db->bind(':img', $data['img']);
      $this->db->bind(':colour', $data['colour']);
      $this->db->bind(':name', $data['name']);
      $this->db->bind(':last_name', $data['last_name']);
      $this->db->bind(':about', $data['about']);
      $this->db->bind(':location', $data['location']);

      // execute
      if($this->db->execute()){
        return true;
      } else {
        return false;
      }
    }

    public function updateUserStatus($data){
      $this->db->query('UPDATE users SET status = :status WHERE id = :id');
      // bind values
      $this->db->bind(':id', $data['id']);
      $this->db->bind(':status', $data['status']);

      // execute
      if($this->db->execute()){
        return true;
      } else {
        return false;
      }
    }

    // remove hub from users list
    public function updateHub1($data){
      $this->db->query('UPDATE users SET hub_1_id = :hub_id WHERE id = :id');
      // bind values
      $this->db->bind(':id', $data['id']);
      $this->db->bind(':hub_id', $data['hub_id']);

      // execute
      if($this->db->execute()){
        return true;
      } else {
        return false;
      }
    }

    public function updateHub2($data){
      $this->db->query('UPDATE users SET hub_2_id = :hub_id WHERE id = :id');
      // bind values
      $this->db->bind(':id', $data['id']);
      $this->db->bind(':hub_id', $data['hub_id']);

      // execute
      if($this->db->execute()){
        return true;
      } else {
        return false;
      }
    }

    public function updateHub3($data){
      $this->db->query('UPDATE users SET hub_3_id = :hub_id WHERE id = :id');
      // bind values
      $this->db->bind(':id', $data['id']);
      $this->db->bind(':hub_id', $data['hub_id']);

      // execute
      if($this->db->execute()){
        return true;
      } else {
        return false;
      }
    }

    public function updateHub4($data){
      $this->db->query('UPDATE users SET hub_4_id = :hub_id WHERE id = :id');
      // bind values
      $this->db->bind(':id', $data['id']);
      $this->db->bind(':hub_id', $data['hub_id']);

      // execute
      if($this->db->execute()){
        return true;
      } else {
        return false;
      }
    }

    public function updateHub5($data){
      $this->db->query('UPDATE users SET hub_5_id = :hub_id WHERE id = :id');
      // bind values
      $this->db->bind(':id', $data['id']);
      $this->db->bind(':hub_id', $data['hub_id']);

      // execute
      if($this->db->execute()){
        return true;
      } else {
        return false;
      }
    }

    public function updateUserDefaultHub($data){
      $this->db->query('UPDATE users SET hub = :hub, hub_id = :hub_id WHERE id = :id');
      // bind values
      $this->db->bind(':id', $data['id']);
      $this->db->bind(':hub', $data['hub']);
      $this->db->bind(':hub_id', $data['hub_id']);

      // execute
      if($this->db->execute()){
        return true;
      } else {
        return false;
      }
    }

    public function updateUserEmail($data){
      $this->db->query('UPDATE users SET email = :email WHERE id = :id');
      // bind values
      $this->db->bind(':id', $data['id']);
      $this->db->bind(':email', $data['email']);

      // execute
      if($this->db->execute()){
        return true;
      } else {
        return false;
      }
    }

    public function checkPassword($data){
      $this->db->query('SELECT * FROM users WHERE email = :email');
      $this->db->bind(':email', $data['email']);

      $row = $this->db->single();
      // check if entered password matches hashed password in db
      $hashed_password = $row->password;
      if(password_verify($data['password'], $hashed_password)){
        return true;
      } else {
        return false;
      }
    }

    public function updateUserPassword($data){
      $this->db->query('UPDATE users SET password = :password WHERE id = :id');
      // bind values
      $this->db->bind(':id', $data['id']);
      $this->db->bind(':password', $data['password']);

      // execute
      if($this->db->execute()){
        return true;
      } else {
        return false;
      }
    }

    public function updateUserStars($data){
      $this->db->query('UPDATE users SET stars = :stars WHERE id = :id');
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

    // get all users
    public function getAllUsers(){
      $this->db->query('SELECT * FROM users');
      $results = $this->db->resultSet();

      return $results;
    }

    // get user by id
    public function getUserById($id){
      $this->db->query('SELECT * FROM users WHERE id = :id');
      $this->db->bind(':id', $id);
      $row = $this->db->single();

      return $row;
    }

    // find user by email
    public function findUserByEmail($email){
      $this->db->query('SELECT * FROM users WHERE email = :email');
      $this->db->bind(':email', $email);
      $row = $this->db->single();

      // check row
      if($this->db->rowCount() > 0){
        return true;
      } else {
        return false;
      }
    }

    public function getHubmates($id){
      $this->db->query('SELECT *,
                        users.id as userId,
                        users.name as userName,
                        users.email as userEmail,
                        users.location as userLocation,
                        users.about as userAbout,
                        users.hub_id as userHubId,
                        users.hub_1_id as userHub1Id,
                        users.hub_2_id as userHub2Id,
                        users.hub_3_id as userHub3Id,
                        users.hub_4_id as userHub4Id,
                        users.hub_5_id as userHub5Id,
                        users.created_at as userCreated
                        FROM users
                        WHERE users.hub_1_id = :hub_id
                        OR users.hub_2_id = :hub_id
                        OR users.hub_3_id = :hub_id
                        OR users.hub_4_id = :hub_id
                        OR users.hub_5_id = :hub_id
                        ORDER BY users.created_at ASC
                        ');

      $this->db->bind(':hub_id', $id);

      $results = $this->db->resultSet();
      return $results;
    }

    public function deleteUser($id){
      $this->db->query('DELETE FROM users WHERE id = :id');
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
