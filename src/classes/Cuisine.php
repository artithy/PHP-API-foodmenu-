<?php

namespace App\classes;

use App\Database;
use PDO;


class Cuisine extends Database
{

    public function createCuisine($cuisineName)
    {


        $stmt = $this->pdo->prepare("SELECT * FROM cuisine WHERE name = ?");
        $stmt->execute([$cuisineName]);

        if ($stmt->fetchColumn() > 0) {
            return [
                'status' => false,
                'message' => 'Cuisine with this name already exists'
            ];
        }
        $stmt = $this->pdo->prepare("INSERT INTO cuisine (name) VALUES (?)");
        $executed = $stmt->execute([$cuisineName]);

        if ($executed) {
            return [
                'status' => true,
                'message' => 'Cuisine created',
                'id' => $this->pdo->lastInsertId(),
                'name' => $cuisineName
            ];
        } else {
            return [
                'status' => false,
                'message' => 'failed to insert cuisine'
            ];
        }
    }



    public function getCuisineById($id)
    {
        $sql = "SELECT id , name FROM cuisine WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllCuisine()
    {
        $sql = "SELECT id, name from cuisine ORDER By name ASC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
