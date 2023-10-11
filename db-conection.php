<?php
class conectionDb {
    private $server="localhost"; //127.0.0.1
    private $user=""; // root / solicitar usuario
    private $password = "";  // solicitar password
    private $conection;

    public function __construct() {
        try {
            $this->conection = new PDO("mysql:host=$this->server;dbname=id21374323_develop" ,$this->user, $this->password);
            $this->conection->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $error) {
            echo "Connection error: " . $error->getMessage();
        }
    }
    public function execute($sql) { 
        $this->conection->exec($sql);
        return $this->conection->lastInsertId();
      }
      public function query($sql) {
        $query=$this->conection->prepare($sql); // prepare task $sql instruction and store it in $query
        $query->execute();
        return $query->fetchAll();   // return all $sql information
      }
  }
?>