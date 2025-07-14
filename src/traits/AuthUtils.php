<?php

namespace App\traits;

trait AuthUtils
{
    public function hashpassword($password)
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    public function verifyPassword($password, $hash)
    {
        return password_verify($password, $hash);
    }

    public function generateToken()
    {
        return bin2hex(random_bytes(32));
    }
}
