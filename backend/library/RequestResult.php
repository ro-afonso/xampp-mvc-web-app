<?php

namespace backend\library;

use backend\library\PDOConnection;
use PDOStatement;


enum RequestOperation: string {
    case  SUCCESS =  "SUCCESS";
    case  ERROR   =  "ERROR";
    case  SELECT  =  "SELECT";
    case  UPDATE  =  "UPDATE";
    case  DELETE  =  "DELETE";
    case  INSERT  =  "INSERT";
    case  ROUTE   =  "ROUTE";    
}

class RequestResult {

    public $operation;
    public $result     = "nil";
    public $id         = "-1";
    public $rowCount   = "-1";
    public $data       =  array(); 
    public $msg        = "nil";
    public $resultTypes= [];  
    
    function __construct()
    {
        $this->resultTypes = [
            "SUCCESS" => "SUCCESS",
            "ERROR" => "ERROR"
        ];
    }

    static function requestSUCCESS(RequestOperation $operation, PDOConnection $pdoConnection, PDOStatement $statement, String $msg)  {
        
        $sqlResult = new RequestResult();
        $sqlResult->operation = $operation;
        $sqlResult->result    = "SUCCESS";
        $sqlResult->id        = $pdoConnection->lastInsertId();
        $sqlResult->rowCount  = $statement->rowCount();
        $sqlResult->data      = $statement->fetchAll();         
        $sqlResult->msg       = $msg;
        return $sqlResult;
    }

    static function requestERROR(RequestOperation $operation, String $errorSmg)  {
        $sqlResult = new RequestResult();
        $sqlResult->operation    = $operation;
        $sqlResult->result       = "ERROR";
        $sqlResult->msg          = $errorSmg;
        return $sqlResult;
    }

    static function requestGENERIC(RequestOperation $operation, $result, String $msg)  {
        $sqlResult = new RequestResult();
        $sqlResult->operation    = $operation;
        $sqlResult->result       = $result;
        $sqlResult->msg          = $msg;
        return $sqlResult;
    }


    function toJsonEcho() {
        // to avoid having  RequestOperation inside JSON
        $this->operation  = '' . $this->operation->value;                
        header('Content-Type: application/json; charset=iso-8859-1');        
        echo json_encode($this);
    }

    function toJson() {
        // to avoid having  RequestOperation inside JSON
        $this->operation  = '' . $this->operation->value;                
        
        return json_encode($this);
    }
    
}



// RequestResult::requestGENERIC(RequestOperation::ROUTE, "SUCCESS", "Demo Request Result")->toJsonEcho();