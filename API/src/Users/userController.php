<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Helpers\ResponseHelper;
use App\Helpers\AuthHelper;
use Middleware\JwtMiddleware;

return function ($app) {
    $app->get('/dashboard/users', function (Request $request, Response $response) {
        if (!AuthHelper::isAdmin($request)) {
            return ResponseHelper::json($response, [
                'message' => 'Acceso denegado: se requiere ser administrador.'
            ], 403);
        }

        $pdo = \Database\Connection::getConnection();

        try {
            $stmt = $pdo->prepare("SELECT id, username, email, role, created_at FROM users");
            $stmt->execute();
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (empty($users)) {
                return ResponseHelper::json($response, [
                    'message' => 'No hay usuarios registrados.'
                ]);
            }

            $tokenData = $request->getAttribute('decoded_token_data');
            $userData = $tokenData['data'] ?? null;
            $username = $userData->username ?? 'Admin';

            return ResponseHelper::json($response, [
                'message' => "Hola Admin, $username",
                'users' => $users
            ]);

        } catch (PDOException $e) {
            return ResponseHelper::json($response, [
                'message' => 'Error en la base de datos.',
                'error'   => $e->getMessage()
            ], 500);
        }
    })->add(JwtMiddleware::get());

    $app->get('/dashboard/view/user/{id}', function (Request $request, Response $response, array $args) {
        $id = (int) $args['id'];
        if ($id <= 0) {
            return ResponseHelper::json($response, [
                'message' => 'ID inválido.'
            ], 400);
        }

        if (!AuthHelper::isAdmin($request)) {
            return ResponseHelper::json($response, [
                'message' => 'Acceso denegado: se requiere ser administrador.'
            ], 403);
        }

        $pdo = \Database\Connection::getConnection();

        try {
            $stmt = $pdo->prepare("SELECT id, username, email, role, created_at FROM users WHERE id = :id");
            $stmt->execute(['id' => $id]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$user) {
                return ResponseHelper::json($response, [
                    'message' => 'Usuario no encontrado.'
                ], 404);
            }

            return ResponseHelper::json($response, [
                'user' => $user
            ]);

        } catch (PDOException $e) {
            return ResponseHelper::json($response, [
                'message' => 'Error en la base de datos.',
                'error' => $e->getMessage()
            ], 500);
        }
    })->add(JwtMiddleware::get());

    $app->delete('/dashboard/delete/user/{id}', function (Request $request, Response $response, array $args) {
        if (!AuthHelper::isAdmin($request)) {
            return ResponseHelper::json($response, [
                'message' => 'Acceso denegado: se requiere ser administrador.'
            ], 403);
        }

        $id = (int) $args['id'];
        if ($id <= 0) {
            return ResponseHelper::json($response, [
                'message' => 'ID inválido.'
            ], 400);
        }

        $pdo = \Database\Connection::getConnection();

        try {
            $stmt = $pdo->prepare("DELETE FROM users WHERE id = :id");
            $stmt->execute(['id' => $id]);

            if ($stmt->rowCount() === 0) {
                return ResponseHelper::json($response, [
                    'message' => 'Usuario no encontrado o ya eliminado.'
                ], 404);
            }

            return ResponseHelper::json($response, [
                'message' => 'Usuario eliminado correctamente.'
            ], 200);

        } catch (PDOException $e) {
            return ResponseHelper::json($response, [
                'message' => 'Error en la base de datos.',
                'error' => $e->getMessage()
            ], 500);
        }
    })->add(JwtMiddleware::get());

    $app->put('/dashboard/update/user/{id}', function (Request $request, Response $response, array $args) {
        if (!AuthHelper::isAdmin($request)) {
            return ResponseHelper::json($response, [
                'message' => 'Acceso denegado: se requiere ser administrador.'
            ], 403);
        }

        $id = (int) $args['id'];
        if ($id <= 0) {
            return ResponseHelper::json($response, [
                'message' => 'ID inválido.'
            ], 400);
        }

        $data = $request->getParsedBody();
        $username = trim($data['username'] ?? '');
        $email = trim($data['email'] ?? '');
        $password = $data['password'] ?? '';
        $role = strtolower(trim($data['role'] ?? 'user'));

        if (empty($username) || empty($email) || empty($password) || empty($role)) {
            return ResponseHelper::json($response, [
                'message' => 'Todos los campos son obligatorios.'
            ], 400);
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ResponseHelper::json($response, [
                'message' => 'Email no válido.'
            ], 400);
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $pdo = \Database\Connection::getConnection();

        try {
            $stmt = $pdo->prepare("
                UPDATE users
                SET username = :username,
                    email = :email,
                    password = :password,
                    role = :role
                WHERE id = :id
            ");
            $stmt->execute([
                'username' => $username,
                'email' => $email,
                'password' => $hashedPassword,
                'role' => $role,
                'id' => $id
            ]);

            if ($stmt->rowCount() === 0) {
                return ResponseHelper::json($response, [
                    'message' => 'Usuario no encontrado o datos sin cambios.'
                ], 404);
            }

            return ResponseHelper::json($response, [
                'message' => 'Usuario actualizado correctamente.'
            ], 200);

        } catch (PDOException $e) {
            return ResponseHelper::json($response, [
                'message' => 'Error en la base de datos.',
                'error' => $e->getMessage()
            ], 500);
        }
    })->add(JwtMiddleware::get());
};
