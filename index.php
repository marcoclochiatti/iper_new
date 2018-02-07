<?php
if (session_status() != PHP_SESSION_DISABLED){
    if (session_status() == PHP_SESSION_NONE) {
        include_once 'www/config/globals.php';
        include_once 'www/config/config.php';
        
    }else{
        
    }        
} else {
    echo "SESSION IS DISABLED";
}