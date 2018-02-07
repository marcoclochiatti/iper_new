<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include 'config.class.php';

class Db extends Dbconfig
{
    private $_connection;
    private static $_instance; //The single instance
    private $_host;
    private $_username;
    private $_password;
    private $_database;
    /*
    Get an instance of the Database
    @return Instance
    */
    public static function getInstance()
    {
        if (!self::$_instance) { // If no instance then make one
            self::$_instance = new self();
        }
        return self::$_instance;
    }
    // Constructor
    private function __construct()
    {
        $dbPara = new Dbconfig();
        $this ->_database = $dbPara -> dbName;
        $this ->_host = $dbPara -> serverName;
        $this ->_username = $dbPara -> userName;
        $this ->_password = $dbPara ->passCode;
        $dbPara = NULL;
        try {
            $this->_connection  = new \PDO("mysql:host=$this->_host;dbname=$this->_database", $this->_username, $this->_password);
            /*** echo a message saying we have connected ***/            
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    // Magic method clone is empty to prevent duplication of connection
    private function __clone()
    {
    }
    // Get mysql pdo connection
    public function getConnection()
    {
        return $this->_connection;
    }
}



Class Database{
    public function __construct() {
        $db = Db::getInstance();
        $this->_dbh = $db->getConnection();
    }
    
    
    public function selectAll($tableName)  {
        $result = array();
        try{            
            $sql = 'SELECT * FROM ' .$tableName;            
            foreach ($this->_dbh->query($sql) as $row) {
                $result[] = $row;
            }
            return $result;
        } catch (PDOException $ex) {
            echo $e->getMessage();
            return $result;
        }       
    }
    
    public function selectWhere($tableName,$rowName,$operator,$value,$valueType){
        $result = array();
        try{
            $sql = 'SELECT * FROM '.$tableName.' WHERE '.$rowName.' '.$operator.' ';
            if($valueType == 'int') {
                $sql .= $value;
            }else if($valueType == 'char'){
                $sql .= "'".$value."'";
            }
            foreach ($this->_dbh->query($sql) as $row) {
                $result[] = $row;
            }
            return $resut;
        } catch (PDOException $ex) {
            echo $e->getMessage();
            return $result;
        }
    }
    
    public function insertInto($tableName,$values) {
        $i = NULL;
        try{
            $columns = array();
            $vals = array();
            foreach($values as $key=>$val){
                $columns[] = $key;
                $vals[] = $val;
            }
            
            $sql = "INSERT INTO ".$tableName." (" .implode(',',$columns) .") VALUES ('" ;
            $to_add = array();
            foreach($vals as $val){
               $to_add[] = '?';
            }
            $sql .= implode(', ', $to_add) .")";   
            $statemant = $this->_dbh->prepare($sql); 
            $statemant->execute($vals);
            return TRUE;
        } catch (PDOException $ex) {
            echo $e->getMessage();
            return FALSE;
        }        
    }
    
    public function updateTable($tablename, $setcolumn, $setoperator, $setvalue, $operator, $value, $column){
        try{
            $sql = "UPDATE " .$tablename ." SET ";
            $tmp = array();
            for($i=1; $i<=count($setcolumn); $i++){
                $tmp[] = $setcolumn[i] ." " .$setoperator[i] ." '" .$setvalue[i] ."'";
            }
            $sql .= implode(', ', $tmp);
            $sql .= " WHERE";
            $tmp = array();
            for($i=1; $i<=count($column); $i++){
                $tmp[] = $column[i] ." " .$operator[i] ." ?";
            }
            $sql .= implode('AND ', $tmp);
            $statemant = $this->_dbh->prepare($sql); 
            $statemant->execute($value);
            return TRUE;
        } catch (PDOException $ex) {
            echo $e->getMessage();
            return FALSE;
        } 
    }
    
    
    public function selectFreeRun($sql){
        $result = array();
        try{
            foreach ($this->_dbh->query($sql) as $row) {
                $result[] = $row;
            }
        } catch (PDOException $ex) {
            echo $e->getMessage();
            return $result;
        }
    }
    
    public function freeRun($sql){
        try{
            $statemant = $this->_dbh->prepare($sql); 
            $statemant->execute();
        } catch (PDOException $ex) {
            echo $e->getMessage();
            return $result;
        }                
    }

}
