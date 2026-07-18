<?php
declare(strict_types=1);

namespace Neo\Src\Neo_Admin\Database\Forms;

use Neo\Core\DI\Container;
use Neo\Core\Database\Builder\FormBuilder;
use Neo\Core\Database\Form\Form;
use Neo\Core\Database\ORM\Model\AbstractModel;
use Neo\Core\Http\Request;
use Neo\Core\Database\Form\Type\SubmitType;
use Neo\Src\Neo_Admin\Database\Model\AdministratorRole;
use Neo\Core\Translation\TranslationManager;


class AdministratorRoleForm
{
    protected Request $request;
    protected AdministratorRole $administratorRole;
    protected TranslationManager $translationManager;

    public function __construct(Container $container)
    {
        $this->request = $container->get(Request::class);
        $this->translationManager = $container->get(TranslationManager::class);
        $this->administratorRole = new AdministratorRole();
    }

    public function build(?AbstractModel $administratorRole = null): Form
    {
        $form = (new FormBuilder($administratorRole ?? $this->administratorRole))
            ->auto()
            ->add('submit', SubmitType::class, ['label' => 'Submit'])
            ->generate();

        $form->addCsrfField();
        
        $form->handleRequest($this->request);
        $form->setData($administratorRole ?? $this->administratorRole);
        $form->populateData();
        
        return $form;
    }
}
