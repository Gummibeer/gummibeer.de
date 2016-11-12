<?php
$app = require '../app.php';

use Guzzle\Http\Client;

$url = 'http://api.steampowered.com/IPlayerService/GetOwnedGames/v0001/';
$query = http_build_query([
    'key' => getenv('STEAM_KEY'),
    'steamid' => getenv('STEAM_ID'),
    'format' => 'json',
]);

$client = new Client();
$request = $client->get($url.'?'.$query);
$response = $request->send();
if($response->isSuccessful()) {
    $data = json_decode($response->getBody(true), true);
    $playtime = round(array_sum(array_column($data['response']['games'], 'playtime_forever')) / 60);
    file_put_contents(BASEDIR.'/data/playtime.txt', $playtime);
}

