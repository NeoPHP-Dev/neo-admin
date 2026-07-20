<?php
declare(strict_types=1);

namespace Neo\Src\Neo_Admin\App\Controllers\Panel;

use Neo\Core\Controller\AbstractController;
use Neo\Core\Http\Response\Types\Response;
use Neo\Core\Routing\Attribute\MainRoute;
use Neo\Core\Routing\Attribute\Route;
use Neo\Core\Security\Middleware\Attribute\Middleware;
use Neo\Core\Security\Middleware\Default\AuthMiddleware;

#[Middleware(use: AuthMiddleware::class, redirect: 'default.index')]
#[MainRoute(path: '/panel/dashboard', name: 'panel.dashboard')]
final class DashboardController extends AbstractController
{
    #[Route(path: '/', name: 'index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('pages/panel/dashboard/index.html.twig', []);
    }
}