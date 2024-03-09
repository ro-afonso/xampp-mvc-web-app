<?php

namespace backend\library;

use backend\library\RequestResult;

class Route
{
    // & meains passing by reference (it is like a pointer in C language)
    static public function makeRoute(array &$routes)
    {
        // get the service from the request
        if (isset($_REQUEST["service"])) {
            $service    = @$_REQUEST["service"];
            $controller = @$routes[$service];

            if($controller == null) {
                $msg = "You must add the service <strong>$service</strong> to the route table inside app.php"; 
                $controller = function () use ($msg) {
                    RequestResult::requestERROR(RequestOperation::ROUTE, $msg)->toJsonEcho();
                };
            }
        } else {
            $controller = function () {
                $msg = "You must request a service that is specified inside the routes table, as <strong>app.php?service=someService</strong>";
                RequestResult::requestERROR(RequestOperation::ROUTE, $msg)->toJsonEcho();
            };
        }
        return $controller;
    }
}
