<?php

class RememberMeController {

    public $token;
    public $selector;
    public $validator;

    //generates random selector and validator
    public function generate_token() {
        $selector = bin2hex(random_bytes(16));
        $validator = bin2hex(random_bytes(32));

        return [$selector, $validator, $selector . ":" . $validator];
    }

    //gets selector and validator from cookie 
    public function parse_token($token) {
        $parts = explode(":", $token);

        if ($parts and count($parts)==2){
            return [$parts[0],$parts[1]];
        } else {
            return null;
        }
    }

    //check if validator matches stored value
    public function check_token_valid($selector, $validator) {
        $base_url = "http://localhost/web_dev_coursework/api/";

        $token_endpoint = $base_url . "user/getUserTokenBySelector.php?selector=$selector";
        $token_resource = file_get_contents($token_endpoint);
        $token_data = json_decode($token_resource, true);

        if($token_data){
            return password_verify($validator, $token_data[0]['user_token_validator']);
        } else {
            return false;
        }
    }

}

?>