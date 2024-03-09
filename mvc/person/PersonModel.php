<?php

namespace mvc\person;

use backend\library\Model;
use backend\library\RequestOperation;
use backend\library\RequestResult;
use PDO;
use Exception;

class PersonModel extends Model
{
    function selectAll($id=null, $city=null): RequestResult
    {
        try {
            $pdo = $this->getPdoConnection();
            $query_string = "Select id, name, address, city, postalcode from person where (1=1)  ";  // space is necessary 
            if (isset($id)) {
                $query_string  .=   "and ( id = {$id} ) ";
            }

            if (isset($city)) {
                $query_string  .=   "and ( city like '{$city}' ) ";
            }

            $statement = $pdo->query($query_string,  PDO::FETCH_ASSOC);

            return RequestResult::requestSUCCESS(RequestOperation::SELECT, $pdo, $statement, $query_string);
        } catch (Exception $e) {
            return RequestResult::requestERROR(RequestOperation::SELECT, "error: " . $e->getMessage());
        }
    }

    // PersonModel.php 
    function insert(array $dataArray ): RequestResult
    {
        try {
            
            $pdo = $this->getPdoConnection();

            // prepare and bind
            $query_string = "INSERT INTO person (name, address, city, postalcode) VALUES (:name, :address, :city, :postalcode)";
            $statement = $pdo->prepare($query_string);

            $statement->execute($dataArray);

            return RequestResult::requestSUCCESS(RequestOperation::INSERT, $pdo, $statement, $query_string);
        } catch (Exception $e) {
            return RequestResult::requestERROR(RequestOperation::INSERT, "error inserting a person: " . $e->getMessage() );            
        }
    }

    // personModel.php
    function select($id): RequestResult
    {
        try {
            $pdo = $this->getPdoConnection();
            $query_string = "Select id, name, address, city, postalcode from person where id={$id}";  // space is necessary 
            $statement = $pdo->query($query_string,  PDO::FETCH_ASSOC);

            return RequestResult::requestSUCCESS(RequestOperation::SELECT, $pdo, $statement, $query_string);
        } catch (Exception $e) {
            return RequestResult::requestERROR(RequestOperation::SELECT, "error: " . $e->getMessage() . 'query='. $query_string);
        }
    }

    // PersonModel.php
    function update(array $requestData) {
        try {
            
            if(!isset($requestData["id"])) {
                throw new Exception("The ID of the person was not specified"); 
            }
            $dataArray = [];
            $updateFields = "";
            $dataArray["id"] = $requestData["id"];
            foreach( ["name", "address","city","postalcode" ] as $field) {
                if(isset($requestData[$field])) { 
                    if($updateFields != "")  {
                        $updateFields .= ", ";
                    }
                    $updateFields .=  "{$field} = :{$field}";
                    $dataArray[$field]= $requestData[$field];
                }
            }
        
            if(strlen($updateFields)==0) {
                throw new Exception("No fields to update were specified");  
            }
            
            $query_string = "update person set " . $updateFields . " where id = :id";

            //echo $query_string;
            //die;
            //update person set address = :address, postalcode = :postalcode where id = :id
        
            $pdo = $this->getPdoConnection();
            $statement = $pdo->prepare($query_string);
            $statement->execute($dataArray);

            $requestResult = RequestResult::requestSUCCESS(RequestOperation::UPDATE, $pdo, $statement, "person updated with success");
            $requestResult->id = $dataArray["id"];
            return $requestResult;

        } catch (Exception $e) {
            //echo $e->getMessage();            
            return RequestResult::requestERROR(RequestOperation::UPDATE, "error updating a person: " . $e->getMessage() );            
        }
    }

    // PersonModel.php
    function delete($id) {
        try {
            
            if(!isset($id)) {
                throw new Exception("The ID of the person was not specified"); 
            }
            
            
            $query_string = "delete from person where id = :id";

        
            $pdo = $this->getPdoConnection();
            $statement = $pdo->prepare($query_string);
            $statement->execute(  [  "id" => $id  ]    );

            $requestResult = RequestResult::requestSUCCESS(RequestOperation::DELETE, $pdo, $statement, "person delete with success");
            $requestResult->id = $id;
            return $requestResult;
        } catch (Exception $e) {
            //echo $e->getMessage();            
            return RequestResult::requestERROR(RequestOperation::DELETE, "error updating a person: " . $e->getMessage() . " query = " . $query_string );            
        }
    }


}
