<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\classes\Auth;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        'status' => false,
        'message' => 'Only POST method allowed'
    ]);
    exit;
}
$input = json_decode(file_get_contents('php://input'), true);
$data = $input ?? $_POST;

if (
    empty($data['user_name']) ||
    empty($data['email']) ||
    empty($data['password'])
) {
    http_response_code(400);
    echo json_encode([
        'status' => false,
        'please' => 'please fill up all the fields'
    ]);
    exit;
}


$auth = new Auth();
$response = $auth->signup($data['user_name'], $data['email'], $data['password']);
echo json_encode($response);
