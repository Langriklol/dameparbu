<?php
/**
 * Created by PhpStorm.
 * User: Ondřej
 * Date: 24.06.2016
 * Time: 22:21
 */
//Start sessions - important for using sessions
session_start();
//Sets encoding to UTF-8
mb_internal_encoding("UTF-8");
//register autoloadFunction as autoload fce
spl_autoload_register("autoloadFunction");
//Autoloader function
function autoloadFunction($class)
{
    // If end name of the class with string "Controller"
    if (preg_match('/Controller$/', $class))
        require("controllers/" . $class . ".php");
    else
        require("models/" . $class . ".php");
}
//Connect to Database
Db::connect("81.2.194.102","f73030","JLfU2Qv","f73030");
// new obj of router
$router = new RouterController();
// Router call treat method with parameter of array with URI
$router->treat(array($_SERVER['REQUEST_URI']));
// Router call extractView method, that extract View to the page
$router->extractView();
