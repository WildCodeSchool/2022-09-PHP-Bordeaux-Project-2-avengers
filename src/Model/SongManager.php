<?php

namespace App\Model;

use App\Model\Connection;
use PDO;

class SongManager
{
    public PDO $pdo;

    public function __construct()
    {
        $connection = new Connection();
        $this->pdo = $connection->getConnection();
    }

    /**
     * Insert new song in db
     */
    public function addSong(array $song, $fileJacket, $fileTrack): void
    {
        $query = "INSERT INTO songs (user_ID_user, genre_ID_genre, title, artist, image_url, song_url)
                    VALUES (:id_user, (SELECT ID_genre FROM genre WHERE genre = :genre) , :title, :artist,
                        :image_url, :song_url)";
        $statement = $this->pdo->prepare($query);

        $statement->bindValue(':id_user', $song['ID_user'], \PDO::PARAM_STR);
        $statement->bindValue(':genre', $song['genre'], \PDO::PARAM_STR);
        $statement->bindValue(':title', $song['title'], \PDO::PARAM_STR);
        $statement->bindValue(':artist', $song['artist'], \PDO::PARAM_STR);
        $statement->bindValue(':image_url', $fileJacket['name'], \PDO::PARAM_STR);
        $statement->bindValue(':song_url', $fileTrack['name'], \PDO::PARAM_STR);

        $statement->execute();
    }
}
