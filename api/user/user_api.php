<?php 

class User {

    private $conn;

    //user variables
    public $user_id;
    public $user_name;
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

    //Function to check if username or email already exists in user table
    public function checkUserExists($email, $username){

        $query = "SELECT user_email, user_name FROM user WHERE user_email = ? OR user_name = ?";

        $statement = $this -> conn -> prepare($query);
        $email = htmlspecialchars(strip_tags($email));
        $email = $this -> conn -> real_escape_string($email);
        $username = htmlspecialchars(strip_tags($username));
        $username = $this -> conn -> real_escape_string($username);
        $statement -> bind_param("ss", $email, $username);
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

}

?>