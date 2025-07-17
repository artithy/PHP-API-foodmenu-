<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\classes\Food;
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

$food = new Food();
$foods = $food->getAllFoods();

$responseHelper->printResponse(
    [
        'status' => true,
        'foods' => $foods
    ]
);
