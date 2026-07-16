<?php
declare(strict_types=1);

namespace Neo\Src\Neo_Admin\App\Controllers\Auth;

use Neo\Core\Controller\AbstractController;
use Neo\Core\Http\Response\JsonResponse;
use Neo\Core\Routing\Attribute\MainRoute;
use Neo\Core\Routing\Attribute\Route;
use Neo\Core\Http\Response\Response;
use Neo\Core\Security\Middleware\Attribute\Middleware;
use Neo\Core\Security\Middleware\Default\GuestMiddleware;

#[Middleware(use: GuestMiddleware::class, redirect: 'default.index')]
#[MainRoute(path: '/auth/login', name: 'auth.login')]
final class LoginController extends AbstractController
{
    #[Route(path: '/', name: 'index', methods: ['GET'])]
    public function index(): JsonResponse
    {
        return $this->json([
            'data' => 'Guest login'
        ]);
    }
}