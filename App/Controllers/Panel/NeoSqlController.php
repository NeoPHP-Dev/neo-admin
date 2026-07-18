<?php

declare(strict_types=1);

namespace Neo\Src\Neo_Admin\App\Controllers\Panel;

use Neo\Core\Controller\AbstractController;
use Neo\Core\Database\Builder\QueryBuilder;
use Neo\Core\Database\DatabaseIntrospector;
use Neo\Core\Http\Response\Response;
use Neo\Core\Routing\Attribute\MainRoute;
use Neo\Core\Routing\Attribute\Route;

#[MainRoute(path: '/panel/neosql', name: 'panel.neosql')]
final class NeoSqlController extends AbstractController
{
    private const int PER_PAGE = 25;

    public function __construct(
        private readonly DatabaseIntrospector $introspector,
    ) {
    }

    #[Route(path: '/', name: 'index', methods: ['GET'])]
    public function index(): Response
    {
        $tables = $this->introspector->getTables();

        $tablesInfo = array_map(function (string $table) {
            return [
                'name' => $table,
                'rowCount' => new QueryBuilder()->table($table)->count(),
                'columnCount' => count($this->introspector->getColumns($table)),
            ];
        }, $tables);

        return $this->render('pages/panel/neosql/index.html.twig', [
            'tables' => $tablesInfo,
        ]);
    }

    #[Route(path: '/{table}', name: 'table.show', methods: ['GET'])]
    public function show(string $table): Response
    {
        if (!in_array($table, $this->introspector->getTables(), true)) {
            return $this->redirectToRoute('panel.neosql.index');
        }

        $columns = $this->introspector->getColumns($table);

        $page = max(1, (int)($_GET['page'] ?? 1));

        $qb = new QueryBuilder()->table($table);
        $total = (clone $qb)->count();

        $rows = $qb->limit(self::PER_PAGE)->offset((($page - 1) * self::PER_PAGE))->get();

        return $this->render('pages/panel/neosql/show.html.twig', [
            'table' => $table,
            'columns' => $columns,
            'rows' => $rows,
            'total' => $total,
            'page' => $page,
            'perPage' => self::PER_PAGE,
            'totalPages' => max(1, (int)ceil($total / self::PER_PAGE)),
        ]);
    }
}