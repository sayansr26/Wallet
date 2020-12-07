<?php 

//  getting connection information

$dsn = "mysql:host=localhost;dbname=wallet";
$user = "root";
$password = "";

$connection = new PDO($dsn,$user,$password);

try{
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connection Success";
}catch(PDOException $e){
    echo "COnnection Failed: " . $e->getMessage();
}
