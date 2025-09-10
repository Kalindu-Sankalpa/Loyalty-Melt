<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/includes/auth.php';
if(isUserLoggedIn()){
    logoutUser();
    header('Location: login.php');
}else{
    header('Location: login.php');
}
