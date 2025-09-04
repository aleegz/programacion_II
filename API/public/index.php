<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Middleware\AuthMiddleware;
use Middleware\JwtMiddleware;
use Middleware\RoleMiddleware; // ADD

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../src/Database/connection.php';
require __DIR__ . '/../src/Middleware/AuthMiddleware.php';

$app = AppFactory::create();

$app->setBasePath('/api/public');
$app->addBodyParsingMiddleware();

$app->add(AuthMiddleware::get()); // se comenta o elimina esta línea para usar autenticación básica

// $app->add(JwtMiddleware::get()); // JWT Middleware

(require __DIR__ . '/../src/Users/login.php')($app);

(require __DIR__ . '/../src/Users/signup.php')($app);

$app->get('/', function (Request $request, Response $response, $args) {
    $response->getBody()->write("¡Hola Mundo desde Slim 4!");
    return $response;
});

$app->get('/protected', function (Request $request, Response $response) {
    $tokenData = $request->getAttribute('decoded_token_data');
    $username = $tokenData['data']['username'];

    $response->getBody()->write(json_encode([
        'message' => "Bienvenido, $username. Has accedido a una ruta protegida."
    ]));

    return $response->withHeader('Content-Type', 'application/json');
});

// ADD

$app->get('/dashboard', function (Request $request, Response $response) {
    $user = $request->getAttribute('decoded_token_data')['data'];
    $response->getBody()->write(json_encode([
        'message' => "Hola Admin, {$user['username']}"
    ]));
    return $response->withHeader('Content-Type', 'application/json');
})
->add(new RoleMiddleware(['admin']))
->add(JwtMiddleware::get()); 

$app->get('/home', function (Request $request, Response $response) {
    $user = $request->getAttribute('decoded_token_data')['data'];
    $response->getBody()->write(json_encode([
        'message' => "Bienvenido a tu Home, {$user['username']}!",
        'user' => $user
    ]));
    return $response->withHeader('Content-Type', 'application/json');
})->add(JwtMiddleware::get());

// ADD

$app->addErrorMiddleware(true, true, true);

$app->run();
