<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once 'www/config/ Configurable.php';

class TemplateEngine extends Configurable
{
    private $smarty;
    
    public function __construct()
        {
        parent::__construct();
        $path = $this->config->get('smarty','PATH');
        include_once $path;       
        $this->smarty = new Smarty();              
        }    
}

//$smarty = new Smarty();

//$smarty->setTemplateDir($_SESSION['ROOT_URL'] .$_SESSION['smarty_templates']);
//$smarty->setCompileDir($_SESSION['ROOT_URL'] .$_SESSION['smarty_templates_c']);
//$smarty->setConfigDir($_SESSION['ROOT_URL'] .$_SESSION['smarty_configs']);
//$smarty->setCacheDir($_SESSION['ROOT_URL'] .$_SESSION['smarty_cache']);

