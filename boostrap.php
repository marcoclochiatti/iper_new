<?php
include_once 'www/config/common.inc.php';

$smarty->assign('DIC', $dic->getByKey('SITE_TITLE'));
$smarty->assign('TITLE_SITE_PAGE', $dic->getByKey('TITLE_SITE_HOME'));
$smarty->display('index.tpl');        

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

