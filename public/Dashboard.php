<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\classes\Auth;

$inputData = file_get_contents('php://input');
// var_dump($_SERVER);
// var_dump($inputData);


$input = json_decode($inputData);
$token = $_SERVER["HTTP_AUTHORIZATION"] ?? null;

// var_dump(explode(' ', $token));
// echo $token;
// die;
$array = explode(' ', $token);
$token = $array[1];

$auth = new Auth();

if (!$token) {
    $auth->printResponse([
        'status' => false,
        'message' => 'Token required'
    ]);
    exit;
}

$response = $auth->dashboard($token);
$auth->printResponse($response);
