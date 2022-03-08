<?php

class LoginController {

    //login controller variables
    public $email;
    public $password;

    //sets user input to variables
    public function __construct($email, $password) {
        $this -> email = $email;
        $this -> password = $password;
    }

    //check if any form element is empty
    private function checkInput() {
        if(!empty($this -> email) and !empty($this -> password)) {
            return true;
        } else {
            return false;
        }
    }

    //check if entered login data is valid
    public function checkLogin(){
        $errorArray = [];
        if($this -> checkInput() == false){
            $error = "Empty input.";
            array_push($errorArray, $error);
        }

        return $errorArray;
    }

}

?>