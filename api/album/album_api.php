<?php 

class Album {

    private $conn;

    //album variables
    public $album_id;
    public $album_title;
    public $album_rating;
    public $spotify_id;
    public $art_url;
    public $artist_name;
    public $year_value;
    public $AverageRating;

    public function __construct($db) {
        $this -> conn = $db;
    }

    //Function to get all albums
    public function getAlbums() {
        $query = "SELECT album.album_id, album.album_title, artist.artist_name, art.art_url, AVG(review.review_rating) AS AverageRating FROM album  
                    INNER JOIN review 
                    ON album.album_id = review.album_id 
                    INNER JOIN artist
                    ON album.artist_id = artist.artist_id
                    INNER JOIN art 
                    ON album.art_id = art.art_id
                    GROUP BY album.album_id";
        $result = $this -> conn -> query($query);
        return $result;
    }

    //Function to get album by album_id
    public function getAlbumByID() {
        $query = "SELECT album.album_title, album.spotify_id, art.art_url, artist.artist_name, year_value.year_value, AVG(review.review_rating) AS AverageRating from album
                    INNER JOIN art
                    ON album.art_id = art.art_id
                    INNER JOIN artist 
                    ON album.artist_id = artist.artist_id
                    INNER JOIN year_value
                    ON album.year_id = year_value.year_value_id
                    LEFT JOIN review 
                    ON album.album_id = review.album_id 
                    WHERE album.album_id = ?";
         $result = $this -> conn -> query($query);
         
        $data = $result -> fetch_assoc();
        $this -> album_title = $data['album_title'];
        $this -> spotify_id = $data['spotify_id'];
        $this -> art_url = $data['art_url'];
        $this -> artist_name = $data['artist_name'];
        $this -> year_value = $data['year_value'];
        $this -> AverageRating = $data['AverageRating'];

    }

}

?>