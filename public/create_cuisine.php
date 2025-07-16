<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\classes\Cuisine;
use App\traits\AuthUtils;


$responseHelper = new class {
    use AuthUtils;
};


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    $responseHelper->printResponse([
        'status' => false,
        'message' => 'Only POST method is allowed'
    ]);
    exit;
}


$data = json_decode(file_get_contents('php://input'), true) ?? $_POST;


if (empty($data['name'])) {
    http_response_code(400);
    $responseHelper->printResponse([
        'status' => false,
        'message' => 'Cuisine name is required.'
    ]);
    exit;
}

$cuisine = new Cuisine();
$result = $cuisine->createCuisine($data['name']);


$responseHelper->printResponse($result);
