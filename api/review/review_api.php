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

    //Function to get all reviews by album_id
    public function getReviewsByAlbumID($album_id) {

        $query = "SELECT review_id, review_title, review_text, review_rating, review_date, user.user_id, user.user_name, art.art_url FROM review
                    INNER JOIN user
                    ON review.user_id = user.user_id
                    INNER JOIN art
                    ON user.art_id = art.art_id
                    WHERE review.album_id = ?
                    AND status_id = 1";

        $statement = $this -> conn -> prepare($query);
        $album_id = htmlspecialchars(strip_tags($album_id));
        $album_id = $this -> conn -> real_escape_string($album_id);
        $statement -> bind_param("s", $album_id);
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
                    ORDER BY review.review_date";

        $statement = $this -> conn -> prepare($query);
        $status_title = htmlspecialchars(strip_tags($status_title));
        $status_title = $this -> conn -> real_escape_string($status_title);
        $statement -> bind_param("s", $status_title);
        $statement -> execute();
        return $statement;
    }

    //Function to get album genres by album_id
    public function getGenreByAlbumID($album_id){
        $query = "SELECT genre.genre_title FROM genre
                    INNER JOIN album_genre 
                    ON album_genre.genre_id = genre.genre_id
                    WHERE album_genre.album_id = ?";

        $statement = $this -> conn -> prepare($query);
        $album_id = htmlspecialchars(strip_tags($album_id));
        $album_id = $this -> conn -> real_escape_string($album_id);
        $statement -> bind_param("s", $album_id);
        $statement -> execute();
        return $statement;
    }

    //Function to get album subgenres by album_id
    public function getSubgenreByAlbumID($album_id){
        $query = "SELECT subgenre.subgenre_title FROM subgenre
                    INNER JOIN album_subgenre 
                    ON album_subgenre.subgenre_id = subgenre.subgenre_id
                    WHERE album_subgenre.album_id = ?";

        $statement = $this -> conn -> prepare($query);
        $album_id = htmlspecialchars(strip_tags($album_id));
        $album_id = $this -> conn -> real_escape_string($album_id);
        $statement -> bind_param("s", $album_id);
        $statement -> execute();
        return $statement;
    }

    //Function to get songs by album_id
    public function getSongsByAlbumID($album_id){
        $query = "SELECT song.song_title, song.song_length FROM song
                    WHERE song.album_id = ?";

        $statement = $this -> conn -> prepare($query);
        $album_id = htmlspecialchars(strip_tags($album_id));
        $album_id = $this -> conn -> real_escape_string($album_id);
        $statement -> bind_param("s", $album_id);
        $statement -> execute();
        return $statement;
    }

    //Function to get all albums by artist_name
    public function getAlbumsByArtistName($artist_name){

        $query = "SELECT album.album_id, album.album_title, artist.artist_name, art.art_url, AVG(review.review_rating) AS AverageRating FROM album
                    LEFT JOIN review 
                    ON album.album_id = review.album_id
                    INNER JOIN artist
                    ON album.artist_id = artist.artist_id
                    INNER JOIN art 
                    ON album.art_id = art.art_id
                    WHERE artist.artist_name = ?
                    GROUP BY album.album_id";

        $statement = $this -> conn -> prepare($query);
        $artist_name = htmlspecialchars(strip_tags($artist_name));
        $artist_name = $this -> conn -> real_escape_string($artist_name);
        $statement -> bind_param("s", $artist_name);
        $statement -> execute();
        return $statement;
    }

    //Function to get all albums with album_title or artist_name containing a given search phrase
    public function searchAlbums($search) {
        $query = "SELECT album.album_id, album.album_title, artist.artist_name, art.art_url, AVG(review.review_rating) AS AverageRating FROM album
                    LEFT JOIN review 
                    ON album.album_id = review.album_id
                    INNER JOIN artist
                    ON album.artist_id = artist.artist_id
                    INNER JOIN art 
                    ON album.art_id = art.art_id
                    WHERE artist.artist_name LIKE ? OR album.album_title LIKE ?
                    GROUP BY album.album_id";

        $statement = $this -> conn -> prepare($query);
        $search = htmlspecialchars(strip_tags($search));
        $search = $this -> conn -> real_escape_string($search);
        $search = "%$search%";
        $statement -> bind_param("ss", $search, $search);
        $statement -> execute();
        return $statement;        
    }

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

}

?>