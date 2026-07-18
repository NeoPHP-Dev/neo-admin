<?php
declare(strict_types=1);

namespace Neo\Src\Neo_Admin\Database\Repository;

use Neo\Core\Database\ORM\Repository\AbstractRepository;
use Neo\Src\Neo_Admin\Database\Model\AdministratorRole;

class AdministratorRoleRepository extends AbstractRepository
{
    protected string $modelClass = AdministratorRole::class;
}
