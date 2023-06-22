<?php 

session_start();

if(isset($_SESSION['userid'])){
    
    $_SESSION['userid'] = NULL;
    unset($_SESSION['userid']);

}

header("Location: login.php");
die;
