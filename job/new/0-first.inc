<?php

setlocale(LC_ALL, "ru_RU.CP1251");


if(isset($_SESSION['login']))
{
    $user_login = true;
    if(!isset($_SESSION['user']))
        $_SESSION['user'] = $_SESSION['panel_user_id'];

    if(!isset($_SESSION['user_name']))
        $_SESSION['user_name'] = $_SESSION['s_name'];

    if(!isset($_SESSION['user_type']))
        $_SESSION['user_type'] = 'employer';
}





?>