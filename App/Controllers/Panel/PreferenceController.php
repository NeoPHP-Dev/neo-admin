<?php
declare(strict_types=1);

namespace Neo\Src\Neo_Admin\App\Controllers\Panel;

use Neo\Core\Controller\AbstractController;
use Neo\Core\Http\Response\RedirectResponse;
use Neo\Core\Routing\Attribute\MainRoute;
use Neo\Core\Routing\Attribute\Route;
use Neo\Core\Http\Response\Response;
use Neo\Core\Security\Middleware\Attribute\Middleware;
use Neo\Core\Security\Middleware\Default\AuthMiddleware;
use Neo\Core\Translation\TranslationManager;

#[Middleware(use: AuthMiddleware::class, redirect: 'default.index')]
#[MainRoute(path: '/panel/preference', name: 'panel.preference')]
final class PreferenceController extends AbstractController
{
    public function __construct(
        protected TranslationManager $translator,
    ) {
    }

    #[Route(path: '/', name: 'index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('pages/panel/preferences/index.html.twig');
    }

    #[Route(path: '/theme', name: 'theme.index', methods: ['GET'])]
    public function theme(): Response
    {
        return $this->render('pages/panel/preferences/theme.html.twig');
    }

    #[Route(path: '/theme/{theme}', name: 'theme.change', methods: ['GET'])]
    public function changeTheme(string $theme): RedirectResponse
    {
        $this->getSession()->set('theme', $theme);
        return $this->redirectBack();
    }

    #[Route(path: '/locale', name: 'locale.index', methods: ['GET'])]
    public function locale(): Response
    {
        return $this->render('pages/panel/preferences/locale.html.twig', [
            'currentLocale' => $this->translator->getLocale(),
            'locales' => [
                ['code' => 'fr', 'label' => 'Français'],
                ['code' => 'en', 'label' => 'Anglais'],
            ],
        ]);
    }

    #[Route(path: '/locale/{locale}', name: 'locale.change', methods: ['GET'])]
    public function changeLocale(string $locale): RedirectResponse
    {
        $this->translator->setLocale($locale);
        return $this->redirectBack();
    }
}