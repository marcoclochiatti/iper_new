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
        $result_raw = ModelEngine::querySelect($sql,array());
        $result = array();
        foreach($result_raw as $res){
            $result[] =  array($res[0],$res[1]);
        }
        return $result;
    }
    
    public function getDictionary(){
        $list_language = Configurable::queryConfiguration('language', 'list_laguage');
        $sql = "SELECT dic_key, " .$list_language ." FROM dictionary";
        $result = ModelEngine::querySelect($sql,array());
        return $result;
    }
}


class ModelM extends ModelEngineMem{
    
    public function __construct() {
        $r = ModelEngineMem::getInstance();
    }
    
    
    private function build_key($language,$key){
        return $language .'_' .$key;
    }
    
    public function getStatusRedis(){
        $r = ModelEngineMem::getInstance();
        return $r->connection_status;
    }
    public function setDictionaryByLang($language,$key,$value){
        $new_key = $this->build_key($language, $key);
        $result = ModelEngineMem::setValue($new_key, $value);        
        return TRUE;
    }
    
    public function getDictionaryByLang($language,$key){
        $new_key = $this->build_key($language, $key);
        $result = ModelEngineMem::getValue($new_key);
        return $result;
    }
}

