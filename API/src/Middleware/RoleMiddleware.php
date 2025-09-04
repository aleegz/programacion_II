<?php
namespace Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as Handler;
use Psr\Http\Message\ResponseInterface as Response;

class RoleMiddleware
{
    private array $allowedRoles;
    private ResponseFactoryInterface $responseFactory;
    
    public function __construct(ResponseFactoryInterface $responseFactory, array $allowedRoles) {
        $this->responseFactory = $responseFactory;
        $this->allowedRoles = $allowedRoles;
    }

    public function __invoke(Request $request, Handler $handler): Response
    {
        $user = $request->getAttribute('decoded_token_data')['data'] ?? null;

        if (!$user || !in_array($user['role'], $this->allowedRoles)) {
            $response = $this->responseFactory->createResponse();
            $response->getBody()->write(json_encode([
                'error' => 'Acceso denegado. Rol no autorizado.'
            ]));
            return $response->withStatus(403)->withHeader('Content-Type', 'application/json');
        }

        return $handler->handle($request);
    }
}
