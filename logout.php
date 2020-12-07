<?php


setcookie('uid', '', time() - 3600);
header('location:/?code=logout successfully');
