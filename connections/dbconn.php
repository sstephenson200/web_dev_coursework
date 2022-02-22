<?php

class Database {
      private $host = "localhost";
      private $user = "testuser";
      private $pw = "password";
      private $db = "pebble_revolution";

      public function getConn() {

            $conn = new mysqli($this -> host, $this -> user, $this -> pw, $this -> db);

            if($conn -> connect_error) {
                  echo "Connection failure: " .$conn -> connect_error;
            } else {
                  return $conn;
            }

      }

}
 
 ?>