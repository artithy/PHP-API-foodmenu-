<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\classes\Auth;

$input = json_decode(file_get_contents('php://input'), true);
$token = $input['token'] ?? null;
$auth = new Auth();

if (!$token) {
    $auth->printResponse([
        'status' => false,
        'message' => 'Logout failed'
    ]);

    exit;
}

$response = $auth->logout($token);
$auth->printResponse($response);
