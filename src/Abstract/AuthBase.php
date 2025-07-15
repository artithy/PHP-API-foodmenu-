<?php

namespace App\abstract;

use App\Database;
use App\traits\AuthUtils;

abstract class Authbase extends Database
{
    use AuthUtils;

    abstract public function signup($user_name, $email, $password);
    abstract public function login($email, $password);
}
