<?php
if (session_status() != PHP_SESSION_DISABLED){
    if (session_status() == PHP_SESSION_NONE) {
        include_once 'www/config/Configurable.php';
        $smarty = Configurable::templateClass();
//        include_once 'www/config/globals.php';
//        include_once 'www/config/config.php';
        
        
        
        
        
        include_once $_SESSION['ROOT_URL'] .$_SESSION['utility'] .'utility.php';
        $smarty->display('home.tpl');
    }else{
        
    }        
} else {
    echo "SESSION IS DISABLED";
}
