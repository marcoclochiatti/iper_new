<?php

require_once 'www/config/Configurable.php';

/**
*   class DummyConfigurable
*
*   Implementazione della classe astratta Configurable che viene
*   utilizzata internamente dal metodo Configurable::queryConfiguration
*   per eseguire il caricamento della configurazione in memoria anche
*   se nessuna istanza di Configurable è stata ancora creata.
*/
class DummyConfigurable extends Configurable {}

?>