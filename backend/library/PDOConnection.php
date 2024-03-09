<?php 
namespace backend\library;

use \PDO;
use \Exception;

class PDOConnection extends PDO
{
    // these settings are usually stored in an settings.ini file
    public function __construct($host="localhost",$port="3306", $dbName="sim_webapp")
    {
        $dns = "mysql:host=$host;port=$port;dbname=$dbName";
        parent::__construct($dns, 'root', 'sim');
        $this ->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );  
    }
}