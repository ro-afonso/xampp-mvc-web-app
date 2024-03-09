<?php
require(__DIR__ . '/vendor/autoload.php');

@session_start();


$routes["say_hello"] = function() {  echo '<H1>Hello World.</H1>';  };
$routes["test_request_result"] = function() {  
    \backend\library\RequestResult::requestGENERIC(\backend\library\RequestOperation::ROUTE, "SUCCESS", "Demo Request Result")->toJsonEcho();  
 };

 $routes["selectAllPeople"] =  function() {  (new mvc\Person\PersonController())->selectAll();    };

 $routes["selectAllProducts"] =  function() {  (new mvc\Product\ProductController())->selectAll();    };

 $routes["showPeopleAsTable"] = function() {  (new mvc\Person\PersonController())->showPeopleAsTable();       };
 
 $routes["showPersonForm"] = function() {  
    (new mvc\Person\PersonController())->showPersonForm( @$_REQUEST["MODE"], @$_REQUEST["id"]);  
};

$routes["showProductForm"] = function() {
    (new mvc\Product\ProductController())->showProductForm(@$_REQUEST["MODE"], @$_REQUEST["id"]);   //adapt to REQUEST MODE & id
};

$routes["insertPersonFromView"]  = function() {  (new mvc\Person\PersonController())->insertFromView();      };

$routes["insertProductFromView"]  = function() {  (new mvc\Product\ProductController())->insertFromView();      };

$routes["showLayout"]     =  function() {  (new backend\library\LayoutController())->showLayout("./public/layouts/main_layout.php");};

$routes["selectPerson"]   = function() {  (new mvc\Person\PersonController())->select(@$_REQUEST['id']); };

$routes["updatePerson"] = function() {  (new mvc\Person\PersonController())->update(); };

$routes["deletePerson"] = function() {  (new mvc\Person\PersonController())->delete(@$_REQUEST['id']); };     

$routes["playVideo"] = function() {  (new mvc\Person\PersonController())->playVideo(@$_REQUEST['id']); };

$routes["selectProduct"]   = function() {  (new mvc\Product\ProductController())->select(@$_REQUEST['id']); };

$routes["updateProduct"] = function() {  (new mvc\Product\ProductController())->update(); };

$routes["deleteProduct"] = function() {  (new mvc\Product\ProductController())->delete(@$_REQUEST['id']); };     

$routes["showProductsAsTable"] = function() { (new mvc\Product\ProductController())->showProductsAsTable(); }; //adapt to ProductController
 //END OF ROUTES

// get the controller
$controller = backend\library\Route::makeRoute($routes);

// call the service
$controller();
