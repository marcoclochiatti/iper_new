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
    
    private function convertRelationPageToArray($result_param_raw,$result_rel){
        $result_param = array();
        foreach($result_param_raw as $res_tmp){
            $result_param[$res_tmp['id']] = array('name'=>$res_tmp['name'], 'value'=>$res_tmp['value']);
        }
        $result = array();
        foreach($result_rel as $res){
            $str = '<link rel="' .$res['rel'] .'" href="' .$res['url'] .'"';
            if(isset($result_param[$res['id']])){
                $str .= ' '. $result_param[$res['id']]['name'] .'="' .$result_param[$res['id']]['value'] .'" >';
            }else{
                $str .= ' >';
            }
            $index = $res['page_key'] .'_' .$res['position'];            
            if(!isset($result[$index])){
                $result[$index] = array();
            }
            $result[$index][] = $str;            
        }
        return $result;
    }
    
    private function convertScriptPageToArray($result_src){
        $result = array();
        foreach($result_src as $res){
            $str = '<script src="' .$res['src'] .'"></script>';
            $index = $res['page_key'] .'_' .$res['position'];            
            $result[$index] = $str;
        }
        return $result;
    }
    
    public function getReletionPage($page,$position){
        $sql = "SELECT id,page_key,position,rel,url FROM sys_ref_page WHERE page_key = ? AND position= ?";
        $result_rel = ModelEngine::querySelect($sql,array($page,$position));
        $sql = "SELECT a.id, b.name, b.value FROM sys_ref_page a, sys_param_ref_page b WHERE a.id = b.id_ref AND page_key = ? AND position= ?";
        $result_param_raw = ModelEngine::querySelect($sql,array($page,$position));
        $result = $this->convertRelationPageToArray($result_param_raw,$result_rel);
        return $result;
    }
    
    public function getReletion(){
        $sql = "SELECT id,page_key,position,rel,url FROM sys_ref_page";
        $result_rel = ModelEngine::querySelect($sql,array());
        $sql = "SELECT a.id, b.name, b.value FROM sys_ref_page a, sys_param_ref_page b WHERE a.id = b.id_ref";
        $result_param_raw = ModelEngine::querySelect($sql,array());
        $result = $this->convertRelationPageToArray($result_param_raw,$result_rel);        
        return $result;
    }
    
    public function getScript(){
        $sql = "SELECT page_key,position,src FROM sys_script_ref_page";
        $result_src = ModelEngine::querySelect($sql,array());
        $result = $this->convertScriptPageToArray($result_src);        
        return $result;
    }
    
    public function getScriptPage($page,$position){
        $sql = "SELECT page_key,position,src FROM sys_script_ref_page WHERE page_key=? AND position=?";
        $result_src = ModelEngine::querySelect($sql,array($page,$position));
        $result = $this->convertScriptPageToArray($result_src);        
        return $result;
    }

}


class ModelM extends ModelEngineMem{
    public $redis_connection;
    
    public function __construct() {
        $this->redis_connection = ModelEngineMem::getInstance();
    }
    
    
    private function check_key($key_name){
        if($this->redis_connection->connection_status){
            return $this->redis_connection->exists($key_name);
        }else{
            return FALSE;
        }
    }
       
    private function build_key($language,$key){
        return $language .'_' .$key;
    }
    
    private function to_json($variable){
        return json_encode($variable);
    }

    private function from_json($json_str){
        return json_decode($json_str);
    }

    private function getRelScript($type){
        $m = new Model();
        if($type=='rel'){
            $result = $m->getReletion();
        }
        if($type=='script'){
            $result = $m->getScript();
        }
        return $result;
    }
    
    public function key_insered($type){
        $key = Configurable::queryConfiguration('nosql', 'keyinsertvalue');
        $key .= $type;
        $t = $this->check_key($key);
        return $this->check_key($key);
    }
    
    public function key_insert($type){
        $key = Configurable::queryConfiguration('nosql', 'keyinsertvalue');
        $key .= $type;
        $this->setValue($key, '1');
    }
    
    public function getStatusRedis(){
        $this->redis_connection = ModelEngineMem::getInstance();
        return $this->redis_connection->connection_status;
    }
    public function setDictionaryByLang($language,$key,$value){
        $new_key = $this->build_key($language, $key);
        $result = $this->redis_connection->setValue($new_key, $value);        
        return TRUE;
    }
    
    public function getDictionaryByLang($language,$key){
        $new_key = $this->build_key($language, $key);   
        if($this->check_key($new_key)){
            $result = $this->redis_connection->getValue($new_key);
        }else{
            $result = NULL;
        }
        return $result;
    }
        
    public function setRelScriptPageAll(){        
        $r = $this->setRelScriptPage('rel');
        if($r){
            $this->setRelScriptPage('script');                
        }
        return $r;
    }
    
    public function setRelScriptPage($type){
        if($this->getStatusRedis()){
            $result = $this->getRelScript($type);
            $status = TRUE;       
            foreach($result as $key=>$res){
                $k = $type .'_' .$key;
                $r = $this->redis_connection->setValue($k,$this->to_json($res));
                if($r==FALSE){
                    $status = FALSE;
                }
            }
        }else{
            $status = FALSE;
        }
        return $status;
    }    
    
    public function getRelScriptPage($page, $position, $type){
        $key_name = $this->build_key($page,$position);
        $k = $type .'_' .$key_name;
        if($this->check_key($k)){
            $tmp = $this->redis_connection->getValue($k);
            $result = array($key_name=>$this->from_json($tmp));
        }else{
            $m = new Model();
            if($type=='rel'){
                $result = $m->getReletionPage($page,$position);
            }
            if($type=='script'){
                $result = $m->getScriptPage($page,$position);                
            }
            $this->redis_connection->setValue($key_name,$this->to_json($result));
        }        
        return $result;
    }
}

