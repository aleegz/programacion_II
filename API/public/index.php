<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

use Middleware\AuthMiddleware;
use Middleware\JwtMiddleware;
use Middleware\RoleMiddleware;
use App\Helpers\ResponseHelper;
use App\Helpers\AuthHelper;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../src/Database/connection.php';
require __DIR__ . '/../src/Middleware/AuthMiddleware.php';
require __DIR__ . '/../src/Middleware/JwtMiddleware.php';
require __DIR__ . '/../src/Middleware/RoleMiddleware.php';

$app = AppFactory::create();

$app->setBasePath('/api/public');
$app->addBodyParsingMiddleware();

// $app->add(AuthMiddleware::get()); // se comenta o elimina esta línea para usar autenticación básica

$app->add(JwtMiddleware::get()); // JWT Middleware

(require __DIR__ . '/../src/Users/login.php')($app);
(require __DIR__ . '/../src/Users/signup.php')($app);
(require __DIR__ . '/../src/Products/productController.php')($app);

$app->get('/', function (Request $request, Response $response, $args) {
    $response->getBody()->write("¡Hola Mundo desde Slim 4!");
    return $response;
});

$app->get('/protected', function (Request $request, Response $response) {
    $tokenData = $request->getAttribute('decoded_token_data');
    $userData = $tokenData['data'];
    $username = $userData->username ?? 'Invitado';

    return ResponseHelper::json($response, [
        'message' => 'Has ingresado a una ruta protegida.',
        'user'    => $userData
    ]);
});

$app->get('/home', function (Request $request, Response $response) {
    $tokenData = $request->getAttribute('decoded_token_data');
    $userData = $tokenData['data'];
    $username = $userData->username ?? 'Invitado';

    return ResponseHelper::json($response, [
        'message' => "Bienvenido a tu Home, {$username}!"
    ]);
})->add(JwtMiddleware::get());

$app->get('/dashboard/users', function (Request $request, Response $response) {
    if (!AuthHelper::isAdmin($request)) {
        return ResponseHelper::json($response, [
            'message' => 'Acceso denegado: se requiere ser administrador.'
        ], 403);
    }    

    $pdo = \Database\Connection::getConnection();

    try {
        $stmt = $pdo->prepare("SELECT * FROM users");
        $stmt->execute();
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($users)) {
            return ResponseHelper::json($response, [
                'message' => 'No hay usuarios registrados.'
            ]);
        }

        $username = $userData->username ?? 'Admin';

        return ResponseHelper::json($response, [
            'message' => "Hola Admin, $username",
            'users' => $users
        ]);

    } catch (PDOException $e) {
        return ResponseHelper::json($response, [
            'message' => 'Error en la consulta de la base de datos.'
        ]);
    }
});

$app->get('/dashboard/view/user/{id}', function (Request $request, Response $response, array $args) {
    $id = (int) $args['id'];
    if ($id <= 0) {
        return $response->withHeader('Content-Type', 'application/json')->withStatus(400)
            ->write(json_encode(['message' => 'ID inválido.']));
    }

    if (!AuthHelper::isAdmin($request)) {
        return ResponseHelper::json($response, [
            'message' => 'Acceso denegado: se requiere ser administrador.'
        ], 403);
    }

    $pdo = \Database\Connection::getConnection();

    try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $user = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($user)) {
            return ResponseHelper::json($response, [
                'message' => 'Usuario no encontrado.'
            ]);
        }

        $response->getBody()->write(json_encode($user));
        return $response->withHeader('Content-Type', 'application/json');
    } catch (PDOException $e) {
        return ResponseHelper::json($response, [
            'message' => 'Error en la base de datos.',
            'error' => $e->getMessage()
        ], 500);
    }

    // var_dump($user);die();
});

// --------------------------------------------------------------------------------------------------------------

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
    // var_dump($user);die();
});

$app->put('/dashboard/update/user/{id}', function (Request $request, Response $response, array $args) {
    $id = $args['id'];

    $pdo = \Database\Connection::getConnection();

    if (!AuthHelper::isAdmin($request)) {
        return $response->withHeader('Content-Type', 'application/json')->withStatus(401)
        ->getBody()->write(json_encode([
            'message' => 'Acceso denegado: se requiere ser administrador.'
        ]));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(401);
    }

    $data = $request->getParsedBody();

    $username = trim($data['username'] ?? '');
    $email = trim($data['email'] ?? '');
    $password = $data['password'] ?? '';
    $role = strtolower(trim($data['role'] ?? 'user'));

    if (empty($username) || empty($email) || empty($password) || empty($role)) {
        return $response->withHeader('Content-Type', 'application/json')->withStatus(400)
        ->getBody()->write(json_encode([
            'message' => 'Todos los campos son obligatorios.'
        ]));
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return $response->withHeader('Content-Type', 'application/json')->withStatus(400)
        ->getBody()->write(json_encode([
            'message' => 'Email no válido.'
        ]));
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

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
            return $response->withHeader('Content-Type', 'application/json')->withStatus(404)
            ->getBody()->write(json_encode([
                'message' => 'Usuario no encontrado o datos sin cambios.'
            ]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
        }

        return $response->withHeader('Content-Type', 'application/json')->withStatus(404)
        ->getBody()->write(json_encode([
            'message' => 'Usuario actualizado correctamente.'
        ]));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);

    } catch (PDOException $e) {
        return $response->withHeader('Content-Type', 'application/json')->withStatus(500)
        ->getBody()->write(json_encode([
            'message' => 'Error en la base de datos.'
        ]));
    }
});

$app->addErrorMiddleware(true, true, true);

$app->run();
