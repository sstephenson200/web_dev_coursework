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
                    INNER JOIN album_genre 
                    ON album.album_id = album_genre.album_id 
                    INNER JOIN genre
                    ON album_genre.genre_id = genre.genre_id
                    INNER JOIN album_subgenre 
                    ON album.album_id = album_subgenre.album_id 
                    INNER JOIN subgenre
                    ON album_subgenre.subgenre_id = subgenre.subgenre_id
                    GROUP BY album.album_id 
                    ORDER BY album.album_rating";

        $statement = $this -> conn -> prepare($query);
        $statement -> execute(); 
        return $statement;
    }

    //Function to get album by album_id
    public function getAlbumByID($album_id) {

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

        $statement = $this -> conn -> prepare($query);
        $album_id = htmlspecialchars(strip_tags($album_id));
        $statement -> bind_param("s", $album_id);
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

}

?>