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
