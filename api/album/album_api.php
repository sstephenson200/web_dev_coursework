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
    public $genre_title;
    public $subgenre_title;
    public $song_title;
    public $song_length;
    public $Genres;
    public $Subgenres;
    public $Artists;
    public $Decades;

    public function __construct($db) {
        $this -> conn = $db;
    }

    //Function to get trending albums
    public function getTrendingAlbums() {
        
        $query = "SELECT album.album_id, album.album_title, artist.artist_name, art.art_url, AVG(review.review_rating) AS AverageRating FROM album  
                    INNER JOIN review 
                    ON album.album_id = review.album_id 
                    INNER JOIN artist
                    ON album.artist_id = artist.artist_id
                    INNER JOIN art 
                    ON album.art_id = art.art_id
                    GROUP BY album.album_id
                    ORDER BY AverageRating DESC
                    LIMIT 10";

       
        $statement = $this -> conn -> prepare($query);
        $statement -> execute();
        return $statement;
    }

    //Function to get all albums
    public function getAllAlbums() {
        $query = "SELECT album.album_id, album.album_rating, album.album_title, artist.artist_name, art.art_url, year_value.year_value, GROUP_CONCAT(DISTINCT genre.genre_title) AS Genres, GROUP_CONCAT(DISTINCT subgenre.subgenre_title) as Subgenres, AVG(review.review_rating) AS AverageRating FROM album
                    LEFT JOIN review 
                    ON album.album_id = review.album_id 
                    INNER JOIN artist
                    ON album.artist_id = artist.artist_id
                    INNER JOIN art 
                    ON album.art_id = art.art_id
                    INNER JOIN year_value
                    ON album.year_id = year_value.year_value_id
                    LEFT JOIN album_genre 
                    ON album.album_id = album_genre.album_id 
                    LEFT JOIN genre
                    ON album_genre.genre_id = genre.genre_id
                    LEFT JOIN album_subgenre 
                    ON album.album_id = album_subgenre.album_id 
                    LEFT JOIN subgenre
                    ON album_subgenre.subgenre_id = subgenre.subgenre_id
                    GROUP BY album.album_id 
                    ORDER BY album.album_rating";

        $statement = $this -> conn -> prepare($query);
        $statement -> execute(); 
        return $statement;
    }

    //Function to get album by album_id
    public function getAlbumByID($album_id) {

        $query = "SELECT album.album_title, album.spotify_id, art.art_url, artist.artist_name, year_value.year_value, GROUP_CONCAT(DISTINCT genre.genre_title) AS Genres, GROUP_CONCAT(DISTINCT subgenre.subgenre_title) as Subgenres, AVG(review.review_rating) AS AverageRating from album
                    INNER JOIN art
                    ON album.art_id = art.art_id
                    INNER JOIN artist 
                    ON album.artist_id = artist.artist_id
                    INNER JOIN year_value
                    ON album.year_id = year_value.year_value_id
                    LEFT JOIN review 
                    ON album.album_id = review.album_id 
                    LEFT JOIN album_genre 
                    ON album.album_id = album_genre.album_id 
                    LEFT JOIN genre
                    ON album_genre.genre_id = genre.genre_id
                    LEFT JOIN album_subgenre 
                    ON album.album_id = album_subgenre.album_id 
                    LEFT JOIN subgenre
                    ON album_subgenre.subgenre_id = subgenre.subgenre_id
                    WHERE album.album_id = ?";

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
        $query = "SELECT album.album_id, album.album_title, album.album_rating, artist.artist_name, art.art_url, year_value.year_value, AVG(review.review_rating) AS AverageRating FROM album
                    LEFT JOIN review 
                    ON album.album_id = review.album_id
                    INNER JOIN artist
                    ON album.artist_id = artist.artist_id
                    INNER JOIN art 
                    ON album.art_id = art.art_id
                    INNER JOIN year_value
                    ON year_value.year_value_id = album.year_id
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

    //Function to return all distinct genre titles
    public function getGenres(){
        $query = "SELECT DISTINCT genre_title AS Genres FROM genre";

        $statement = $this -> conn -> prepare($query);
        $statement -> execute();
        return $statement;  
    }

    //Function to return all distinct subgenre titles
    public function getSubgenres(){
        $query = "SELECT DISTINCT subgenre_title AS Subgenres FROM subgenre";

        $statement = $this -> conn -> prepare($query);
        $statement -> execute();
        return $statement;  
    }

    //Function to return all distinct artist names
    public function getArtists(){
        $query = "SELECT DISTINCT artist_name AS Artists FROM artist";

        $statement = $this -> conn -> prepare($query);
        $statement -> execute();
        return $statement;  
    }

    //Function to return all distinct decades for album release
    public function getDecades(){
        $query = "SELECT DISTINCT(floor(year_value/10)*10) AS Decades FROM year_value";

        $statement = $this -> conn -> prepare($query);
        $statement -> execute();
        return $statement;  
    }

    //Function to create new artist
    public function createArtist($artist_name){
        $query = "INSERT INTO artist (artist_id, artist_name) VALUES (null, ?)";

        $statement = $this -> conn -> prepare($query);
        $artist_name = htmlspecialchars(strip_tags($artist_name));
        $artist_name = $this -> conn -> real_escape_string($artist_name);
        $statement -> bind_param("s", $artist_name);
        $statement -> execute();
        return $statement;
    }

    //Function to create new year
    public function createYear($year){
        $query = "INSERT INTO year_value (year_value_id, year_value) VALUES (null, ?)";

        $statement = $this -> conn -> prepare($query);
        $year = htmlspecialchars(strip_tags($year));
        $year = $this -> conn -> real_escape_string($year);
        $statement -> bind_param("s", $year);
        $statement -> execute();
        return $statement;
    }

    //Function to create new album art
    public function createArt($art_url){
        $query = "INSERT INTO art (art_id, art_url) VALUES (null, ?)";

        $statement = $this -> conn -> prepare($query);
        $art_url = htmlspecialchars(strip_tags($art_url));
        $art_url = $this -> conn -> real_escape_string($art_url);
        $statement -> bind_param("s", $art_url);
        $statement -> execute();
        return $statement;
    }

    //Function to create new album
    public function createAlbum($album_title, $album_rating, $spotify_id, $art_id, $artist_id, $year_id){
        $query = "INSERT INTO album (album_id, album_title, album_rating, spotify_id, art_id, artist_id, year_id) VALUES (null, ?, ?, ?, ?, ?, ?)";

        $statement = $this -> conn -> prepare($query);
        $album_title = htmlspecialchars(strip_tags($album_title));
        $album_title = $this -> conn -> real_escape_string($album_title);
        $album_rating = htmlspecialchars(strip_tags($album_rating));
        $album_rating = $this -> conn -> real_escape_string($album_rating);
        $spotify_id = htmlspecialchars(strip_tags($spotify_id));
        $spotify_id = $this -> conn -> real_escape_string($spotify_id);
        $art_id = htmlspecialchars(strip_tags($art_id));
        $art_id = $this -> conn -> real_escape_string($art_id);
        $artist_id = htmlspecialchars(strip_tags($artist_id));
        $artist_id = $this -> conn -> real_escape_string($artist_id);
        $year_id = htmlspecialchars(strip_tags($year_id));
        $year_id = $this -> conn -> real_escape_string($year_id);
        $statement -> bind_param("ssssss", $album_title, $album_rating, $spotify_id, $art_id, $artist_id, $year_id);
        $statement -> execute();
        return $statement;
    }

    //Function to get artist_id by artist name
    public function getArtistIDByName($artist_name){
        $query = "SELECT artist_id FROM artist WHERE artist_name=?";

        $statement = $this -> conn -> prepare($query);
        $artist_name = htmlspecialchars(strip_tags($artist_name));
        $artist_name = $this -> conn -> real_escape_string($artist_name);
        $statement -> bind_param("s", $artist_name);
        $statement -> execute();
        return $statement;  
    }

    //Function to get all years from year_value table
    public function getAllYears(){
        $query = "SELECT DISTINCT(year_value) FROM year_value";

        $statement = $this -> conn -> prepare($query);
        $statement -> execute();
        return $statement;  
    }

    //Function to get year_id by year value
    public function getYearIDByValue($year_value){
        $query = "SELECT year_value_id FROM year_value WHERE year_value.year_value=?";

        $statement = $this -> conn -> prepare($query);
        $year_value = htmlspecialchars(strip_tags($year_value));
        $year_value = $this -> conn -> real_escape_string($year_value);
        $statement -> bind_param("s", $year_value);
        $statement -> execute();
        return $statement;  
    }

    //Function to get art_id by art url
    public function getArtIDByURL($art_url){
        $query = "SELECT art_id FROM art WHERE art_url=?";

        $statement = $this -> conn -> prepare($query);
        $art_url = htmlspecialchars(strip_tags($art_url));
        $art_url = $this -> conn -> real_escape_string($art_url);
        $statement -> bind_param("s", $artist_name);
        $statement -> execute();
        return $statement;  
    }

    //Function to create new genre
    public function createGenre($genre){
        $query = "INSERT INTO genre (genre_id, genre_title) VALUES (null, ?)";

        $statement = $this -> conn -> prepare($query);
        $genre = htmlspecialchars(strip_tags($genre));
        $genre = $this -> conn -> real_escape_string($genre);
        $statement -> bind_param("s", $genre);
        $statement -> execute();
        return $statement;
    }

    //Function to get genre_id by genre title
    public function getGenreIDByTitle($genre){
        $query = "SELECT genre_id FROM genre WHERE genre_title=?";

        $statement = $this -> conn -> prepare($query);
        $genre = htmlspecialchars(strip_tags($genre));
        $genre = $this -> conn -> real_escape_string($genre);
        $statement -> bind_param("s", $genre);
        $statement -> execute();
        return $statement;  
    }

    //Function to add a record to album_genre table
    public function addAlbumGenre($genre_id, $album_id){
        $query = "INSERT INTO album_genre (album_genre_id, album_id, genre_id) VALUES (null, ?, ?)";

        $statement = $this -> conn -> prepare($query);
        $genre_id = htmlspecialchars(strip_tags($genre_id));
        $genre_id = $this -> conn -> real_escape_string($genre_id);
        $album_id = htmlspecialchars(strip_tags($album_id));
        $album_id = $this -> conn -> real_escape_string($album_id);
        $statement -> bind_param("ss", $album_id, $genre_id);
        $statement -> execute();
        return $statement;
    }

    //Function to create new subgenre
    public function createSubgenre($subgenre){
        $query = "INSERT INTO subgenre (subgenre_id, subgenre_title) VALUES (null, ?)";

        $statement = $this -> conn -> prepare($query);
        $subgenre = htmlspecialchars(strip_tags($subgenre));
        $subgenre = $this -> conn -> real_escape_string($subgenre);
        $statement -> bind_param("s", $subgenre);
        $statement -> execute();
        return $statement;
    }

    //Function to get subgenre_id by subgenre title
    public function getSubgenreIDByTitle($subgenre){
        $query = "SELECT subgenre_id FROM subgenre WHERE subgenre_title=?";

        $statement = $this -> conn -> prepare($query);
        $subgenre = htmlspecialchars(strip_tags($subgenre));
        $subgenre = $this -> conn -> real_escape_string($subgenre);
        $statement -> bind_param("s", $subgenre);
        $statement -> execute();
        return $statement;  
    }

    //Function to add a record to album_subgenre table
    public function addAlbumSubgenre($subgenre_id, $album_id){
        $query = "INSERT INTO album_subgenre (album_subgenre_id, album_id, subgenre_id) VALUES (null, ?, ?)";

        $statement = $this -> conn -> prepare($query);
        $subgenre_id = htmlspecialchars(strip_tags($subgenre_id));
        $subgenre_id = $this -> conn -> real_escape_string($subgenre_id);
        $album_id = htmlspecialchars(strip_tags($album_id));
        $album_id = $this -> conn -> real_escape_string($album_id);
        $statement -> bind_param("ss", $album_id, $subgenre_id);
        $statement -> execute();
        return $statement;
    }

    //Function to add new track to album
    public function addTrack($album_id, $title, $length){
        $query = "INSERT INTO song (song_id, song_title, song_length, album_id) VALUES (null, ?, ?, ?)";

        $statement = $this -> conn -> prepare($query);
        $album_id = htmlspecialchars(strip_tags($album_id));
        $album_id = $this -> conn -> real_escape_string($album_id);
        $title = htmlspecialchars(strip_tags($title));
        $title = $this -> conn -> real_escape_string($title);
        $length = htmlspecialchars(strip_tags($length));
        $length = $this -> conn -> real_escape_string($length);
        $statement -> bind_param("sss", $title, $length, $album_id);
        $statement -> execute();
        return $statement;
    }

}

?>