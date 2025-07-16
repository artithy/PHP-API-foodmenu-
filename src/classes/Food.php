<?php

namespace App\classes;

use App\Database;
use PDO;

class Food extends Database
{
    public function createFood($data)
    {
        $sql = "INSERT INTO food(name, description, price, discount_price, vat_percentage, stock_quantity, status, cuisine_id, image)
        VALUES (?,?,?,?,?,?,?,?,?)";
        $stmt = $this->pdo->prepare($sql);

        $executed = $stmt->execute([
            $data['name'],
            $data['description'] ?? null,
            $data['price'],
            $data['discount_price'],
            $data['vat_percentage'],
            $data['stock_quantity'],
            $data['status'],
            $data['cuisine_id'],
            $data['image']
        ]);

        if ($executed) {
            return [
                'status' => true,
                'message' => 'Food created successfully',
                'id' => $this->pdo->lastInsertId()

            ];
        } else {
            return [
                'status' => false,
                'message' => "Failed to create food"
            ];
        }
    }
}
