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

        $primaryKey = $user::getPrimaryKey();
        $id = $user->$primaryKey;
        $cacheKey = 'admin:profile:' . $id;

        $this->administrator = $this->cache->remember($cacheKey, self::TTL, fn() => [
            'id' => $id,
            'username' => $user->username,
            'role' => $user->role?->name ?? '--',
        ]);

        return $this->administrator;
    }
}