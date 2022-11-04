<?php
require_once '../vendor/autoload.php';
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Spotify API</title>
</head>
<body>

<?php

$session = new SpotifyWebAPI\Session(
    'db9effd8139e4d699e186fea3d7f6bd1',
    '6e9f03008be7451b9f59d0704d2d392e',
    'http://localhost:8888/public/index.php');

$api = new SpotifyWebAPI\SpotifyWebAPI();

if (isset($_GET['code'])) {
    $session->requestAccessToken($_GET['code']);
    $api->setAccessToken($session->getAccessToken());

    // CODE A INSERER ICI, APRES LA CONNEXION ET LA RECUP DES IDENTIFIANTS

    $tracks = $api->getTracks([
        '3K4HG9evC7dg3N0R9cYqk4', // One Step Closer by Linkin Park
    ]);

    foreach ($tracks->tracks as $track) {
        echo '<b>' . $track->name . '</b> by <b>' . $track->artists[0]->name . '</b> <br>';
        echo '<b>' . $track->album->name . '</b> realeased in <b>' . $track->album->release_date . '</b> <br>';
        echo '<img src="' . $track->album->images[1]->url . '" alt=""><br>';
    }

    // FIN BLOC CODE
}

?>

</body>
</html>
