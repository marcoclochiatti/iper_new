<?php
require_once 'www/config/Config.php';
require_once 'www/config/ConfigException.php';
require_once 'www/config/DummyConfigurable.php';

/**
*   abstract class Configurable
*
*   Classe astratta che rende un oggetto configurabile attraverso
*   delle opzioni specificate in un file di testo.
*   Il file di testo, recuperato attraverso la costante CONFIGURATION_FILE,
*   viene parsato una sola volta ed il risultato del parsing è salvato
*   in memoria all'interno della variabile statica Configurable::$configuration.
*   Ad ogni oggetto che estende Configurable vengono assegnate le opzioni specificate
*   in seguito alla sezione che indica il nome della classe dell'oggetto stesso o di
*   una delle sue superclassi. Una sezione è delimitata dal nome di un oggetto
*   racchiuso tra parentesi quadre ed il nome di un'altra sezione.
*/
abstract class Configurable
{
    public $config;
    private $sections;
    private static $configuration = null;
    
    /**
    *   __construct()
    *
    *   Il costruttore salva in memoria le sezioni alle quali l'oggetto corrente
    *   può accedere, cerca di caricare il file di configurazione se non è già
    *   stato fatto, ed infine crea un oggetto Config che assegna alla proprietà
    *   pubblica Configurable::$config.
    */
    public function __construct()
    {
        $this->sections = array();
        $this->config = null;
        
        $class = get_class($this);
        $this->sections[] = $class;
        
        while($class = get_parent_class($class))
            $this->sections[] = $class;
        
        $this->loadConfiguration();
        $this->cacheConfig();
    }
    
    /**
    *   void loadConfigudation()
    *
    *   Carica in memoria il contenuto del file indentificato dalla costante
    *   CONFIGURATION_FILE, all'interno della variabile Configurable::$configuration.
    *   Se la variabile è già stata assegnata il file non viene più analizzato.
    */
    private function loadConfiguration()
    {
        if(!is_null(self::$configuration))
            return;
        
        self::$configuration = array();
        
        if(!defined('CONFIGURATION_FILE'))
            define('CONFIGURATION_FILE', realpath(dirname(__FILE__)."/../static/config.conf"));
        
        $section = "Default";
        foreach(file(CONFIGURATION_FILE) as $line)
        {
            $line = trim($line);
            
            switch(true)
            {
                case strlen($line) == 0 || $line{0} == '#':
                    continue;
                
                case preg_match("/^\[([a-zA-Z_][a-zA-Z_0-9]*)\]$/", $line, $matches):
                    $section = $matches[1];
                break;
                
                case preg_match("/^([a-zA-Z_][a-zA-Z_0-9]*)\s*=\s*(.*)$/", $line, $matches):
                    $key = $matches[1];
                    $value = $matches[2];
                    
                    if(!array_key_exists($section, self::$configuration))
                        self::$configuration[$section] = array();
                    
                    self::$configuration[$section][$key] = $value;
                break;
            }
        }
    }
    
    /**
    *   void cacheConfig()
    *
    *   Memorizza un'istanza della classe Config nella variabile pubblica
    *   Configurable::$config. L'istanza della classe Config può accedere
    *   alle opzioni di tutte le sezioni a cui ha accesso l'oggetto corrente.
    */
    private function cacheConfig()
    {
        if(!is_null($this->config))
            return;
        
        $data = array();
        foreach(array_reverse($this->sections) as $section)
        {
            if(array_key_exists($section, self::$configuration))
                $data = array_merge($data, self::$configuration[$section]);
        }
        
        $this->config = new Config($data);
    }
    
    /**
    *   mixed queryConfiguration(string $section, string $key [, mixed $default])
    *
    *   Metodo statico che interroga una sezione specifica senza l'esigenza
    *   di aver a disposizione un'istanza dei un oggetto a cui la sezione è
    *   associata.
    *   Restituisce il valore di $key per la sezione $section o genera un'eccezione
    *   ConfigException in caso non sia possibile recuperare il valore.
    *   Nel caso in cui venga specificato $default, l'eccezione non viene generata
    *   e viene restituito il valore definito nel terzo argomento.
    */
    public static function queryConfiguration($section, $key)
    {
        if(is_null(self::$configuration))
            $configurable = new DummyConfigurable();
        
        if(array_key_exists($section, self::$configuration))
            if(array_key_exists($key, self::$configuration[$section]))
                return self::$configuration[$section][$key];
        
        if(func_num_args() == 3)
            return func_get_arg(2);
        
        throw new ConfigException("Property ".$key." not defined");
    }
    
    public static function templateClass()
    {
        if(!is_null(self::$templates))
            return;
//        $class_path = self::queryConfiguration('smarty', 'class_path');
        $class_path = 'www/include/thirdparty/smarty/libs/Smarty.class.php';
        $template_dir = '';
        include_once $class_path;
        self::$templates = new Smarty();
        self::$templates->setTemplateDir($_SESSION['ROOT_URL'] .$_SESSION['smarty_templates']);
        self::$templates->setCompileDir($_SESSION['ROOT_URL'] .$_SESSION['smarty_templates_c']);
        self::$templates->setConfigDir($_SESSION['ROOT_URL'] .$_SESSION['smarty_configs']);
        self::$templates->setCacheDir($_SESSION['ROOT_URL'] .$_SESSION['smarty_cache']);
    }
}

