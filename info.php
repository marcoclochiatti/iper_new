<?php
//phpinfo();
require "www/include/thirdparty/predis/autoload.php";

$host       = '127.0.0.1'; //or localhost
$database   = 'iper';
$port       = 3306;
$user       = 'root';
$password   = '';

try {
    $connection  = new \PDO("mysql:host=".$host .";port=" .$port ."dbname=".$dbname, $dbusr, $dbpass);
//    $this->connection = new PDO($database . ":host=" . $host . ';port=' . $port, $user, $password);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $connection;
} catch (PDOException $e) {
    echo $e->getMessage();
}


Predis\Autoloader::register();

try{
$redis = new Predis\Client(array(
    "scheme" => "tcp",
    "host" => "localhost",
    "port" => 6379,
//    "password" => ""
    ));
//echo "Connected to Redis";
$value = $redis->get("pippo");
echo $value;
} catch (Exception $e) {
            echo $e->getMessage();
        }      
phpinfo();        
?>

