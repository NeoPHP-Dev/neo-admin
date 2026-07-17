<?php
declare(strict_types=1);

namespace Neo\Src\Neo_Admin;

use Neo\Core\DI\Container;
use Neo\Core\Module\Abstract\AbstractModule;
use Neo\Core\Security\Auth\AuthManager;
use Neo\Core\Utils\Cache\Cache;
use Neo\Core\Utils\Config\ConfigModule;
use Neo\Core\View\ViewModule;
use Neo\Core\Utils\Cache\CacheModule;
use Neo\Src\Neo_Admin\App\Extension\AsideViewExtension;

final class Neo_AdminModule extends AbstractModule
{
    public function dependencies(): array
    {
        return [
            // ClassModule::class,
        ];
    }

    public function register(Container $container): void
    {
        $container->set(AsideViewExtension::class, fn(Container $c) => new AsideViewExtension(
            $c->get(AuthManager::class),
            $c->get(Cache::class),
        ));
        $container->tag(AsideViewExtension::class, 'twig.extension');
    }
}