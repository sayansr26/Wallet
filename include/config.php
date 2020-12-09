<?php

$dbn = "mysql:host=localhost;dbname=wallet";
$user = "admin";
$password = "1511";

$connection = new PDO($dbn, $user, $password);

try {
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connection Successfull";
} catch (PDOException $e) {
    echo "Faield to connect database : " . $e->getMessage();
}
