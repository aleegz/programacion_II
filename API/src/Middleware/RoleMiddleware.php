<?php
namespace Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as Handler;
use Psr\Http\Message\ResponseInterface as Response;

class RoleMiddleware
{
    private array $allowedRoles;

    public function __construct(array $allowedRoles)
    {
        $this->allowedRoles = $allowedRoles;
    }

    public function __invoke(Request $request, Handler $handler): Response
    {
        $userData = $request->getAttribute('decoded_token_data')['data'] ?? null;
        $userRole = $userData['role'] ?? null;

        if (!$userRole || !in_array($userRole, $this->allowedRoles)) {
            $response = new \Slim\Psr7\Response();

            $errorMessage = $userRole
                ? "Acceso denegado. Tu rol '{$userRole}' no tiene permiso para acceder a esta ruta."
                : "Acceso denegado. No se pudo determinar tu rol de usuario.";

            $response->getBody()->write(json_encode([
                'status' => 'error',
                'message' => $errorMessage,
                'required_roles' => $this->allowedRoles,
                'your_role' => $userRole,
                'username' => $userData['username']
            ]));

            return $response
                ->withStatus(403)
                ->withHeader('Content-Type', 'application/json');
        }

        return $handler->handle($request);
    }
}
