<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\classes\Food;
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

$data = json_decode(file_get_contents('php://input'), true);

if (
    empty($data['name']) || empty($data['price']) || empty($data['discount_price']) || empty($data['vat_percentage']) ||
    empty($data['stock_quantity']) || empty($data['cuisine_id']) || empty($data['image'])
) {
    http_response_code(400);
    $responseHelper->printResponse([
        'status' => false,
        'message' => 'Missing required fields'
    ]);
    exit;
}


$base64Image = $data['image'];
$imageInfo = explode(',', $base64Image);
$extension = str_replace(["data:image/", ";base64"], "", $imageInfo[0]);
$imageName = "images/" . uniqid() . "." . $extension;

file_put_contents(__DIR__ . '/' . $imageName, base64_decode($imageInfo[1]));

$data['image'] = $imageName;

$food = new Food();

$response = $food->createFood($data);

http_response_code($response['status'] ? 201 : 500);

$responseHelper->printResponse($response);
