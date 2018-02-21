<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once 'www/include/php/mvc/Model.php';

final class Dictionary extends ModelM{
    private static $instance = null;
    public $dictionary =  array();    
    public $redis = FALSE;
    
    private function __construct($language){
        $this->language = $language;
        $db = new Model(); 
        $dic = $db->getDictionaryLanguage($language);            
        if($this->getStatusRedis()){
//            $r = $this->dictionary;
            $this->redis = TRUE;
            foreach($dic as $r){
                $this->setDictionaryByLang($language,$r[0], $r[1]);
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
            $result = $this->getValue($keyname);
        }else{
            $db = new Model(); 
            $result = $db->getDictionaryKey($this->language, $keyname);
        }
        return $result;
    }
}


?>


