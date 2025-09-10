<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/includes/auth.php';
if(isAdminLoggedIn()){
    logoutAdmin();
    header('Location: login.php');
}else{
    header('Location: login.php');
}
