<?php 

class Community {

    private $conn;

    //community variables
    public $community_id;
    public $community_name;
    public $community_description;
    public $art_url;
    public $MemberCount;
    public $artist_name;
    public $genre_title;
    public $subgenre_title;

    public function __construct($db) {
        $this -> conn = $db;
    }

    //Function to get top communities
    public function getTopCommunities() {
        
        $query = "SELECT community.community_id, community.community_name, community.community_description, art.art_url, COUNT(joined_communities.user_id) AS MemberCount FROM community
                    INNER JOIN art
                    ON community.art_id = art.art_id
                    INNER JOIN joined_communities
                    ON community.community_id = joined_communities.community_id
                    INNER JOIN user
                    ON joined_communities.user_id = user.user_id
                    WHERE user.is_active=1
                    GROUP BY community.community_id
                    ORDER BY COUNT(joined_communities.user_id) DESC
                    LIMIT 4";
       
        $statement = $this -> conn -> prepare($query);
        $statement -> execute();
        return $statement;
    }

    //Function to get all communities
    public function getAllCommunities() {
        $query = "SELECT community.community_id, community.community_name, community.community_description, art.art_url, artist.artist_name FROM community
                    INNER JOIN art
                    ON community.art_id = art.art_id
                    LEFT JOIN artist
                    ON community.artist_id = artist.artist_id
                    GROUP BY community.community_id";

        $statement = $this -> conn -> prepare($query);
        $statement -> execute();
        return $statement;
    }

    //Function to get community genres by community_id
    public function getGenreByCommunityID($community_id){
        $query = "SELECT genre.genre_title FROM genre
                    INNER JOIN community_genre 
                    ON community_genre.genre_id = genre.genre_id
                    WHERE community_genre.community_id = ?";

        $statement = $this -> conn -> prepare($query);
        $community_id = htmlspecialchars(strip_tags($community_id));
        $community_id = $this -> conn -> real_escape_string($community_id);
        $statement -> bind_param("s", $community_id);
        $statement -> execute();
        return $statement;
    }

    //Function to get community subgenres by community_id
    public function getSubgenreByCommunityID($community_id){
        $query = "SELECT subgenre.subgenre_title FROM subgenre
                    INNER JOIN community_subgenre 
                    ON community_subgenre.subgenre_id = subgenre.subgenre_id
                    WHERE community_subgenre.community_id = ?";

        $statement = $this -> conn -> prepare($query);
        $community_id = htmlspecialchars(strip_tags($community_id));
        $community_id = $this -> conn -> real_escape_string($community_id);
        $statement -> bind_param("s", $community_id);
        $statement -> execute();
        return $statement;
    }

    //Function to get all communities by artist_name
    public function getCommunitiesByArtistName($artist_name){

        $query = "SELECT community.community_id, community.community_name, community.community_description, art.art_url, artist.artist_name FROM community
                    INNER JOIN art
                    ON community.art_id = art.art_id
                    INNER JOIN artist
                    ON community.artist_id = artist.artist_id
                    WHERE artist.artist_name = ?
                    GROUP BY community.community_id";

        $statement = $this -> conn -> prepare($query);
        $artist_name = htmlspecialchars(strip_tags($artist_name));
        $artist_name = $this -> conn -> real_escape_string($artist_name);
        $statement -> bind_param("s", $artist_name);
        $statement -> execute();
        return $statement;
    }

    //Function to get all communities with status: Pending
    public function getPendingCommunities(){
        $query = "SELECT community.community_id, community.community_name, community.community_description, art.art_url FROM community
                    INNER JOIN art
                    ON community.art_id = art.art_id
                    INNER JOIN status
                    ON community.status_id = status.status_id
                    WHERE status.status_title='Pending'
                    GROUP BY community.community_id";

        $statement = $this -> conn -> prepare($query);
        $statement -> execute();
        return $statement;
    }

    //Function to get community member count by community_id
    public function getCommunitySizeByCommunityID($community_id){
        $query = "SELECT COUNT(joined_communities.user_id) AS MemberCount FROM community
                    INNER JOIN joined_communities
                    ON community.community_id = joined_communities.community_id
                    INNER JOIN user
                    ON joined_communities.user_id = user.user_id
                    WHERE user.is_active=1
                    AND community.community_id=?";

        $statement = $this -> conn -> prepare($query);
        $community_id = htmlspecialchars(strip_tags($community_id));
        $community_id = $this -> conn -> real_escape_string($community_id);
        $statement -> bind_param("s", $community_id);
        $statement -> execute();
        return $statement;
    }

}

?>