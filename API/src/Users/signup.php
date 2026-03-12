<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Database\Connection;

return function ($app) {
    $app->post('/signup', function (Request $request, Response $response) {
        try {
            $pdo = Connection::getConnection();
            $data = $request->getParsedBody();

            $username = trim($data['username'] ?? '');
            $email = trim($data['email'] ?? '');
            $password = $data['password'] ?? '';
            $role = strtolower(trim($data['role'] ?? 'user'));

            if (empty($username) || empty($email) || empty($password)) {
                $response->getBody()->write(json_encode([
                    'message' => 'Todos los campos son obligatorios.'
                ]));
                return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $response->getBody()->write(json_encode([
                    'message' => 'Email no válido.'
                ]));
                return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
            }

            $validRoles = ['user', 'admin'];
            if (!in_array($role, $validRoles)) {
                $response->getBody()->write(json_encode([
                    'message' => 'Rol no válido. Solo se permiten "user" o "admin".'
                ]));
                return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
            }

            $sql = "SELECT COUNT(*) FROM users WHERE username = :username OR email = :email";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':username' => $username, ':email' => $email]);
            $exists = $stmt->fetchColumn();

            if ($exists > 0) {
                $response->getBody()->write(json_encode([
                    'message' => 'El usuario o el correo ya están registrados.'
                ]));
                return $response->withHeader('Content-Type', 'application/json')->withStatus(409);
            }

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO users (username, password, email, role) VALUES (:username, :password, :email, :role)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':username' => $username,
                ':password' => $hashedPassword,
                ':email' => $email,
                ':role' => $role
            ]);

            $userId = $pdo->lastInsertId();

            $response->getBody()->write(json_encode([
                'message' => 'Usuario registrado con éxito.',
                'user_id' => $userId,
                'role' => $role
            ]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(201);

        } catch (\PDOException $e) {
            $response->getBody()->write(json_encode([
                'message' => 'Error en el servidor.'
                // 'error' => $e->getMessage() // solo en desarrollo
            ]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
        }
    });
};
