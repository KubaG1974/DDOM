<?php
class Database {

    private $pdo;

    public function __construct() {

        $host = 'mysql8';
        $db = '38299344_ddom';
        $user = '38299344_ddom';
        $pass = 'SuperT@jne!';
        $dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";

        try {

            $this->pdo = new PDO($dsn, $user, $pass);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch (PDOException $e) {

            die("Connection failed: " . $e->getMessage());

        }

    }

    public function getConnection(): PDO {

        return $this->pdo; 

    }

}