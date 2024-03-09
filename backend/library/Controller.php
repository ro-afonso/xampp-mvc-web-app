<?php

namespace backend\library;

use backend\library\PDOConnection;

abstract class Controller {
    static private $_defaultModel = null; 

    final public static function getDefaultModel(){
        if(null !== static::$_defaultModel){
            return static::$_defaultModel;
        }
        static::$_defaultModel =  new Model();
        return static::$_defaultModel;
    }
}