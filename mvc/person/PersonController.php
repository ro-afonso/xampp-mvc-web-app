<?php
namespace mvc\person;

use \backend\library\Controller;
use \backend\library\RequestOperation;
use \backend\library\RequestResult;

use \mvc\person\PersonModel;
use \Exception;

class PersonController extends Controller
{
    function __construct()
    {

    }

    // http://localhost/app.php?service=selectPeople
    function selectAll()
    {
        // we could define functions like selectPersonCity, selectPerson
        $personModel = new PersonModel();
        $id          = @$_REQUEST["id"  ];
        $city        = @$_REQUEST["city"];    
        $personModel->selectAll($id, $city)->toJsonEcho();
    }

    // PersonController
    function showPeopleAsTable() {
        $folder = __NAMESPACE__;
        include("./$folder/Views/showPeopleAsTable.php");
    }

    // PersonController.php
    function insertFromView() {
        // perform some validation, like empty fields
        // or invalid values, ...
        $msgError = "Error:";
        $hasError = false;
        if(empty( @$_REQUEST["name"]) ) {
            $msgError .= ' name not provided.';
            $hasError  = true;
        } else if(empty( @$_REQUEST["address"]) ) {
            $msgError .= ' address not provided.';
            $hasError  = true;
        } else if(empty( @$_REQUEST["city"]) ) {
            $msgError .= ' city not provided.';
            $hasError  = true;
        }else if(empty( @$_REQUEST["postalcode"]) ) {
            $msgError .= ' postalcode not provided.';
            $hasError  = true;
        }else if(!is_numeric( @$_REQUEST["postalcode"]) ) {
            $msgError .= ' postalcode must be a number.';
            $hasError  = true;
        }
        
        else {
            $this->insert();  
        }
        if($hasError) {
            RequestResult::requestERROR(RequestOperation::INSERT, $msgError)->toJsonEcho();
        }
    }

    // PersonController.php
    function insert() {        
        $requestData = array(
            "name"       => @$_REQUEST["name"],
            "address"    => @$_REQUEST["address"],
            "city"       => @$_REQUEST["city"],
            "postalcode" => @$_REQUEST["postalcode"] 
        );
        $personModel = new PersonModel();
        $personModel->insert($requestData)->toJsonEcho();
    }

    // PersonController.php
    function showPersonForm($mode, $id) {
        $_GET['MODE']=$mode;
        $_GET['id']  = $id;
        $folder = __NAMESPACE__;
        include("./$folder/views/showPersonForm.php"); //MODE: INSERT, UPDATE, SEE
    }

    //PersonController.php
    function select($id)
    {
        // we could define functions like selectPersonCity, selectPerson
        $personModel = new PersonModel();  
        $personModel->select($id)->toJsonEcho();
    }

    // PersonController.php   
    // localhost/app.php?service=update&id=1&address=Rua das Camelias, 35&postalcode=4650-123
    function update()  {
        $requestData = array(
            "id"         => @$_REQUEST["id"],
            "name"       => @$_REQUEST["name"],
            "address"    => @$_REQUEST["address"],
            "city"       => @$_REQUEST["city"],
            "postalcode" => @$_REQUEST["postalcode"] 
        );
        $personModel = new PersonModel();
        $personModel->update($requestData)->toJsonEcho();
    }

    // PersonController.php
    function delete($id)  {
        $personModel = new PersonModel();
        $personModel->delete($id)->toJsonEcho();
    }

    function playVideo() {
        $arraMusic =[
            '<iframe width="560" height="315" src="https://www.youtube.com/embed/jh4C7w-dvho" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>',
            '<iframe width="560" height="315" src="https://www.youtube.com/embed/ZtmIokzkeyA" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>',
            '<iframe width="560" height="315" src="https://www.youtube.com/embed/WKuaujIHBT4" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>'
        ];
        $size = count($arraMusic);
        $music = rand(0, $size-1);
        echo $arraMusic[$music]; 
    }

}