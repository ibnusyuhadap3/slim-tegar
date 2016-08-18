<?php

require_once __DIR__ . '/vendor/autoload.php';

// call Slim Tegar
$path = __DIR__ . "/config";
$app = new IS\Slim\Tegar\App($path);

// register route based on Closure
$app->get("/", function($response){
    $response->write("Welcome to Slim!");
    return $response;
});

// register route based on Controller
// the pattern example: "ContohController@method"
$app->get("/contoh", "App\Controllers\ContohController@index");

// run Slim
$app->run();