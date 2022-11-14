<?php

namespace App\Model;

use App\Model\Connection;
use PDO;

class GeneralManager
{
    public PDO $pdo;

    public function __construct()
    {
        $connection = new Connection();
        $this->pdo = $connection->getConnection();
    }

    public function showImgDir()
    {
        $dir = "assets/images/imgPicker";

        $listImg = [];

        $picDir= opendir($dir);
        while ($file = readdir($picDir)) {
            if ($file === '.' || $file === '..') {
                continue;
            }
            
            $listImg[] = $dir . '/' . $file;
        }
        closedir($picDir);

        return $listImg;
    }

    /**
     * search function on top navbar
     * Retrieves all songs where value = $_POST['search']
     */
    public function songSearch():array
    {
        $query = 'SELECT songs.ID_song , songs.title , songs.artist , genre.genre, songs.image_url FROM songs
        join genre on songs.genre_ID_genre = genre.ID_genre
        where songs.title like "%'.$_POST['search'].'%" or songs.artist like "%'.$_POST['search'].'%" or genre.genre like "%'.$_POST['search'].'%"';

        return $this->pdo->query($query)->fetchAll();
    }

    /**
     * Get song info from database by song ID on link.
     */
    public function selectSongById(int $id): array | false
    {
        // prepared request
        $statement = $this->pdo->prepare("SELECT songs.ID_song , songs.title , songs.artist , genre.genre, songs.image_url, songs.song_url FROM songs
                                            join genre on songs.genre_ID_genre = genre.ID_genre
                                            WHERE songs.ID_song=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetch();
    }

    /**
     * Get list of songs by artist using song ID value on link
     */
    public function getsongList(int $id):array | false
    {

        $statement = $this->pdo->prepare("SELECT s2.ID_song , s2.title , s2.artist , g1.genre
        FROM songs s1 
        JOIN songs s2 ON s1.artist=s2.artist 
        JOIN genre g1 on s2.genre_ID_genre = g1.ID_genre
        WHERE s1.ID_song=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll();
    }

}