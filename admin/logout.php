<?php 

setcookie('uid', '',time()-3600);
header('location:login?code=logout successfully');

?>