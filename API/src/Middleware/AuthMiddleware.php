<?php
namespace Middleware;

use Tuupola\Middleware\HttpBasicAuthentication;
use Database\Connection;

class AuthMiddleware
{
    public static function get()
    {
        return new HttpBasicAuthentication([
            "path" => ["/protected"],
            "realm" => "Protected Area",
            "authenticator" => function ($arguments) {
                $email = $arguments["user"];
                $password = $arguments["password"];

                $conn = Connection::getConnection();
                $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
                $stmt->execute(['email' => $email]);
                $user = $stmt->fetch();

                if ($user && password_verify($password, $user['password'])) {
                    return true;
                }

                return false;
            },
            "error" => function ($response, $arguments) {
                $data = [];
                $data["status"] = "error";
                $data["message"] = $arguments["message"];
                $payload = json_encode($data);

                $response->getBody()->write($payload);
                return $response
                    ->withHeader("Content-Type", "application/json")
                    ->withStatus(401);
            }
        ]);
    }
}
