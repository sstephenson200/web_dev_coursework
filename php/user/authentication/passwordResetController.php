<?php

class PasswordResetController {

    //login controller variables
    public $email;

    //sets user input to variables
    public function __construct($email) {
        $this -> email = $email;
    }

    //check if any form element is empty
    private function checkInput() {
        if(!empty($this -> email)) {
            return true;
        } else {
            return false;
        }
    }

    //check if email is valid
    private function checkValidEmail(){
        
        if(filter_var($this -> email, FILTER_VALIDATE_EMAIL)){
            return true;
        } else {
            return false;
        }
    }

    //check if entered login data is valid
    public function checkPasswordReset(){
        $errorArray = [];
        if($this -> checkInput() == false){
            $error = "Empty input.";
            array_push($errorArray, $error);
        }
        if($this -> checkValidEmail() == false){
            $error = "Invalid email.";
            array_push($errorArray, $error);
        }

        return $errorArray;
    }

    //generate random password
    public function generateUserPassword() {
        $password = bin2hex(random_bytes(16));
        return $password;
    }

}

?>