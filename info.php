<?php
//phpinfo();
require "www/include/thirdparty/predis/autoload.php";

Predis\Autoloader::register();

try{
$redis = new Predis\Client(array(
    "scheme" => "tcp",
    "host" => "localhost",
    "port" => 6379,
//    "password" => ""
    ));
//echo "Connected to Redis";

$value = $redis->set("pippo","pappa");
$value = $redis->get("pippo");
echo $value;
} catch (Exception $e) {
            echo $e->getMessage();
        }      
phpinfo();        
?>

