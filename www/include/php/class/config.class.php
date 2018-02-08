<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Dbconfig {
    protected $serverName;
    protected $userName;
    protected $passCode;
    protected $dbName;

    function Dbconfig() {
        $this -> serverName = $GLOBALS['DB_SERVERN'];
        $this -> userName = $GLOBALS['DB_USER'];
        $this -> passCode = $GLOBALS['DB_PASS'];
        $this -> dbName = $GLOBALS['NAMEDB'];
    }
    
    
}
