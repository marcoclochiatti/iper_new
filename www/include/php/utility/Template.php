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
   /**
   * Il metodo statico che si occupa di restituire l’istanza univoca della classe.
   * per facilitare il riutilizzo del codice in altre situazioni, si frutta la
   * costante __CLASS__ che viene valutata automaticamente dall’interprete con il
   * nome della classe corrente (ricordo che “new $variabile” crea un’istanza della classe
   * il cui nome è specificato come stringa all’interno di $variabile)
   */
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

