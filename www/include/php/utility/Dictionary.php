<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once 'www/include/php/mvc/Model.php';

final class Dictionary{
    private static $instance = null;
    public $dictionary =  array();    
    public $redis = FALSE;
    
    private function __construct($language){
        $this->language = $language;
        $this->db = new Model();
        $this->redis_m = new ModelM();
        $dic = $this->db->getDictionaryLanguage($language);            
        if($this->redis_m->getStatusRedis()){
//            $r = $this->dictionary;
            $this->redis = TRUE;
            foreach($dic as $r){
                $this->redis_m->setDictionaryByLang($language,$r[0], $r[1]);
            }
        }else{
           $this->redis = FALSE;
        }                
    } 
            
    public static function getInstance($language){
        if(self::$instance == null){   
            $c = __CLASS__;
            self::$instance = new $c($language);            
        }
        return self::$instance;
    }
    
    public function getByKey($keyname){
        if($this->redis){
            $result = $this->redis_m->getDictionaryByLang($this->language, $keyname);
        }else{
            $db = new Model(); 
            $result = $db->getDictionaryKey($this->language, $keyname);
        }
        return array($result);
    }
}


?>


