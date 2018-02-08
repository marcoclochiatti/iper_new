<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include_once $_SESSION['ROOT_URL'] .$_SESSION['smarty_class'] .'libs/Smarty.class.php';

$smarty = new Smarty();

$smarty->setTemplateDir($_SESSION['ROOT_URL'] .$_SESSION['smarty_templates']);
$smarty->setCompileDir($_SESSION['ROOT_URL'] .$_SESSION['smarty_templates_c']);
$smarty->setConfigDir($_SESSION['ROOT_URL'] .$_SESSION['smarty_configs']);
$smarty->setCacheDir($_SESSION['ROOT_URL'] .$_SESSION['smarty_cache']);

