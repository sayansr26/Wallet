<?php 

$dbn = "mysql:host=localhost;dbname=wallet";
$user = "root";
$password = "";

$connection = new PDO($dbn, $user, $password);

try{
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connection Successfull";
}catch(PDOException $e){
    echo "Faield to connect database : " . $e->getMessage();
}

?>