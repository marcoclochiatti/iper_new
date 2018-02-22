<?php
if(!isset($_SESSION))
{
    session_start();
}
$site_name = '/iper';
$_SESSION['BASE_URL'] = $site_name;
$_SESSION['BASE_PATH'] = $_SERVER['DOCUMENT_ROOT'] .$site_name;

include_once 'www/include/php/utility/Template.php';
include_once 'www/include/php/utility/Dictionary.php';
$smarty = TemplateEngine::getInstance();   
$dic = Dictionary::getInstance('IT');
$smarty->assign('DIC', $dic->getByKey('SITE_TITLE'));
$smarty->display('index.tpl');        

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

