<?php

function login()
{
    if (isset($_COOKIE['aid']) && !empty($_COOKIE['aid'])) {
        return true;
    } else {
        return false;
    }
}
