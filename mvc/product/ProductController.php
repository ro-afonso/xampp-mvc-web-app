<?php
namespace mvc\product;

use \backend\library\Controller;
use \backend\library\RequestOperation;
use \backend\library\RequestResult;

use \mvc\product\ProductModel;
use \Exception;

class ProductController extends Controller
{
    function __construct()
    {

    }

    // http://localhost/app.php?service=selectPeople
    function selectAll()
    {
        // we could define functions like selectProductCity, selectProduct
        $ProductModel = new ProductModel();
        $id          = @$_REQUEST["id"  ];
        $price        = @$_REQUEST["price"];
        $ProductModel->selectAll($id, $price)->toJsonEcho();
    }

    function showProductsAsTable() {
        $folder = __NAMESPACE__;
        include("./$folder/Views/showProductsAsTable.php");
    }

    // ProductController.php
    function insertFromView() {
        // perform some validation, like empty fields
        // or invalid values, ...
        $msgError = "Error:";
        $hasError = false;
        if(empty( @$_REQUEST["name"]) ) {
            $msgError .= ' name not provided.';
            $hasError  = true;
        } else if(empty( @$_REQUEST["price"]) ) {
            $msgError .= ' price not provided.';
            $hasError  = true;
        } else if(empty( @$_REQUEST["description"]) ) {
            $msgError .= ' description not provided.';
            $hasError  = true;
        }else if(empty( @$_REQUEST["existingstock"]) ) {
            $msgError .= ' existingstock not provided.';
            $hasError  = true;
        }else if(empty( @$_REQUEST["totalsalesyear"]) ) {
            $msgError .= ' totalsalesyear not provided.';
            $hasError  = true;
        }
        
        else {
            $this->insert();  
        }
        if($hasError) {
            RequestResult::requestERROR(RequestOperation::INSERT, $msgError)->toJsonEcho();
        }
    }

    // ProductController.php
    function insert() {        
        $requestData = array(
            "name"              => @$_REQUEST["name"],
            "price"             => @$_REQUEST["price"],
            "description"       => @$_REQUEST["description"],
            "existingstock"     => @$_REQUEST["existingstock"],
            "totalsalesyear"    => @$_REQUEST["totalsalesyear"] 
        );
        $ProductModel = new ProductModel();
        $ProductModel->insert($requestData)->toJsonEcho();
    }

    /* // ProductController.php
    function showProductForm($mode, $id) {
        $_GET['MODE']=$mode;
        $_GET['id']  = $id;
        $folder = __NAMESPACE__;
        include("./$folder/views/showProductForm.php"); //MODE: INSERT, UPDATE, SEE
    } */

    // ProductController.php
    function showProductForm($mode, $id) {  //ADD MODE & id to parameters
        $_GET['MODE']=$mode;
        $_GET['id']  = $id;
        $folder = __NAMESPACE__;
        include("./$folder/Views/showProductForm.php"); //ADD MODE: INSERT, UPDATE, SEE
    }

    //ProductController.php
    function select($id)
    {
        // we could define functions like selectProductCity, selectProduct
        $ProductModel = new ProductModel();  
        $ProductModel->select($id)->toJsonEcho();
    }

    // ProductController.php   
    // localhost/app.php?service=update&id=1&address=Rua das Camelias, 35&postalcode=4650-123
    function update()  {
        $requestData = array(
            "id"                => @$_REQUEST["id"],
            "name"              => @$_REQUEST["name"],
            "price"             => @$_REQUEST["price"],
            "description"       => @$_REQUEST["description"],
            "existingstock"     => @$_REQUEST["existingstock"],
            "totalsalesyear"    => @$_REQUEST["totalsalesyear"]
        );
        $ProductModel = new ProductModel();
        $ProductModel->update($requestData)->toJsonEcho();
    }

    // ProductController.php
    function delete($id)  {
        $ProductModel = new ProductModel();
        $ProductModel->delete($id)->toJsonEcho();
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
