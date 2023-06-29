<?php

namespace CarApp\Controllers;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class CarController
{
    public function __construct(
        protected \PDO $pdo
    ) {
    }

    public function create(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $response->getBody()->write(json_encode([
            'hello' => 'hello'
        ]));
        return $response
                    ->withHeader('Content-Type', 'application/json')
                    ->withStatus(202);
    }

    public function all(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $statement = $this->pdo->prepare('SELECT * FROM cars');
        $statement->execute();
        $cars = $statement->fetchAll(\PDO::FETCH_OBJ);

        $response->getBody()->write(json_encode($cars));

        return $response
                ->withHeader('Content-Type', 'application/json');
    }
}