<?php

namespace App\Model;

use PDO;

class FetchSongsManager extends Connection
{
    public function showImgDir(): array
    {
        $dir = "assets/images/imgPicker";

        $listImg = [];

        $picDir = opendir($dir);
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
    public function songSearch(): array
    {
        $query = 'SELECT songs.ID_song , songs.title , songs.artist , genre.genre, songs.image_url, songs.song_url
                    FROM songs
                    join genre on songs.genre_ID_genre = genre.ID_genre
                    where songs.title like "%' . $_GET['search'] . '%" or songs.artist like "%' . $_GET['search'] . '%" or genre.genre like "%' . $_GET['search'] . '%"';

        return $this->pdo->query($query)->fetchAll();
    }

    /**
     * Get song info from database by song ID on link.
     */
    public function selectSongById(int $id): array|false
    {
        // prepared request
        $statement = $this->pdo->prepare("SELECT songs.ID_song , songs.title , songs.artist , genre.genre,
                songs.image_url, songs.song_url FROM songs join genre on songs.genre_ID_genre = genre.ID_genre
                                            WHERE songs.ID_song=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetch();
    }

    /**
     * Select last siw tracks added on wildify for the Homepage
     *
     * @return mixed
     */
    public function selectLastSixAddedTracks()
    {
        $statement = $this->pdo->prepare(
            "SELECT id_song, title, artist, image_url, song_url
                FROM songs ORDER BY id_song DESC LIMIT 6"
        );
        $statement->execute();

        return $statement->fetchAll();
    }

    /**
     * Get list of songs by artist using song ID value on link
     */
    public function getsongList(int $id): array | false
    {
        $statement = $this->pdo->prepare("SELECT s2.ID_song , s2.title, s2.artist, s2.image_url, g1.genre
        FROM songs s1
        JOIN songs s2 ON s1.artist=s2.artist
        JOIN genre g1 on s2.genre_ID_genre = g1.ID_genre
        WHERE s1.ID_song=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll();
    }

    /**
     * Get list of liked songs by id
     */
    public function getLikedSongsById(int $id)
    {
        $statement = $this->pdo->prepare("SELECT s.ID_song, s.title, s.artist, s.image_url, s.song_url
        FROM songs s
        JOIN `like` l on l.songs_ID_song = s.ID_song
        WHERE l.user_ID_user =:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll();
    }

    /**
     * Get list of liked songs for play page by user id
     */
    public function getLikedSongsByUserId(int $userid)
    {
        $statement = $this->pdo->prepare("SELECT s.ID_song, s.title, s.artist, s.image_url, s.song_url
        FROM songs s
        JOIN `like` l on l.songs_ID_song = s.ID_song
        WHERE l.user_ID_user =:user");
        $statement->bindValue('user', $userid, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll();
    }
}
