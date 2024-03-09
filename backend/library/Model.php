<?php

namespace backend\library;

use backend\library\PDOConnection;

class Model {
    static private $_pdoConnection = null; 

    final public static function getPdoConnection(){
        if(null !== static::$_pdoConnection){
            return static::$_pdoConnection;
        }
        static::$_pdoConnection =  new PDOConnection("localhost", "3306", "sim_webapp");
        return static::$_pdoConnection;
    }
}