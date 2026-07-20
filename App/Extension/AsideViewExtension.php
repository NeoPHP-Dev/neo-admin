<?php
declare(strict_types=1);

namespace Neo\Src\Neo_Admin\App\Extension;

use Neo\Core\Extension\Attribute\Extension;
use Neo\Core\Extension\Enum\ExtensionTypeEnum;
use Neo\Core\Security\Auth\AuthManager;
use Neo\Core\Utils\Cache\Cache;
use Neo\Core\Utils\Cache\CacheManager;
use Neo\Core\View\Interface\TwigExtensionInterface;

#[Extension(type: ExtensionTypeEnum::VIEW)]
final class AsideViewExtension implements TwigExtensionInterface
{
    private const int TTL = 300;

    private ?array $administrator = null;

    public function __construct(
        private readonly AuthManager $auth,
        private readonly CacheManager $cache,
    ) {}

    public function getFunctions(): array
    {
        return [
            'getAdministrator' => [
                'callable' => fn() => $this->getAdministrator(),
                'options' => [],
            ],
        ];
    }

    public function getFilters(): array
    {
        return [];
    }

    private function getAdministrator(): ?array
    {
        if ($this->administrator !== null) {
            return $this->administrator;
        }

        $user = $this->auth->user();

        if ($user === null) {
            return null;
        }

        $role = $user->getRole();

        $cacheKey = 'admin:profile:' . $user->getId();

        $this->administrator = $this->cache->remember($cacheKey, self::TTL, fn() => [
            'id' => $user->getId(),
            'username' => $user->getUsername(),
            'display_fullname' => trim($user->getFirstname() . ' ' . $user->getLastname()) ?: $user->getUsername(),
            'avatar' => $user->getAvatar(),
            'initials' => mb_strtoupper(
                (
                    mb_substr($user->getFirstname() ?? '', 0, 1) .
                    mb_substr($user->getLastname() ?? '', 0, 1)
                ) ?: mb_substr($user->getUsername(), 0, 1)
            ),
            'role' => [
                'id' => $role ? $role->getId() : null,
                'label' => $role ? $role->getLabel() : '__NOT_DEFINED__',
                'textColor' => $role ? $role->getTextColor() : null,
                'backgroundColor' => $role ? $role->getBackgroundColor() : null,
            ]
        ]);

        return $this->administrator;
    }
}