<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once 'www/include/php/mvc/Model.php';

class Dictionary extends ModelM{
    private static $instance = null;
    public $dictionary;
    private function __construct($language){
        $db = new Model();         
        $this->dictionary = $db->getDictionaryLanguage($language);        
    }
    
    public static function filldictionary(){
        $r = $this->dictionary;
        echo $r;
        
    } 
            
    public static function getInstance()
   {
      if(self::$instance == null)
      {   
         $c = __CLASS__;
         self::$instance = new $c;
      }
      
      return self::$instance;
   }
}


?>


