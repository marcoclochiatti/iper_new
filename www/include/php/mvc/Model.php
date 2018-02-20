<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include_once 'ModelEngine.php';
include_once 'www/config/Configurable.php';
class Model extends ModelEngine
{
    public function getDictionaryKey($language,$key){
        $sql = "SELECT " .$language ." FROM dictionary WHERE dic_key = ?";
        $result = ModelEngine::querySelect($sql,array($key));
        return $result;
    }
    
    public function getDictionaryLanguage($language){
        $sql = "SELECT dic_key, " .$language ." FROM dictionary";
        $result = ModelEngine::querySelect($sql,array());
        return $result;
    }
    
    public function getDictionary(){
        $list_language = Configurable::queryConfiguration('language', 'list_laguage');
        $sql = "SELECT dic_key, " .$list_language ." FROM dictionary";
        $result = ModelEngine::querySelect($sql,array());
        return $result;
    }
}
