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

$app->get('/api/feedbacks/{id}', function (Request $request, Response $response, $args) use ($RepositoriesReviews) {
    $id = $args['id'];
    $review = $RepositoriesReviews->SearchReview($id);
    $response->getBody()->write(json_encode($review));
    return $response;
});

$app->get('/api/feedbacks/', function (Request $request, Response $response, $args) use ($RepositoriesReviews) {
    $data = $request->getQueryParams();
    $page = $data['page'];
    $perPage = 20;
    $reviews = $RepositoriesReviews->getReviewsByPage($page, $perPage);
    $response->getBody()->write(json_encode($reviews));
    return $response;

});

$app->run();
