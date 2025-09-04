<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Database\Connection;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

return function ($app) {
    $app->post('/login', function (Request $request, Response $response) {
        $data = $request->getParsedBody();
        $email = $data['email'] ?? '';
        $password = $data['password'] ?? '';

        $conn = Connection::getConnection();
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $config = require __DIR__ . '/../../config/jwt.php';
            $secret = $config['secret'];

            $payload = [
                'iss' => 'api',
                'aud' => 'api-client',
                'iat' => time(),
                'exp' => time() + (60 * 60),
                'data' => [
                    'id' => $user['id'],
                    'email' => $user['email'],
                    'username' => $user['username'],
                    'role' => $user['role']
                ]
            ];
            

            $jwt = JWT::encode($payload, $secret, 'HS256');

            $response->getBody()->write(json_encode(['token' => $jwt]));
            return $response->withHeader('Content-Type', 'application/json');
        } else {
            $response->getBody()->write(json_encode(['message' => 'Credenciales inválidas']));
            return $response->withStatus(401)->withHeader('Content-Type', 'application/json');
        }
    });
};
