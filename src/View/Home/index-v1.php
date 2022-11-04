<?php
require "../../../vendor/autoload.php";
require "../../Controller/SpotifyAPIController.php";

$spotify = new \App\Controller\SpotifyAPIController();

// connexion à l'API
$spotify->connectToAPI();

// création d'un tableau de test avec ID de musiques
$trackList = [];

// récupération des infos des musiques
$spotify->getTrackInfo($trackList);

//affichage des infos
foreach ($tracks->tracks as $track) {
    echo '<b>' . $track->name . '</b> by <b>' . $track->artists[0]->name . '</b> <br>';
    echo '<b>' . $track->album->name . '</b> realeased in <b>' . $track->album->release_date . '</b> <br>';
    echo '<img src="' . $track->album->images[1]->url . '" alt=""><br>';
}
