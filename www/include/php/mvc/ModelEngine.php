<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include_once 'www/config/Configurable.php';
require_once "www/include/thirdparty/predis/autoload.php";

class ModelEngine extends Configurable
{
    private static $instance = null;
    public $connection_status = FALSE;
    private function __construct(){
        $dbname = Configurable::queryConfiguration('db','dbname');
        $dbusr = Configurable::queryConfiguration('db','db_usr');
        $dbpass = Configurable::queryConfiguration('db','db_pass');
        $dbserver = Configurable::queryConfiguration('db','db_server');
        try {
            $this->_connection  = new \PDO("mysql:host=$dbserver;dbname=$dbname", $dbusr, $dbpass);
            $this->connection_status = TRUE;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }       
    }   
    
    private static function queryConfiguration($sql,$value){
        $result = array();
        if($this->connection_status){
            try{      
                $sql_obj = $this->_connection->prepare($sql);
                $sql_obj->execute($values);
                $result = $sql_obj->fetchAll();                               
            }
            catch (PDOException $ex) {
                echo $e->getMessage();                
            }       
        }
        return $result;
    }
    
    
        
    private static function insertInto($tableName,$values, $user) {
        $i = NULL;
        try{
            $columns = array();
            $vals = array();
            foreach($values as $key=>$val){
                $columns[] = $key;
                $vals[] = $val;
            }
            $columns[] = 'creation_date';
            $columns[] = 'update_date';
            if($tablename!='users_table'){
                $columns[] = 'users';
            }
            $vals[] = 'NOW()';
            $vals[] = 'NOW()';
            $vals[] = $user;
            
                    
                    
                    
            $sql = "INSERT INTO ".$tableName." (" .implode(',',$columns) .") VALUES ('" ;
            $to_add = array();
            foreach($vals as $val){
               $to_add[] = '?';
            }
            
            $sql .= implode(', ', $to_add) .")";   
            $statemant = $this->_connection->prepare($sql); 
            $statemant->execute($vals);
            return TRUE;
        } catch (PDOException $ex) {
            echo $e->getMessage();
            return FALSE;
        }        
    }
    
    private static function updateTable($tablename, $setcolumn, $setoperator, $setvalue, $operator, $value, $column, $user){
        try{
            $sql = "UPDATE " .$tablename ." SET ";
            $tmp = array();
            for($i=1; $i<=count($setcolumn); $i++){
                $tmp[] = $setcolumn[i] ." " .$setoperator[i] ." '" .$setvalue[i] ."'";
            } 
            if($tablename!='users_table'){
                $tmp[] = "users='" .$user ."'";
            }
            $tmp[] = "update_date=NOW()";
            $sql .= implode(', ', $tmp);
            
            $sql .= " WHERE";
            $tmp = array();
            for($i=1; $i<=count($column); $i++){
                $tmp[] = $column[i] ." " .$operator[i] ." ?";
            }
            $sql .= implode('AND ', $tmp);
            $statemant = $this->_connection->prepare($sql); 
            $statemant->execute($value);
            return TRUE;
        } catch (PDOException $ex) {
            echo $e->getMessage();
            return FALSE;
        } 
    }
    
    
    
   /**
   * Il metodo statico che si occupa di restituire l’istanza univoca della classe.
   * per facilitare il riutilizzo del codice in altre situazioni, si frutta la
   * costante __CLASS__ che viene valutata automaticamente dall’interprete con il
   * nome della classe corrente (ricordo che “new $variabile” crea un’istanza della classe
   * il cui nome è specificato come stringa all’interno di $variabile)
   */
    public static function getInstance(){
        if(self::$instance == null){   
            $c = __CLASS__;
            self::$instance = new $c;
        }      
        return self::$instance;
    }
   
    
    public static function querySelect($sql, $values){        
        $result = $this->queryConfiguration($sql,$values);
        return $result;                
    }
     
    public static function queryInsert($tablename, $array_columns_and_values,$user){
        return $this->insertInto($tablename, $array_columns_and_values, $user);
    }
       
    public static function queryUpdate($tablename, $setcolumn, $setoperator, $setvalue, $operator, $value, $column, $user){
        return $this->updateTable($tablename, $setcolumn, $setoperator, $setvalue, $operator, $value, $column, $user);
    }
    
                                            
}


class ModelEngineMem extends Configurable
{
    private static $instance = null;
    public $connection_status = FALSE;
    private function __construct(){
        Predis\Autoloader::register();
        $redis_array = array('scheme'=>Configurable::queryConfiguration('nosql','scheme'),
                             'host'=>Configurable::queryConfiguration('nosql','host'),
                             'port'=>Configurable::queryConfiguration('nosql','port')
                            );

        $p = Configurable::queryConfiguration('nosql','pass');
        if($p!=''){
            $redis_array['password'] = $p;
        }
        try {
            $this->redis = new Predis\Client($redis_array);
            $connection_status=TRUE;
        } catch (Exception $e) {
            echo $e->getMessage();
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
   
   public static function getValue($keyname){
       return $this->redis->get($keyname);              
   }
   
   public static function setValue($keyname,$value){
       return $this->redis->set($keyname,$value);              
   }
}

?>


