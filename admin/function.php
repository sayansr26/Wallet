<?php 

function login(){
    if(isset($_COOKIE['uid']) && !empty($_COOKIE['uid'])){
        return true;
    }else{
        return false;
    }
}

?>