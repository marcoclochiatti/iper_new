<?php
if (session_status() != PHP_SESSION_DISABLED){
    if (session_status() == PHP_SESSION_NONE) {
        include_once 'boostrap.php';     
    }else{
        
    }        
} else {
    echo "SESSION IS DISABLED";
}
