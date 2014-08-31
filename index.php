<?php
/*
 * Blizzard API Sample
 * Alberto González (@albertogonzcat)
 * MIT License
 */

// Include OAUTH Library
require('OAuth2/client.php');
require('OAuth2/GrantType/IGrantType.php');
require('OAuth2/GrantType/AuthorizationCode.php');

// Settings
$client_id = 'your client key';
$client_secret = 'your secret key';

$state = 'test';
$scope = 'wow.profile';

$redirect_uri = 'https://localhost/'; // SSL only
$region = "eu"; // us, eu, kr, tw, or cn
$authorize_uri = 'https://'.$region.'.battle.net/oauth/authorize';
$token_uri = 'https://'.$region.'.battle.net/oauth/token';

// Start new object OAUTH
$client = new OAuth2\Client($client_id, $client_secret);

if (!isset($_GET['code'])) {
    $auth_url = $authorize_uri.'?client_id='.$client_id.'&scope='.$scope.'&state='.$state.'&redirect_uri='.$redirect_uri.'&response_type=code';
    header('Location: ' . $auth_url);

    die('Redirect');
} else {

    $params = array('code' => $_GET['code'], 'redirect_uri' => $redirect_uri);
    $response = $client->getAccessToken($token_uri, 'authorization_code', $params);
    $info = $response['result'];
    $client->setAccessToken($info['access_token']);
    $response = $client->fetch('https://'.$region.'.api.battle.net/wow/user/characters');

    var_dump($response);
}
?>