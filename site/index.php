<?php


use Phalcon\Mvc\Micro;
use Phalcon\Http\Response;
use Phalcon\Http\Request;



require __DIR__ . "/app/config/config.php";
require __DIR__ . "/app/config/services.php";

$request = new Request();
$response = new \Phalcon\Http\Response();

$app = new Micro($di);

$app->get('/', function () use ($app) {


    echo $app['view']->render('index');
});



$app->notFound(function () use ($app) {
    echo $app['view']->render('404');
});
$app->error(function () use ($app) {
    echo $app['view']->render('500');
});
$app->handle();