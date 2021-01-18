<?php 

function login(){
    if(isset($_COOKIE['aid'])  && !empty($_COOKIE['aid'])){
        return true;
    }else{
        return false;
    }
}

function setup(){
    require('include/config.php');
    $query = "SELECT * FROM admin_setup";
    $statement = $connection->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    foreach($result as $row){
        $configured = $row['configured'];
    }

    if($configured == 'YES'){
        return true;
    }else{
        return false;
    }
}
