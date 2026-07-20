<?php
declare(strict_types=1);

namespace Neo\Src\Neo_Admin;

use Neo\Core\DI\Container;
use Neo\Core\Http\Request\Request;
use Neo\Core\Module\Abstract\AbstractModule;
use Neo\Core\Module\Interface\ModuleInterface;
use Neo\Core\Routing\Router;
use Neo\Core\Security\Auth\AuthManager;
use Neo\Core\Security\Middleware\MiddlewareManager;
use Neo\Core\Translation\TranslationManager;
use Neo\Core\Utils\Cache\Cache;
use Neo\Core\Utils\Config\Config;
use Neo\Core\Utils\Config\ConfigModule;
use Neo\Core\View\ViewModule;
use Neo\Core\Utils\Cache\CacheModule;
use Neo\Src\Neo_Admin\App\Extension\AsideViewExtension;
use Neo\Src\Neo_Admin\App\Extension\NavigationViewExtension;

final class Neo_AdminModule implements ModuleInterface
{
    public function dependencies(): array
    {
        return [];
    }

    public function register(Container $container): void
    {}

    public function init(Container $container): object
    {
        return $this;
    }
}