<?php
namespace Middleware;

use Tuupola\Middleware\JwtAuthentication;

class JwtMiddleware
{
    public static function get()
    {
        $config = require __DIR__ . '/../config/jwt.php';

        return new JwtAuthentication([
            "secret" => $config['secret'],
            "algorithm" => ["HS256"],
            "attribute" => "decoded_token_data",
            "path" => ["/protected"], // rutas que protegerá
            "ignore" => ["/login", "/signup"],
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
