<?php

class SignupController {

    //sign up controller variables
    public $email;
    public $username;
    public $password1;
    public $password2;

    //sets user input to variables
    public function __construct($email, $username, $password1, $password2) {
        $this -> email = $email;
        $this -> username = $username;
        $this -> password1 = $password1;
        $this -> password2 = $password2;
    }

    //check if any form element is empty
    private function checkInput() {
        if(!empty($this -> email) and !empty($this -> username) and !empty($this -> password1) and !empty($this -> password2)){
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

    //check username doesn't contain invalid characters and is between 3-30 chars
    private function checkValidUsername(){

        if(!preg_match("/^[a-zA-Z0-9]*$/", $this -> username)) {
            return false;
        } else {
            return true;
        }
    }

    //check if username length is between 5 and 30 chars
    private function checkUsernameLength(){
        $len = strlen($this -> username);
        if($len<5 or $len>30){
            return false;
        } else {
            return true;
        }
    }

    //check entered passwords match
    private function checkMatchingPasswords(){

        if($this -> password1 == $this -> password2){
            return true;
        } else{
            return false;
        }
    }

    //check if password length is between 5 and 30 chars
    private function checkPasswordLength(){
        $len = strlen($this -> password1);
        if($len<5 or $len>30){
            return false;
        } else {
            return true;
        }
    }

    //check if entered signup data is valid
    public function checkSignUp(){
        $errorArray = [];
        if($this -> checkInput() == false){
            $error = "Empty input.";
            array_push($errorArray, $error);
        }

        if($this -> checkValidEmail() == false){
            $error = "Invalid email address.";
            array_push($errorArray, $error);
        }

        if($this -> checkValidUsername() == false){
            $error = "Invalid username.";
            array_push($errorArray, $error);
        }

        if($this -> checkUsernameLength() == false){
            $error = "Username length is invalid.";
            array_push($errorArray, $error);
        }

        if($this -> checkMatchingPasswords() == false){
            $error = "Passwords not a match.";
            array_push($errorArray, $error);
        }

        if($this -> checkPasswordLength() == false){
            $error = "Password length is invalid.";
            array_push($errorArray, $error);
        }

        return $errorArray;
    }

}

?>