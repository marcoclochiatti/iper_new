<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once 'www/include/php/mvc/Model.php';

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
   
   public function display($file){
       return $this->smarty->display($file);
   }
   
   public function reset_assign(){
       $this->smarty->clear_all_assign();
   }
   
   public function assign($list_variables){
       foreach($list_variables as $var_name->$var_value){
           $this->smarty->assign($var_name, $var_value); 
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


