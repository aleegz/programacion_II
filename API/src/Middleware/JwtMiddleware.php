<?php
namespace Middleware;

use Tuupola\Middleware\JwtAuthentication;

class JwtMiddleware
{
    public static function get()
    {
        // $config = require __DIR__ . '/../../config/jwt.php';

        return new JwtAuthentication([
            // "secret" => $config['secret'], // .env????
            "secret" => $_ENV['JWT_SECRET'],
            "algorithm" => ["HS256"],
            "attribute" => "decoded_token_data",
            "path" => ["/"], // rutas que protegerá
            "ignore" => ["/api/public/login", "/api/public/signup"],
            "secure" => false, // <--- esto permite HTTP en desarrollo
            "error" => function ($response, $arguments) {
                $data = [
                    "status" => "error",
                    "message" => $arguments["message"]
                ];
                $response->getBody()->write(json_encode($data));
                return $response->withHeader("Content-Type", "application/json")->withStatus(401);
            }
        ]);
    }
}
