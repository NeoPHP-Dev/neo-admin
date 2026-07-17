<?php
declare(strict_types=1);

namespace Neo\Src\Neo_Admin\App\Extension;

use Neo\Core\Security\Auth\AuthManager;
use Neo\Core\Utils\Cache\Cache;
use Neo\Core\View\Interface\TwigExtensionInterface;

final class AsideViewExtension implements TwigExtensionInterface
{
    private const int TTL = 300;

    private ?array $administrator = null;

    public function __construct(
        private readonly AuthManager $auth,
        private readonly Cache $cache,
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

        $cacheKey = 'admin:profile:' . $user->getId();

        $this->administrator = $this->cache->remember($cacheKey, self::TTL, fn() => [
            'id' => $user->getId(),
            'username' => $user->getUsername(),
            'display_fullname' => $user->getFirstname() . ' ' . $user->getLastname(),
            'avatar' => $user->getAvatar(),
            'initials' => mb_strtoupper(
                (
                    mb_substr($user->getFirstname() ?? '', 0, 1) .
                    mb_substr($user->getLastname() ?? '', 0, 1)
                ) ?: mb_substr($user->getUsername(), 0, 1)
            ),
            'role' => $user->role?->name ?? '--',
        ]);

        return $this->administrator;
    }
}