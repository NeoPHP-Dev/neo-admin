<?php
declare(strict_types=1);

namespace Neo\Src\Neo_Admin\App\Extension;

use Neo\Core\Routing\Router;
use Neo\Core\Security\Middleware\MiddlewareManager;
use Neo\Core\Translation\TranslationManager;
use Neo\Core\Utils\Config\Config;
use Neo\Core\View\Interface\TwigExtensionInterface;

final class NavigationViewExtension implements TwigExtensionInterface
{
    private ?array $navigationItems = null;

    public function __construct(
        protected Config $config,
        protected TranslationManager $translator,
        protected Router $router,
        protected MiddlewareManager $middlewareManager,
    ) {}

    public function getFunctions(): array
    {
        return [
            'navigationItems' => [
                'callable' => fn() => $this->getNavigationItems(),
                'options' => []
            ]
        ];
    }

    public function getFilters(): array
    {
        return [];
    }

    private function getNavigationItems(): array
    {
        if ($this->navigationItems !== null) {
            return $this->navigationItems;
        }

        $groups = $this->config->from('routes')->all();
        $result = [];

        foreach ($groups as $key => $group) {
            $links = [];

            foreach ($group['items'] as $item) {
                if (!$this->isAccessible($item['route'] ?? null)) {
                    continue;
                }

                $links[] = [
                    'route' => $item['route'],
                    'icon' => $item['icon'],
                    'label' => $this->translator->translate($item['label']),
                ];
            }

            if (empty($links)) {
                continue;
            }

            $result[$key] = [
                'label' => $this->translator->translate($group['label']),
                'links' => $links,
            ];
        }

        return $this->navigationItems = $result;
    }

    private function isAccessible(?string $routeName): bool
    {
        if ($routeName === null) {
            return true;
        }

        $routeInfo = $this->router->findRouteInfo($routeName);

        if ($routeInfo === null) {
            return true;
        }

        return $this->middlewareManager->isAccessible($routeInfo['controller'], $routeInfo['action']);
    }
}