<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Database\Connection;

return function ($app) {
    $app->post('/signup', function (Request $request, Response $response) {
        $pdo = Connection::getConnection();

        $data = $request->getParsedBody();
        $username = $data['username'] ?? '';
        $email = $data['email'] ?? '';
        $password = $data['password'] ?? '';

        $sql = "SELECT COUNT(*) FROM users WHERE username = :username OR email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':username' => $username, ':email' => $email]);
        $exists = $stmt->fetchColumn();

        if ($exists > 0) {
            $response->getBody()->write(json_encode(['message' => 'El usuario ya se encuentra registrado.']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(409);
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (username, password, email, role) VALUES (:username, :password, :email, 'user')";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':username' => $username,
            ':password' => $hashedPassword,
            ':email' => $email
        ]);

        $response->getBody()->write(json_encode(['message' => 'Usuario registrado con éxito.']));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
    });
};
