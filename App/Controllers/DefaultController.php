<?php
declare(strict_types=1);

namespace Neo\Src\Neo_Admin\App\Controllers;

use Neo\Core\Controller\AbstractController;
use Neo\Core\Http\Response\RedirectResponse;
use Neo\Core\Routing\Attribute\MainRoute;
use Neo\Core\Routing\Attribute\Route;
use Neo\Core\Http\Response\Response;

#[MainRoute(path: '/', name: 'default')]
final class DefaultController extends AbstractController
{
    #[Route(path: '/', name: 'index', methods: ['GET'])]
    public function index(): RedirectResponse
    {
        if ($this->auth()->check()) {
            return $this->redirectToRoute('panel.dashboard.index');
        } else {
            return $this->redirectToRoute('auth.login.index');
        }
    }
}