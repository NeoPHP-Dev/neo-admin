<?php
declare(strict_types=1);

namespace Neo\Src\Neo_Admin\App\Extension;

use Neo\Core\Security\Auth\AuthManager;
use Neo\Core\Translation\TranslationManager;
use Neo\Core\Utils\Cache\Cache;
use Neo\Core\Utils\Config\Config;
use Neo\Core\View\Interface\TwigExtensionInterface;

final class NavigationViewExtension implements TwigExtensionInterface
{

    private ?array $navigationItems = null;

    public function __construct(
        protected Config $config,
        protected TranslationManager $translator,
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
            $result[$key] = [
                'label' => $this->translator->translate($group['label']),
                'links' => array_map(fn(array $item) => [
                    'route' => $item['route'],
                    'icon' => $item['icon'],
                    'label' => $this->translator->translate($item['label']),
                ], $group['items']),
            ];
        }

        return $this->navigationItems = $result;
    }
}