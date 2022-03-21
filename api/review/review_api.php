<?php 

class Review {

    private $conn;

    //review variables
    public $review_id;
    public $review_title;
    public $review_text;
    public $review_rating;
    public $review_date;
    public $user_id;
    public $user_name;
    public $art_url;
    public $album_title;
    public $album_id;
    public $artist_name;

    public function __construct($db) {
        $this -> conn = $db;
    }

    // *** ADD REVIEW ***

    //Function to create a new review
    public function createReview($user_id, $album_id, $title, $text, $rating){
        $query = "INSERT INTO review (review_id, review_title, review_text, review_rating, album_id, user_id) VALUES (null, ?, ?, ?, ?, ?)";

        $statement = $this -> conn -> prepare($query);
        $user_id = htmlspecialchars(strip_tags($user_id));
        $user_id = $this -> conn -> real_escape_string($user_id);
        $album_id = htmlspecialchars(strip_tags($album_id));
        $album_id = $this -> conn -> real_escape_string($album_id);
        $title = htmlspecialchars(strip_tags($title));
        $title = $this -> conn -> real_escape_string($title);
        $text = htmlspecialchars(strip_tags($text));
        $text = $this -> conn -> real_escape_string($text);
        $rating = htmlspecialchars(strip_tags($rating));
        $rating = $this -> conn -> real_escape_string($rating);
        $statement -> bind_param("sssss", $title, $text, $rating, $album_id, $user_id);
        $statement -> execute();
        return $statement;
    }

    // *** DELETE REVIEW ***

    //Function to delete a user's review
    public function deleteReview($user_id, $album_id){
        $query = "DELETE FROM review WHERE user_id = ? AND album_id = ?";

        $statement = $this -> conn -> prepare($query);
        $user_id = htmlspecialchars(strip_tags($user_id));
        $user_id = $this -> conn -> real_escape_string($user_id);
        $album_id = htmlspecialchars(strip_tags($album_id));
        $album_id = $this -> conn -> real_escape_string($album_id);
        $statement -> bind_param("ss", $user_id, $album_id);
        $statement -> execute();
        return $statement;
    }

    //Function to delete review by album_id
    public function deleteReviewByAlbumID($album_id){
        $query = "DELETE FROM review WHERE album_id = ?";

        $statement = $this -> conn -> prepare($query);
        $album_id = htmlspecialchars(strip_tags($album_id));
        $album_id = $this -> conn -> real_escape_string($album_id);
        $statement -> bind_param("s", $album_id);
        $statement -> execute();
        return $statement; 
    }

    //Function to delete review by review_id
    public function deleteReviewByID($review_id){
        $query = "DELETE FROM review WHERE review_id = ?";

        $statement = $this -> conn -> prepare($query);
        $review_id = htmlspecialchars(strip_tags($review_id));
        $review_id = $this -> conn -> real_escape_string($review_id);
        $statement -> bind_param("s", $review_id);
        $statement -> execute();
        return $statement; 
    }

    // *** EDIT REVIEW ***

    //Function to update review status to approved
    public function approveReview($review_id){
        $query = "UPDATE review SET status_id=1 WHERE review_id=?";

        $statement = $this -> conn -> prepare($query);
        $review_id = htmlspecialchars(strip_tags($review_id));
        $review_id = $this -> conn -> real_escape_string($review_id);
        $statement -> bind_param("s", $review_id);
        $statement -> execute();
        return $statement;
    }

    //Function to update review status to rejected
    public function rejectReview($review_id){
        $query = "UPDATE review SET status_id=3 WHERE review_id=?";

        $statement = $this -> conn -> prepare($query);
        $review_id = htmlspecialchars(strip_tags($review_id));
        $review_id = $this -> conn -> real_escape_string($review_id);
        $statement -> bind_param("s", $review_id);
        $statement -> execute();
        return $statement;
    }

    //Function to report a review
    public function reportReview($review_id){
        $query = "UPDATE review SET status_id=4 WHERE review_id=?";

        $statement = $this -> conn -> prepare($query);
        $review_id = htmlspecialchars(strip_tags($review_id));
        $review_id = $this -> conn -> real_escape_string($review_id);
        $statement -> bind_param("s", $review_id);
        $statement -> execute();
        return $statement;
    }  

    //Function to edit an existing review
    public function updateReview($user_id, $album_id, $review_title, $review_text, $review_rating){
        $query = "UPDATE review SET review_title=?, review_text=?, review_rating=?, status_id=2 WHERE user_id=? AND album_id =?";

        $statement = $this -> conn -> prepare($query);
        $user_id = htmlspecialchars(strip_tags($user_id));
        $user_id = $this -> conn -> real_escape_string($user_id);
        $album_id = htmlspecialchars(strip_tags($album_id));
        $album_id = $this -> conn -> real_escape_string($album_id);
        $statement -> bind_param("sssss", $review_title, $review_text, $review_rating, $user_id, $album_id);
        $statement -> execute();
        return $statement;
    }

    // *** GET REVIEW ***

    //Function to check if a user has already posted a review for a given album
    public function checkReviewExists($user_id, $album_id){
        $query = "SELECT review.review_id FROM review WHERE user_id=? AND album_id=?";

        $statement = $this -> conn -> prepare($query);
        $user_id = htmlspecialchars(strip_tags($user_id));
        $user_id = $this -> conn -> real_escape_string($user_id);
        $album_id = htmlspecialchars(strip_tags($album_id));
        $album_id = $this -> conn -> real_escape_string($album_id);
        $statement -> bind_param("ss", $user_id, $album_id);
        $statement -> execute();
        return $statement;
    }

    //Function to get all reviews by album_id
    public function getReviewsByAlbumID($album_id) {

        $query = "SELECT review_id, review_title, review_text, review_rating, review_date, user.user_id, user.user_name, art.art_url FROM review
                    INNER JOIN user
                    ON review.user_id = user.user_id
                    INNER JOIN art
                    ON user.art_id = art.art_id
                    WHERE review.album_id = ?
                    AND status_id = 1
                    AND user.is_active = 1";

        $statement = $this -> conn -> prepare($query);
        $album_id = htmlspecialchars(strip_tags($album_id));
        $album_id = $this -> conn -> real_escape_string($album_id);
        $statement -> bind_param("s", $album_id);
        $statement -> execute();
        return $statement;
    }

    //Function to get all reviews by status
    public function getReviewsByStatus($status_title) {
        $query = "SELECT review.review_id, review.review_date, user.user_name, user.user_id, album.album_id, review.review_title, review.review_text, review.review_rating FROM review 
                    INNER JOIN user 
                    ON review.user_id = user.user_id
                    INNER JOIN album
                    ON review.album_id = album.album_id
                    INNER JOIN status
                    ON review.status_id = status.status_id
                    WHERE status.status_title = ?
                    AND user.is_active = 1
                    ORDER BY review.review_date";

        $statement = $this -> conn -> prepare($query);
        $status_title = htmlspecialchars(strip_tags($status_title));
        $status_title = $this -> conn -> real_escape_string($status_title);
        $statement -> bind_param("s", $status_title);
        $statement -> execute();
        return $statement;
    }

    //Function to get all reviews by user_id
    public function getReviewsByUserID($user_id) {

        $query = "SELECT album.album_title, album.album_id, artist.artist_name, review_id, review_title, review_text, review_rating, review_date, user.user_id, user.user_name, art.art_url FROM review
                    INNER JOIN user
                    ON review.user_id = user.user_id
                    INNER JOIN art
                    ON user.art_id = art.art_id
                    INNER JOIN album
                    ON review.album_id = album.album_id
                    INNER JOIN artist
                    ON album.artist_id = artist.artist_id
                    WHERE review.user_id = ?
                    AND status_id = 1";

        $statement = $this -> conn -> prepare($query);
        $user_id = htmlspecialchars(strip_tags($user_id));
        $user_id = $this -> conn -> real_escape_string($user_id);
        $statement -> bind_param("s", $user_id);
        $statement -> execute();
        return $statement;
    }

}

?>