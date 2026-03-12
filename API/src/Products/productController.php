<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Helpers\AuthHelper;
use App\Helpers\ResponseHelper;

return function ($app) {

    $app->post('/dashboard/create/product', function (Request $request, Response $response) {
        if (!AuthHelper::isAdmin($request)) {
            return ResponseHelper::json($response, [
                'message' => 'Acceso denegado: se requiere ser administrador.'
            ], 403);
        }

        $pdo = \Database\Connection::getConnection();
        $data = $request->getParsedBody();

        $description = trim($data['description'] ?? '');
        $stock = trim($data['stock'] ?? '');

        if (empty($description) || empty($stock)) {
            return ResponseHelper::json($response, [
                'message' => 'Todos los campos son obligatorios.'
            ], 400);
        }

        try {
            $stmt = $pdo->prepare("INSERT INTO products (description, stock) VALUES (:description, :stock)");
            $stmt->execute([
                'description' => $description,
                'stock' => $stock
            ]);

            return ResponseHelper::json($response, [
                'message' => 'Producto creado exitosamente.',
                'id' => $pdo->lastInsertId()
            ], 201);

        } catch (PDOException $e) {
            return ResponseHelper::json($response, [
                'message' => 'Error en la base de datos al crear el producto.',
                'error' => $e->getMessage()
            ], 500);
        }
    });

    $app->get('/dashboard/products', function (Request $request, Response $response) {
        if (!AuthHelper::isAdmin($request)) {
            return ResponseHelper::json($response, [
                'message' => 'Acceso denegado: se requiere ser administrador.'
            ], 403);
        }    

        $pdo = \Database\Connection::getConnection();

        try {
            $stmt = $pdo->prepare("SELECT * FROM products");
            $stmt->execute();
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (empty($products)) {
                return ResponseHelper::json($response, [
                    'message' => 'No hay productos registrados.'
                ]);
            }

            $username = $userData->username ?? 'Admin';

            return ResponseHelper::json($response, [
                'message' => "Hola Admin, $username",
                'products' => $products
            ]);

        } catch (PDOException $e) {
            return ResponseHelper::json($response, [
                'message' => 'Error en la consulta de la base de datos.'
            ]);
        }
    });

    $app->get('/dashboard/view/product/{id}', function (Request $request, Response $response, array $args) {
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
            $stmt = $pdo->prepare("SELECT * FROM products WHERE id = :id");
            $stmt->execute(['id' => $id]);
            $product = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (empty($product)) {
                return ResponseHelper::json($response, [
                    'message' => 'Producto no encontrado.'
                ]);
            }

            $response->getBody()->write(json_encode($product));
            return $response->withHeader('Content-Type', 'application/json');
        } catch (PDOException $e) {
            return ResponseHelper::json($response, [
                'message' => 'Error en la base de datos.',
                'error' => $e->getMessage()
            ], 500);
        }

        // var_dump($product);die();
    });

    // --------------------------------------------------------------------------------------------------------------

    $app->delete('/dashboard/delete/product/{id}', function (Request $request, Response $response, array $args) {
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
            $stmt = $pdo->prepare("DELETE FROM products WHERE id = :id");
            $stmt->execute(['id' => $id]);

            if ($stmt->rowCount() === 0) {
                return ResponseHelper::json($response, [
                    'message' => 'Producto no encontrado o ya eliminado.'
                ], 404);
            }

            return ResponseHelper::json($response, [
                'message' => 'Producto eliminado correctamente.'
            ], 200);

        } catch (PDOException $e) {
            return ResponseHelper::json($response, [
                'message' => 'Error en la base de datos.',
                'error' => $e->getMessage()
            ], 500);
        }
        // var_dump($product);die();
    });

    $app->put('/dashboard/update/product/{id}', function (Request $request, Response $response, array $args) {
        $id = (int) $args['id'];

        if (!AuthHelper::isAdmin($request)) {
            return ResponseHelper::json($response, [
                'message' => 'Acceso denegado: se requiere ser administrador.'
            ], 403);
        }

        $pdo = \Database\Connection::getConnection();
        $data = $request->getParsedBody();

        $description = trim($data['description'] ?? '');
        $stock = trim($data['stock'] ?? '');

        if (empty($description) || empty($stock)) {
            return ResponseHelper::json($response, [
                'message' => 'Todos los campos son obligatorios.'
            ], 400);
        }

        try {
            $stmt = $pdo->prepare("
                UPDATE products
                SET description = :description,
                    stock = :stock
                WHERE id = :id
            ");
            
            $stmt->execute([
                'description' => $description,
                'stock' => $stock,
                'id' => $id
            ]);

            if ($stmt->rowCount() === 0) {
                return ResponseHelper::json($response, [
                    'message' => 'Producto no encontrado o datos sin cambios.'
                ], 404);
            }

            return ResponseHelper::json($response, [
                'message' => 'Producto actualizado correctamente.'
            ], 200);

        } catch (PDOException $e) {
            return ResponseHelper::json($response, [
                'message' => 'Error en la base de datos.',
                'error' => $e->getMessage()
            ], 500);
        }
    });
};