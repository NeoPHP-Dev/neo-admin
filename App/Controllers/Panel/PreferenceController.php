<?php
declare(strict_types=1);

namespace Neo\Src\Neo_Admin\App\Controllers\Panel;

use Neo\Core\Controller\AbstractController;
use Neo\Core\Http\Response\RedirectResponse;
use Neo\Core\Routing\Attribute\MainRoute;
use Neo\Core\Routing\Attribute\Route;
use Neo\Core\Http\Response\Response;
use Neo\Core\Security\Middleware\Attribute\IsGranted;
use Neo\Core\Translation\TranslationManager;

#[IsGranted(roles: ['ROOT'])]
#[MainRoute(path: '/panel/preference', name: 'panel.preference')]
final class PreferenceController extends AbstractController
{
    public function __construct(
        protected TranslationManager $translator,
    ) {
    }

    #[Route(path: '/', name: 'index', methods: ['GET'])]
    public function index(): Response
    {}

    #[Route(path: '/locale/{locale}', name: 'locale.change', methods: ['GET'])]
    public function changeLocale(string $locale): RedirectResponse
    {
        $this->translator->setLocale($locale);
        return $this->redirectBack();
    }
}