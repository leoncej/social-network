<?php
  /*
  PDO Database Class:
  Connect to database
  Create prepared statements
  Bind values
  Return rows and results
  */
  class Database {
    // constants created in config
    private $host = DB_HOST;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $dbname = DB_NAME;

    private $dbh;
    private $stmt;
    private $error;

    public function __construct(){
      // set DSN
      $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
      $options = array(
        // check there's a persistent conenction to the database
        PDO::ATTR_PERSISTENT => true,
        // better way to handle errors
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
      );

      // create PDO instance
      try{
        $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
      } catch(PDOException $e){
        $this->error = $e->getMessage();
        echo $this->error;
      }
    }

    // prepare statement with query
    public function query($sql){
      $this->stmt = $this->dbh->prepare($sql);
    }

    // prepare statement with query
    public function getLastInsertId(){
      return $this->dbh->lastInsertId();
    }

    // bind values
    public function bind($param, $value, $type = null){
      if(is_null($type)){
        switch(true){
          case is_int($value):
            $type = PDO::PARAM_INT;
            break;
          case is_bool($value):
            $type = PDO::PARAM_BOOL;
            break;
          case is_null($value):
            $type = PDO::PARAM_NULL;
            break;
          default:
            $type = PDO::PARAM_STR;
        }
      }

      $this->stmt->bindValue($param, $value, $type);
    }

    // execute the prepared statement
    public function execute(){
      return $this->stmt->execute();
    }

    // get result set as array of objects
    public function resultSet(){
      $this->execute();
      return $this->stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // get single record as object
    public function single(){
      $this->execute();
      return $this->stmt->fetch(PDO::FETCH_OBJ);
    }

    // get row count
    public function rowCount(){
      return $this->stmt->rowCount();
    }
  }
?>
