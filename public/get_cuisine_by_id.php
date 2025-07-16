<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\classes\Cuisine;
use App\traits\AuthUtils;

$responseHelper = new class {
    use AuthUtils;
};

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    $responseHelper->printResponse([
        'status' => false,
        'message' => 'Only GET method is allowed'
    ]);
    exit;
}

if (empty($_GET['id'])) {
    http_response_code(400);
    $responseHelper->printResponse([
        'status' => false,
        'message' => 'ID is required'
    ]);
    exit;
}

$cuisine = new Cuisine();
$data = $cuisine->getCuisineById($_GET['id']);

if ($data) {
    http_response_code(200);
    $responseHelper->printResponse([
        'status' => true,
        'message' => 'Found',
        'cuisine' => $data
    ]);
} else {
    http_response_code(404);
    $responseHelper->printResponse([
        'status' => false,
        'message' => 'Not found',
    ]);
}
