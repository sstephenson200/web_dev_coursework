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
    public $Genres;
    public $Subgenres;

    public function __construct($db) {
        $this -> conn = $db;
    }

    // *** GET COMMUNITY ***

    //Function to get all communities
    public function getAllCommunities() {
        $query = "SELECT community.community_id, community.community_name, community.community_description, art.art_url, artist.artist_name, GROUP_CONCAT(DISTINCT genre.genre_title) AS Genres, GROUP_CONCAT(DISTINCT subgenre.subgenre_title) as Subgenres, COUNT(DISTINCT(joined_communities.user_id)) AS MemberCount FROM community
                    INNER JOIN art
                    ON community.art_id = art.art_id
                    LEFT JOIN artist
                    ON community.artist_id = artist.artist_id
                    LEFT JOIN community_genre 
                    ON community.community_id = community_genre.community_id 
                    LEFT JOIN genre
                    ON community_genre.genre_id = genre.genre_id
                    LEFT JOIN community_subgenre 
                    ON community.community_id = community_subgenre.community_id 
                    LEFT JOIN subgenre
                    ON community_subgenre.subgenre_id = subgenre.subgenre_id
                    INNER JOIN joined_communities
                    ON community.community_id = joined_communities.community_id
                    INNER JOIN user
                    ON joined_communities.user_id = user.user_id
                    WHERE user.is_active=1
                    GROUP BY community.community_id";

        $statement = $this -> conn -> prepare($query);
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

    //Function to get community member count by community_id
    public function getCommunitySizeByCommunityID($community_id){
        $query = "SELECT COUNT(DISTINCT(joined_communities.user_id)) AS MemberCount FROM community
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
                    ORDER BY COUNT(DISTINCT(joined_communities.user_id)) DESC
                    LIMIT 4";
       
        $statement = $this -> conn -> prepare($query);
        $statement -> execute();
        return $statement;
    }

}

?>