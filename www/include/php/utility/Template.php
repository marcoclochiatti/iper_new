<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
 
 /* mio commento ste */

include_once 'www/include/thirdparty/smarty/libs/Smarty.class.php';
include_once 'www/include/php/mvc/Model.php';
include_once 'www/config/Configurable.php';


class TemplateEngine extends Configurable
{
   private static $instance = null;
   private $smarty = null;
   private function __construct()
   {
       $this->smarty = new Smarty();       
       $this->smarty->setTemplateDir('www/smarty/templates');
       $this->smarty->setCompileDir('www/smarty/templates_c');
       $this->smarty->setConfigDir('www/smarty/configs');
       $this->smarty->setCacheDir('www/smarty/cache');       
       $this->redis = new ModelM();
       if(!$this->redis->key_insered('template')){
           $this->redis->key_insert('template');
           $this->redis->setRelScriptPageAll();
       }
       
//       $this->smarty->caching = true;
   }
   
   public function get_smarty(){
       return $this->smarty;
   }
   
   
   public function reset_assign(){
       $this->smarty->clear_all_assign();
   }

    public function set_css_by_page($page){
        $r = new ModelM();  
    }
    
    public function assign($var_name,$list_variables){
        $tmp = count($list_variables);
        if ($tmp>0){
            if($tmp==1){
                $this->smarty->assign($var_name, $list_variables[0]);
            }else{
                $this->smarty->assign($var_name, $list_variables);
            }
        }
   }
   
   public function auto_assign_header_footer($page){
       $result = array();
       $tmp = $this->redis->getRelScriptPage($page,'header','rel');
       $this->smarty->assign('rel_header',$tmp[$page .'_header']);
       $tmp1 = $this->redis->getRelScriptPage($page,'header','script');
       $this->smarty->assign('script_header',$tmp1);            
   }
   
   
   public function display($file){
       $this->smarty->display($file);
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

