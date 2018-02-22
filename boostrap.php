<?php
include_once 'www/config/common.inc.php';
//include_once 'www/include/php/utility/Template.php';
//include_once 'www/include/php/utility/Dictionary.php';
//$smarty = TemplateEngine::getInstance();   
//$dic = Dictionary::getInstance('IT');
$smarty->assign('DIC', $dic->getByKey('SITE_TITLE'));
$smarty->assign('TITLE_SITE_PAGE', $dic->getByKey('TITLE_SITE_HOME'));
$smarty->display('index.tpl');        

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

