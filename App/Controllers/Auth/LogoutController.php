<?php
declare(strict_types=1);

namespace Neo\Src\Neo_Admin\App\Controllers\Auth;

use Neo\Core\Controller\AbstractController;
use Neo\Core\Http\Response\RedirectResponse;
use Neo\Core\Routing\Attribute\MainRoute;
use Neo\Core\Routing\Attribute\Route;
use Neo\Core\Http\Response\Response;
use Neo\Core\Security\Middleware\Attribute\Middleware;
use Neo\Core\Security\Middleware\Default\AuthMiddleware;

#[Middleware(use: AuthMiddleware::class, redirect: 'default.index')]
#[MainRoute(path: '/auth/logout', name: 'auth.logout')]
final class LogoutController extends AbstractController
{
    #[Route(path: '/', name: 'index', methods: ['GET'])]
    public function index(): RedirectResponse
    {
        if ($this->auth()->check()) {
            $this->auth()->logout();
        }
        return $this->redirectToRoute('default.index');
    }
}