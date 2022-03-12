<?php 

class User {

    private $conn;

    //user variables
    public $user_id;
    public $user_name;
    public $user_password;
    public $user_bio;
    public $location_code;
    public $location_name;
    public $art_url;
    public $album_id;
    public $album_rating;
    public $album_title;
    public $artist_name;
    public $AverageRating;
    public $community_id;
    public $community_name;
    public $community_description;
    public $user_contact_permissions;
    public $user_report_id;
    public $report_date;
    public $reporting_user_id;
    public $reported_user_id;
    public $report_reasoning;
    public $user_token_id;
    public $user_token_selector;
    public $user_token_validator;
    public $expiry;
    public $AdminCount;
    
    public function __construct($db) {
        $this -> conn = $db;
    }

    //Function to get a user's favourtie albums by user_id
    public function getFavouriteAlbumsByUserID($user_id) {

        $query = "SELECT album.album_id, album.album_rating, album.album_title, artist.artist_name, art.art_url, AVG(review.review_rating) AS AverageRating FROM album
                    LEFT JOIN review 
                    ON album.album_id = review.album_id 
                    INNER JOIN artist
                    ON album.artist_id = artist.artist_id
                    INNER JOIN art 
                    ON album.art_id = art.art_id
                    INNER JOIN favourite_music
                    ON album.album_id = favourite_music.album_id
                    WHERE favourite_music.user_id = ?
                    GROUP BY album.album_id 
                    ORDER BY album.album_rating";

        $statement = $this -> conn -> prepare($query);
        $user_id = htmlspecialchars(strip_tags($user_id));
        $user_id = $this -> conn -> real_escape_string($user_id);
        $statement -> bind_param("s", $user_id);
        $statement -> execute();
        return $statement;
    }

    //Function to get a user's owned albums by user_id
    public function getOwnedAlbumsByUserID($user_id) {

        $query = "SELECT album.album_id, album.album_rating, album.album_title, artist.artist_name, art.art_url, AVG(review.review_rating) AS AverageRating FROM album
                    LEFT JOIN review 
                    ON album.album_id = review.album_id 
                    INNER JOIN artist
                    ON album.artist_id = artist.artist_id
                    INNER JOIN art 
                    ON album.art_id = art.art_id
                    INNER JOIN owned_music
                    ON album.album_id = owned_music.album_id
                    WHERE owned_music.user_id = ?
                    GROUP BY album.album_id 
                    ORDER BY album.album_rating";

        $statement = $this -> conn -> prepare($query);
        $user_id = htmlspecialchars(strip_tags($user_id));
        $user_id = $this -> conn -> real_escape_string($user_id);
        $statement -> bind_param("s", $user_id);
        $statement -> execute();
        return $statement;
    }

   //Function to get a user's joined communities by user_id
   public function getJoinedCommunitiesByUserID($user_id) {

        $query = "SELECT community.community_id, community.community_name, community.community_description, art.art_url FROM community
                    INNER JOIN art
                    ON community.art_id = art.art_id
                    INNER JOIN joined_communities
                    ON community.community_id = joined_communities.community_id
                    WHERE joined_communities.user_id = ?
                    GROUP BY community.community_id";

        $statement = $this -> conn -> prepare($query);
        $user_id = htmlspecialchars(strip_tags($user_id));
        $user_id = $this -> conn -> real_escape_string($user_id);
        $statement -> bind_param("s", $user_id);
        $statement -> execute();
        return $statement;
}

    //Function to get user profile data by user_id
    public function getProfileDataByUserID($user_id){

        $query = "SELECT user.user_name, user.user_bio, location.location_code, location.location_name, user.user_contact_permissions, art.art_url FROM user
                    INNER JOIN art 
                    ON user.art_id = art.art_id 
                    INNER JOIN location
                    ON user.location_id = location.location_id
                    WHERE user.user_id = ?";

        $statement = $this -> conn -> prepare($query);
        $user_id = htmlspecialchars(strip_tags($user_id));
        $user_id = $this -> conn -> real_escape_string($user_id);
        $statement -> bind_param("s", $user_id);
        $statement -> execute();
        return $statement;
    }

    //Function to get all reported users
    public function getReportedUsers(){
       
        $query = "SELECT user_report_id, report_date, reporting_user_id, reported_user_id, report_reasoning FROM user_report
                    ORDER BY report_date";

        $statement = $this -> conn -> prepare($query);
        $statement -> execute();
        return $statement;
    }

    //Function to get all user location options
    public function getUserLocationName(){
        
        $query = "SELECT location_name FROM location";

        $statement = $this -> conn -> prepare($query);
        $statement -> execute();
        return $statement;
    }

    //Function to add a user's entered email to the email_list table
    public function createEmailSignup($email){

        $query = "INSERT INTO email_list (email_list_id, email) VALUES (null, ?)";

        $statement = $this -> conn -> prepare($query);
        $email = htmlspecialchars(strip_tags($email));
        $email = $this -> conn -> real_escape_string($email);
        $statement -> bind_param("s", $email);
        $statement -> execute();
        return $statement;
    }

    //Function to check if username already exists in user table
    public function checkUsernameExists($username){

        $query = "SELECT user_name FROM user WHERE user_name = ?";

        $statement = $this -> conn -> prepare($query);
        $username = htmlspecialchars(strip_tags($username));
        $username = $this -> conn -> real_escape_string($username);
        $statement -> bind_param("s", $username);
        $statement -> execute();
        return $statement;
    }

    //Function to check if username already exists in user table
    public function checkEmailExists($email){

        $query = "SELECT user_email FROM user WHERE user_email = ?";

        $statement = $this -> conn -> prepare($query);
        $email = htmlspecialchars(strip_tags($email));
        $email = $this -> conn -> real_escape_string($email);
        $statement -> bind_param("s", $email);
        $statement -> execute();
        return $statement;
    }

    //Function to create new user account
    public function createAccount($email, $username, $password){

        $query = "INSERT INTO user (user_id, user_name, user_password, user_email) VALUES (null, ?, ?, ?)";

        $statement = $this -> conn -> prepare($query);
        $email = htmlspecialchars(strip_tags($email));
        $email = $this -> conn -> real_escape_string($email);
        $username = htmlspecialchars(strip_tags($username));
        $username = $this -> conn -> real_escape_string($username);
        $password = htmlspecialchars(strip_tags($password));
        $password = $this -> conn -> real_escape_string($password);
        $password = password_hash($password, PASSWORD_DEFAULT);
        $statement -> bind_param("sss", $username, $password, $email);
        $statement -> execute();
        return $statement;
    }

    //Function to get user password
    public function getUserPassword($email){
        $query = "SELECT user_id, user_password FROM user WHERE user_email=?";

        $statement = $this -> conn -> prepare($query);
        $email = htmlspecialchars(strip_tags($email));
        $email = $this -> conn -> real_escape_string($email);
        $statement -> bind_param("s", $email);
        $statement -> execute();
        return $statement;
    }

    //Function to create new user token
    public function createUserToken($selector, $validator, $expiry_date, $user_id) {
        $query = "INSERT INTO user_token (user_token_id, user_token_selector, user_token_validator, expiry, user_id) VALUES (null, ?, ?, ?, ?)";

        $statement = $this -> conn -> prepare($query);
        $selector = htmlspecialchars(strip_tags($selector));
        $selector = $this -> conn -> real_escape_string($selector);
        $validator = htmlspecialchars(strip_tags($validator));
        $validator = $this -> conn -> real_escape_string($validator);
        $validator = password_hash($validator, PASSWORD_DEFAULT);
        $expiry_date = htmlspecialchars(strip_tags($expiry_date));
        $expiry_date = $this -> conn -> real_escape_string($expiry_date);
        $user_id = htmlspecialchars(strip_tags($user_id));
        $user_id = $this -> conn -> real_escape_string($user_id);
        $statement -> bind_param("ssss", $selector, $validator, $expiry_date, $user_id);
        $statement -> execute();
        return $statement;
    }

    //Function to get user by selector value
    public function getUserTokenBySelector($selector) {
        $query = "SELECT user_token_id, user_token_selector, user_token_validator, expiry, user_id FROM user_token WHERE user_token_selector = ?";

        $statement = $this -> conn -> prepare($query);
        $selector = htmlspecialchars(strip_tags($selector));
        $selector = $this -> conn -> real_escape_string($selector);
        $statement -> bind_param("s", $selector);
        $statement -> execute();
        return $statement;
    }

    //Function to delete user token
    public function deleteUserToken($user_id) {
        $query = "DELETE FROM user_token WHERE user_id = ?";

        $statement = $this -> conn -> prepare($query);
        $user_id = htmlspecialchars(strip_tags($user_id));
        $user_id = $this -> conn -> real_escape_string($user_id);
        $statement -> bind_param("s", $user_id);
        $statement -> execute();
        return $statement;
    }

    //Function to get user_id and user_name from token value
    public function getUserByToken($token) {
        $query = "SELECT user.user_id, user.user_name FROM user
                    INNER JOIN user_token
                    ON user.user_id = user_token.user_id
                    WHERE user_token_selector = ? AND expiry > now()
                    LIMIT 1";

        $statement = $this -> conn -> prepare($query);
        $token = htmlspecialchars(strip_tags($token));
        $token = $this -> conn -> real_escape_string($token);
        $statement -> bind_param("s", $token);
        $statement -> execute();
        return $statement;
    }

    //Function to check if user has admin privileges 
    public function getUserAdminStatus($user_id){
        $query = "SELECT COUNT(user.user_id) as AdminCount FROM admin_user
                    INNER JOIN user 
                    ON admin_user.user_id = user.user_id
                    WHERE user.user_id = ?
                    LIMIT 1";

        $statement = $this -> conn -> prepare($query);
        $user_id = htmlspecialchars(strip_tags($user_id));
        $user_id = $this -> conn -> real_escape_string($user_id);
        $statement -> bind_param("s", $user_id);
        $statement -> execute();
        return $statement;
    }

    //Function to update a user's password
    public function updatePassword($password, $user_id){
        $query = "UPDATE user SET user_password=? WHERE user_id=?";

        $statement = $this -> conn -> prepare($query);
        $password = htmlspecialchars(strip_tags($password));
        $password = $this -> conn -> real_escape_string($password);
        $password = password_hash($password, PASSWORD_DEFAULT);
        $user_id = htmlspecialchars(strip_tags($user_id));
        $user_id = $this -> conn -> real_escape_string($user_id);
        $statement -> bind_param("ss", $password, $user_id);
        $statement -> execute();
        return $statement;
    }

    //Function to get user_id associated with entered email
    public function getUserIDByEmail($email) {
        $query = "SELECT user_id FROM user WHERE user_email = ?";

        $statement = $this -> conn -> prepare($query);
        $email = htmlspecialchars(strip_tags($email));
        $email = $this -> conn -> real_escape_string($email);
        $statement -> bind_param("s", $email);
        $statement -> execute();
        return $statement;
    }

    //Function to add an album to a user's favourites
    public function addUserFavourite($user_id, $album_id){
        $query = "INSERT INTO favourite_music (favourite_music_id, user_id, album_id) VALUES (null, ?, ?)";

        $statement = $this -> conn -> prepare($query);
        $user_id = htmlspecialchars(strip_tags($user_id));
        $user_id = $this -> conn -> real_escape_string($user_id);
        $album_id = htmlspecialchars(strip_tags($album_id));
        $album_id = $this -> conn -> real_escape_string($album_id);
        $statement -> bind_param("ss", $user_id, $album_id);
        $statement -> execute();
        return $statement;
    }

    //Function to add an album to a user's owned albums
    public function addUserOwned($user_id, $album_id) {
        $query = "INSERT INTO owned_music (owned_music_id, user_id, album_id) VALUES (null, ?, ?)";

        $statement = $this -> conn -> prepare($query);
        $user_id = htmlspecialchars(strip_tags($user_id));
        $user_id = $this -> conn -> real_escape_string($user_id);
        $album_id = htmlspecialchars(strip_tags($album_id));
        $album_id = $this -> conn -> real_escape_string($album_id);
        $statement -> bind_param("ss", $user_id, $album_id);
        $statement -> execute();
        return $statement;
    }

    //Function to add user to community
    public function joinCommunity($user_id, $community_id) {
        $query = "INSERT INTO joined_communities (joined_communities_id, user_id, community_id) VALUES (null, ?, ?)";

        $statement = $this -> conn -> prepare($query);
        $user_id = htmlspecialchars(strip_tags($user_id));
        $user_id = $this -> conn -> real_escape_string($user_id);
        $community_id = htmlspecialchars(strip_tags($community_id));
        $community_id = $this -> conn -> real_escape_string($community_id);
        $statement -> bind_param("ss", $user_id, $community_id);
        $statement -> execute();
        return $statement;
    }

    //Function to delete user's favourited album
    public function deleteUserFavourite($user_id, $album_id) {
        $query = "DELETE FROM favourite_music WHERE user_id = ? AND album_id=?";

        $statement = $this -> conn -> prepare($query);
        $user_id = htmlspecialchars(strip_tags($user_id));
        $user_id = $this -> conn -> real_escape_string($user_id);
        $album_id = htmlspecialchars(strip_tags($album_id));
        $album_id = $this -> conn -> real_escape_string($album_id);
        $statement -> bind_param("ss", $user_id, $album_id);
        $statement -> execute();
        return $statement;
    }

    //Function to delete user's owned album
    public function deleteUserOwned($user_id, $album_id) {
        $query = "DELETE FROM owned_music WHERE user_id = ? AND album_id=?";

        $statement = $this -> conn -> prepare($query);
        $user_id = htmlspecialchars(strip_tags($user_id));
        $user_id = $this -> conn -> real_escape_string($user_id);
        $album_id = htmlspecialchars(strip_tags($album_id));
        $album_id = $this -> conn -> real_escape_string($album_id);
        $statement -> bind_param("ss", $user_id, $album_id);
        $statement -> execute();
        return $statement;
    }

    //Function to remove user from community
    public function leaveCommunity($user_id, $community_id) {
        $query = "DELETE FROM joined_communities WHERE user_id = ? AND community_id=?";

        $statement = $this -> conn -> prepare($query);
        $user_id = htmlspecialchars(strip_tags($user_id));
        $user_id = $this -> conn -> real_escape_string($user_id);
        $community_id = htmlspecialchars(strip_tags($community_id));
        $community_id = $this -> conn -> real_escape_string($community_id);
        $statement -> bind_param("ss", $user_id, $community_id);
        $statement -> execute();
        return $statement;
    }

}

?>