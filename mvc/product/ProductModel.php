<?php

namespace mvc\product;

use backend\library\Model;
use backend\library\RequestOperation;
use backend\library\RequestResult;
use PDO;
use Exception;

class ProductModel extends Model
{
    function selectAll($id=null, $city=null): RequestResult
    {
        try {
            $pdo = $this->getPdoConnection();
            $query_string = "Select id, name, price, description, existingstock, totalsalesyear from Product where (1=1)  ";  // space is necessary 
            if (isset($id)) {
                $query_string  .=   "and ( id = {$id} ) ";
            }

            if (isset($price)) {
                $query_string  .=   "and ( price like '{$price}' ) ";
            }

            $statement = $pdo->query($query_string,  PDO::FETCH_ASSOC);

            return RequestResult::requestSUCCESS(RequestOperation::SELECT, $pdo, $statement, $query_string);
        } catch (Exception $e) {
            return RequestResult::requestERROR(RequestOperation::SELECT, "error: " . $e->getMessage());
        }
    }

    // ProductModel.php 
    function insert(array $dataArray ): RequestResult
    {
        try {
            
            $pdo = $this->getPdoConnection();

            // prepare and bind
            $query_string = "INSERT INTO product (name, price, description, existingstock, totalsalesyear) VALUES (:name, :price, :description, :existingstock, :totalsalesyear)";
            $statement = $pdo->prepare($query_string);

            $statement->execute($dataArray);

            return RequestResult::requestSUCCESS(RequestOperation::INSERT, $pdo, $statement, $query_string);
        } catch (Exception $e) {
            return RequestResult::requestERROR(RequestOperation::INSERT, "error inserting a Product: " . $e->getMessage() );            
        }
    }

    // ProductModel.php
    function select($id): RequestResult
    {
        try {
            $pdo = $this->getPdoConnection();
            $query_string = "Select id, name, price, description, existingstock, totalsalesyear from product where id={$id}";  // space is necessary 
            $statement = $pdo->query($query_string,  PDO::FETCH_ASSOC);

            return RequestResult::requestSUCCESS(RequestOperation::SELECT, $pdo, $statement, $query_string);
        } catch (Exception $e) {
            return RequestResult::requestERROR(RequestOperation::SELECT, "error: " . $e->getMessage() . 'query='. $query_string);
        }
    }

    // ProductModel.php
    function update(array $requestData) {
        try {
            
            if(!isset($requestData["id"])) {
                throw new Exception("The ID of the Product was not specified"); 
            }
            $dataArray = [];
            $updateFields = "";
            $dataArray["id"] = $requestData["id"];
            foreach( ["name", "price", "description", "existingstock", "totalsalesyear" ] as $field) {
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
            
            $query_string = "update product set " . $updateFields . " where id = :id";

            //echo $query_string;
            //die;
            //update Product set address = :address, postalcode = :postalcode where id = :id
        
            $pdo = $this->getPdoConnection();
            $statement = $pdo->prepare($query_string);
            $statement->execute($dataArray);

            $requestResult = RequestResult::requestSUCCESS(RequestOperation::UPDATE, $pdo, $statement, "Product updated with success");
            $requestResult->id = $dataArray["id"];
            return $requestResult;

        } catch (Exception $e) {
            //echo $e->getMessage();            
            return RequestResult::requestERROR(RequestOperation::UPDATE, "error updating a Product: " . $e->getMessage() );            
        }
    }

    // ProductModel.php
    function delete($id) {
        try {
            
            if(!isset($id)) {
                throw new Exception("The ID of the Product was not specified"); 
            }
            
            
            $query_string = "delete from product where id = :id";

        
            $pdo = $this->getPdoConnection();
            $statement = $pdo->prepare($query_string);
            $statement->execute(  [  "id" => $id  ]    );

            $requestResult = RequestResult::requestSUCCESS(RequestOperation::DELETE, $pdo, $statement, "Product delete with success");
            $requestResult->id = $id;
            return $requestResult;
        } catch (Exception $e) {
            //echo $e->getMessage();            
            return RequestResult::requestERROR(RequestOperation::DELETE, "error updating a Product: " . $e->getMessage() . " query = " . $query_string );            
        }
    }

}
