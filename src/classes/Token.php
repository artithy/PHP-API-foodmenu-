<?php

namespace App\classes;

use App\Database;

class Token extends Database
{

    public function create($token, $user_id)
    {
        $sql = "INSERT INTO token (token, user_id, is_active) VALUES (?, ?, 1)";
        $this->pdo->prepare($sql)->execute([$token, $user_id]);
    }


    public function validate($token)
    {
        $sql = "SELECT * FROM token WHERE token = ? AND is_active = 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$token]);
        return $stmt->fetch();
    }


    public function deactivate($token)
    {
        $sql = "UPDATE token SET is_active = 0 WHERE token = ?";
        $this->pdo->prepare($sql)->execute([$token]);
    }


    public function getUserIdByToken($token)
    {
        $sql = "SELECT user_id FROM token WHERE token = ? AND is_active = 1 LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$token]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($row) {
            return $row['user_id'];
        }
        return false;
    }
}
