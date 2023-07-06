<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/vendor/autoload.php';
use src\RepositoriesReviews;

$app = AppFactory::create();
$RepositoriesReviews = new RepositoriesReviews("C:\\sqlite\\main.db");


$app->get('/', function (Request $request, Response $response, $args) {
    print_r('qweqwe');
});

$app->run();
