<?php

namespace App\Model;

use App\Model\Connection;
use PDO;

class SongManager extends Connection
{
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

    public function getLikeByUserId($id): array|null
    {
        $sql = "SELECT songs_ID_song FROM `like` WHERE user_ID_user = $id";
        $statement = $this->pdo->query($sql);

        return $statement->fetchAll();
    }

    public function checkSongLiked(int $idUser, int $idSong): bool|array
    {
        $sql = "SELECT * FROM `like` WHERE user_ID_user = $idUser and songs_ID_song = $idSong";
        $statement = $this->pdo->query($sql);

        return $statement->fetch();
    }

    public function addLikedSong(int $idUser, int $idSong): void
    {
        $sql = "INSERT INTO `like` (user_ID_user, songs_ID_song) VALUES ($idUser, $idSong)";
        $this->pdo->query($sql);
    }

    public function deleteLikedSong(int $idUser, int $idSong): void
    {
        $sql = "DELETE FROM `like` WHERE user_ID_user = $idUser AND songs_ID_song = $idSong";
        $this->pdo->query($sql);
    }

    public function getSongByUserId($id): array|null
    {
        $sql = "SELECT id_song, title, artist, image_url, song_url FROM `songs` WHERE user_ID_user = $id";
        $statement = $this->pdo->query($sql);

        return $statement->fetchAll();
    }

    /**
     * Delete song from database
     */
    public function deleteSongbyId($id): void
    {
        $statement = $this->pdo->prepare("DELETE FROM songs WHERE ID_song=:id");
        $statement->bindValue(':id', $id, \PDO::PARAM_INT);
        $statement->execute();
    }
}
