<?php

class Database {
      private $host = "localhost";
      private $user = "testuser";
      private $pw = "password";
      private $db = "pebble_revolution";

      public $conn;

      public function getConn() {

            $this -> conn = null;

            try {
                  $this -> conn = new mysqli($this -> host, $this -> user, $this -> pw, $this -> db);
            } catch(Exception $exception) {
                  echo "Connection failure: " . $exception -> getMessage();
            }

        return $this -> conn;
      }
}
 
 ?>