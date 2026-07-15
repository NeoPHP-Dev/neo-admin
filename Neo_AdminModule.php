<?php
declare(strict_types=1);

namespace Neo\Src\Neo_Admin;

use Neo\Core\DI\Container;
use Neo\Core\Module\Abstract\AbstractModule;
use Neo\Core\Utils\Config\ConfigModule;
use Neo\Core\View\ViewModule;
use Neo\Core\Utils\Cache\CacheModule;

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
        // Registration of project-specific services (Neo_Admin)
    }
}