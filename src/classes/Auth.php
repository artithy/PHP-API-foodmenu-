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

    public function login($email, $password)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM user WHERE email = ?");
        $stmt->execute([$email]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            return [
                'status' => false,
                'message' => 'User not found'
            ];
        }

        if (!$this->verifyPassword($password, $user['password'])) {
            return [
                'status' => false,
                'message' => 'Incorrect password'
            ];
        }

        // ✅ Generate token
        $token = $this->generateToken();

        // ✅ Save token to token table
        $tokenObj = new Token();
        $tokenObj->create($token, $user['id']);

        return [
            'status' => true,
            'message' => 'Login successful',
            'user_id' => $user['id'],
            'token' => $token
        ];
    }


    public function dashboard($token)
    {
        $tokenObj = new Token();
        $user_id = $tokenObj->getUserIdByToken($token);

        if (!$user_id) {
            return [
                'status' => false,
                'message' => 'Invalid Token'
            ];
        }

        $stmt = $this->pdo->prepare("SELECT id, user_name,email from user WHERE id=?");
        $stmt->execute([$user_id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            return [
                'status' => false,
                'message' => 'user not found'
            ];
        }

        return [
            'status' => true,
            'user' => $user
        ];
    }

    public function logout($token)
    {
        $tokenObj = new Token();

        $valid = $tokenObj->validate($token);

        if (!$valid) {
            return [
                'status' => false,
                'message' => 'Invalid'
            ];
        }

        $tokenObj->deactivate($token);

        return [
            'status' => true,
            'message' => 'Logout successful'
        ];
    }
}
