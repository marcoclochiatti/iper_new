<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include_once 'www/config/Configurable.php';
require_once "www/include/thirdparty/predis/autoload.php";

class ModelEngineBase extends Configurable
{
    private static $instance = null;
    public $connection_status = FALSE;
    private function __construct(){
        $dbname = Configurable::queryConfiguration('db','dbname');
        $dbusr = Configurable::queryConfiguration('db','db_usr');
        $dbpass = Configurable::queryConfiguration('db','db_pass');
        $dbhost = Configurable::queryConfiguration('db','db_server');
        $dbport = Configurable::queryConfiguration('db','db_port');
        try {
            $this->_connection  = new \PDO("mysql:host=".$dbhost .";port=" .$dbport .";dbname=".$dbname , $dbusr, $dbpass);            
            $this->_connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connection_status = TRUE;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }       
    }     
    public static function getInstance(){
        if(self::$instance == null){   
            $c = __CLASS__;
            self::$instance = new $c;
        }      
        return self::$instance;
    }
}
    
    
class ModelEngine extends ModelEngineBase{
    
    public function __construct(){
        $this->_connection = ModelEngineBase::getInstance();
        
    }

    private  function Select($sql,$value){
        $result = array();
        if($this->_connection->connection_status){
            try{      
                $sql_obj = $this->_connection->_connection->prepare($sql);
                if($value)
                    $sql_obj->execute($value);
                else
                    $sql_obj->execute();
                $result = $sql_obj->fetchAll();                               
            }
            catch (PDOException $ex) {
                $r = $ex->getMessage();                
                echo $ex->getMessage();                
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
            $statemant = $this->_connection->_connection->prepare($sql); 
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
            $statemant = $this->_connection->_connection->prepare($sql); 
            $statemant->execute($value);
            return TRUE;
        } catch (PDOException $ex) {
            echo $e->getMessage();
            return FALSE;
        } 
    }
  
    public  function querySelect($sql, $values){        
        $result = $this->Select($sql,$values);
        return $result;                
    }
     
    public  function queryInsert($tablename, $array_columns_and_values,$user){
        return $this->insertInto($tablename, $array_columns_and_values, $user);
    }
       
    public  function queryUpdate($tablename, $setcolumn, $setoperator, $setvalue, $operator, $value, $column, $user){
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
                             'port'=>Configurable::queryConfiguration('nosql','port'),
                             'database'=>1
                            );

        $p = Configurable::queryConfiguration('nosql','pass');
        if($p!=''){
            $redis_array['password'] = $p;
        }
        try {
            $this->redis = new Predis\Client($redis_array);
            $this->connection_status=TRUE;
        } catch (Exception $e) {
            $this->connection_status=FALSE;
//            echo $e->getMessage();
        }       
    }   
    public static function getInstance(){
        if(self::$instance == null){   
            $c = __CLASS__;
            self::$instance = new $c;
        }
      
        return self::$instance;
    }
   
    public function getValue($keyname){
        $c = ModelEngineMem::getInstance();
        if ($c->connection_status){
            if($c->redis->exists($keyname)){
                $result = $c->redis->get($keyname);              
            }else{
                $result = NULL;
            }
        }else{
            $result = NULL;
        }
        return $result;
    }
   
    public function setValue($keyname,$value){
        $c = ModelEngineMem::getInstance();
        if ($c->connection_status){
            $c->redis->set($keyname,$value);  
            $c->redis->expire($keyname, 86400);
            $result = TRUE;
        }else{
            $result = FALSE;
        }
        return $result;
   }
}

?>


