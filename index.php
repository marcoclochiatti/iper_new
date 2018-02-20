<?php
if (session_status() != PHP_SESSION_DISABLED){
    if (session_status() == PHP_SESSION_NONE) {
        include_once 'boostrap.php';
        include_once 'www/include/php/utility/Template.php';
        $smarty = TemplateEngine::getInstance();                
        $t =  $smarty->display('index.tpl');
    }else{
        
    }        
} else {
    echo "SESSION IS DISABLED";
}
