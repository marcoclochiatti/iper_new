<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();
$sHttp = (!empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on') ? 'https://' : 'http://';
$sDomain = ($_SERVER['SERVER_PORT'] != '80' && $_SERVER['SERVER_PORT'] != '443') ? $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] : $_SERVER['SERVER_NAME'];
$sPhp_self = str_replace('\\', '', dirname(htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES))); // Remove backslashes for Windows compatibility
$_SESSION['ROOT_URL'] = $sHttp . $sDomain . $sPhp_self;
$_SESSION['ROOT_PATH'] = $_SERVER['DOCUMENT_ROOT'] .$sPhp_self;

include_once 'www/include/php/class/db.class.php';
$dbiper = new Database();

$a = $dbiper->selectAll('path_table');
var_dump($a);

