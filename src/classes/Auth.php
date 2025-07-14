<?php

namespace App\classes;

use App\abstract\AuthBase;
use App\classes\Token;
use PDO;

class Auth extends AuthBase
{
    public function signup($user_name, $email, $password)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM user WHERE email=?");
        $stmt->execute([$email]);
        if ($stmt->rowCount() > 0) {
            return [
                'status' => false,
                'message' => 'User already exists'
            ];
        }

        $hashedPassword = $this->hashPassword($password);


        $stmt = $this->pdo->prepare("INSERT INTO user(user_name, email, password)VALUES(?,?,?)");
        $stmt->execute([$user_name, $email, $hashedPassword]);


        $user_id = $this->pdo->lastInsertId();
        $token = $this->generateToken();


        return [
            'status' => true,
            'message' => 'User created successfully',
            'user_id' => $user_id,
            'token' => $token
        ];
    }
}
