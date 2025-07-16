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

$cuisine = new Cuisine();
$result = $cuisine->getAllCuisine();

http_response_code();
$responseHelper->printResponse([
    'status' => true,
    'message' => "All cuisine fetched.",
    'cuisine' => $result

]);
