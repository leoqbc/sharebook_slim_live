<?php

require __DIR__ . '/../vendor/autoload.php';

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

use Slim\Factory\AppFactory;

use CarApp\DependencyInjection\Container;
use CarApp\Controllers\CarController;

$container = new Container();
$container->set(CarController::class, function (Container $container) {
    return new CarController($container->get(\PDO::class));
});

$container->set(\PDO::class, function () {
    $pdo = new \PDO(dsn: 'mysql:host=127.0.0.1;dbname=carapp;port=3300', username: 'root', password: 123456);
    $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    return $pdo;
});

AppFactory::setContainer($container);
$app = AppFactory::create();

$app->addRoutingMiddleware();
$app->addBodyParsingMiddleware();

$app->addErrorMiddleware(true, true, true);

$app->post('/cars', [CarController::class, 'create']);
$app->get('/cars', [CarController::class, 'all']);

$app->options('/{routes:.+}', function ($request, $response) {
    return $response;
});

$app->add(function (ServerRequestInterface $request, RequestHandlerInterface $requestHandler) {
    $response = $requestHandler->handle($request);
    return $response
                ->withHeader('Access-Control-Allow-Origin', '*')
                ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
                ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
});

$app->run();