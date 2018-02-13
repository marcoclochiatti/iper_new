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

?>