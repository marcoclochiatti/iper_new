<?php

require_once "www/config/ConfigException.php";

/**
*   final class Config
*
*   Classe utilizzata internamente da Configurable ed assegnata
*   alla proprietà pubblica Configurable::$config.
*   Rappresenta il punto di comunicazione tra il codice scritto da
*   chi utilizza il framework e la cache interna di Configurable.
*/
final class Config
{
    private $data;
    
    /**
    *   __construct(array $data)
    *
    *   $data:  array contenente le coppie chiave/valore che
    *           rappresentano le opzioni di configurazione applicabili
    *           all'oggetto interrogato.
    */
    public function __construct($data)
    {
        $this->data = $data;
    }
    
    /**
    *   string __get(string $key)
    *
    *   Overload dell'operatore -> per l'accesso alle proprietà.
    *   Restituisce il valore dell'opzione specificata da $key oppure
    *   genera un'eccezione nel caso questa non sia un'opzione valida.
    */
    public function __get($key)
    {
        if(array_key_exists($key, $this->data))
            return $this->data[$key];
        
        throw new ConfigException("Property ".$key." not defined");
    }
    
    /**
    *   mixed get(string $key [, mixed $default])
    *
    *   Restituisce il valore dell'opzione specificata da $key oppure
    *   genera un'eccezione nel caso questa non sia un'opzione valida.
    *   Nel caso in cui sia specificato un valore alternativo di default
    *   l'eccezione viene bloccata e viene restituito $default.
    */
    public function get($key)
    {
        try
        {
            return $this->{$key};
        }catch(ConfigException $e)
        {
            if(func_num_args() == 2)
                return func_get_arg(1);
            
            throw $e;
        }
    }
}

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/*
session_start();
$sHttp = (!empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on') ? 'https://' : 'http://';
$sDomain = ($_SERVER['SERVER_PORT'] != '80' && $_SERVER['SERVER_PORT'] != '443') ? $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] : $_SERVER['SERVER_NAME'];
$sPhp_self = str_replace('\\', '', dirname(htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES))); // Remove backslashes for Windows compatibility
$tmp = explode('/',$sPhp_self);
$a = array_pop($tmp);
$_SESSION['ROOT_URL'] = $sHttp . $sDomain .implode('/',$tmp) .'/';
$_SESSION['ROOT_PATH'] = $_SERVER['DOCUMENT_ROOT'] .implode('/',$tmp) .'/';
include_once 'www/include/php/class/db.class.php';
$dbiper = new Database();

$tmp = $dbiper->ApiGetAllPath();
foreach($tmp as $t){
    $_SESSION[$t[0]] = $t[1];
}
 * 
 * *
 */
