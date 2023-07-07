<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Psr7\Response as Psr7Response;
use src\RepositoriesReviews;

require 'config.php';
require __DIR__ . '/vendor/autoload.php';


$app = AppFactory::create();
$RepositoriesReviews = new RepositoriesReviews("$path");

$basicAuthMiddleware = function (Request $request, RequestHandlerInterface $handler) use ($validUsers) {
    $response = new Psr7Response();

// Проверяем наличие заголовка Authorization в запросе
    $authHeader = $request->getHeaderLine('Authorization');
    if (empty($authHeader) || !preg_match('/Basic (.+)/', $authHeader, $matches)) {
        $response->getBody()->write('Authorization required');
        return $response->withStatus(401)->withHeader('WWW-Authenticate', 'Basic realm="My Realm"');
    }

// Декодируем имя пользователя и пароль из заголовка Authorization
    list($username, $password) = explode(':', base64_decode($matches[1]));

// Проверяем соответствие учетных данных
    if (!isset($validUsers[$username]) || $validUsers[$username] !== $password) {
        $response->getBody()->write('Invalid credentials');
        return $response->withStatus(403);
    }

// Пользователь аутентифицирован, передаем запрос обработчику маршрута
    return $handler->handle($request);
};

$app->get('/', function (Request $request, Response $response, $args) {
    $response->getBody()->write("Hello world!");
    return $response;
});



$app->get('/api/feedbacks', function (Request $request, Response $response, $args) use ($RepositoriesReviews) {
    $data = $request->getQueryParams();
    $page = $data['page'];
    $perPage = 20;
    $reviews = $RepositoriesReviews->getReviewsByPage($page, $perPage);
    $response->getBody()->write(json_encode($reviews));
    return $response;

});

$app->get('/api/feedbacks/addReview',function (Request $request, Response $response) use ($RepositoriesReviews){
    $text = 'Все окей';
    $result = $RepositoriesReviews->addReview($text);

    if(isset($result['error'])){
        $response->getBody()->write("Что-то не так");
    }
    else{$response->getBody()->write("Добавлено");}

    return $response;
});

$app->get('/api/feedbacks/delete/{id}',function (Request $request, Response $response,$args) use ($RepositoriesReviews){
    $id = $args['id'];
    $RepositoriesReviews->deleteReviewById($id);
    $response->getBody()->write("Удалено");
    return $response;
})->add($basicAuthMiddleware);
$app->get('/api/feedbacks/{id}', function (Request $request, Response $response, $args) use ($RepositoriesReviews) {
    $id = $args['id'];
    $review = $RepositoriesReviews->SearchReview($id);
    $response->getBody()->write(json_encode($review));
    return $response;
});
$app->run();
