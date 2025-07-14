<?php

namespace App;

use PDO;
use PDOException;

class Database
{
    private $host = "127.0.0.1";
    private $dbname = "phpfoodmenu";
    private $username = "signup_login";
    private $password = "bnQ[9IF(73d9hhlT";
    public $pdo;

    public function __construct()
    {
        try {
            $this->pdo = new PDO(
                "mysql:host={$this->host};dbname={$this->dbname};charset=utf8",
                $this->username,
                $this->password
            );
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }
}
