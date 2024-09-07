<?php
$host = 'localhost';
$dbname = '38299344_ddom'; 
$username = '38299344_ddom'; 
$password = 'SuperT@jne!';

try {
    
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {

    die("Error: Could not connect. " . $e->getMessage());

}