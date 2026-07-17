<?php
declare(strict_types=1);

namespace Neo\Src\Neo_Admin\Database\Forms;

use Neo\Core\Database\Form\Type\PasswordType;
use Neo\Core\Database\Form\Type\TextType;
use Neo\Core\DI\Container;
use Neo\Core\Database\Builder\FormBuilder;
use Neo\Core\Database\Form\Form;
use Neo\Core\Database\ORM\Model\AbstractModel;
use Neo\Core\Http\Request;
use Neo\Core\Database\Form\Type\SubmitType;
use Neo\Core\Validator\Assert\NotBlank;
use Neo\Src\Neo_Admin\Database\Model\Administrator;
use Neo\Core\Translation\TranslationManager;


class AdministratorForm
{
    protected Request $request;
    protected Administrator $administrator;
    protected TranslationManager $translationManager;

    public function __construct(Container $container)
    {
        $this->request = $container->get(Request::class);
        $this->translationManager = $container->get(TranslationManager::class);
        $this->administrator = new Administrator();
    }

    public function build(?AbstractModel $administrator = null): Form
    {
        $form = (new FormBuilder($administrator ?? $this->administrator))
            ->auto()
            ->add('submit', SubmitType::class, ['label' => 'Submit'])
            ->generate();

        $form->addCsrfField();
        
        $form->handleRequest($this->request);
        $form->setData($administrator ?? $this->administrator);
        $form->populateData();
        
        return $form;
    }

    public function buildLogin(): Form
    {
        $form = new FormBuilder($this->administrator)
            ->auto(fieldTypes: [
                'username' => [
                    TextType::class,
                    [
                        'label' => $this->translationManager->translate('Nom d\'utilisateur', [], 'auth'),
                        'placeholder' => 'super.admin'
                    ]
                ],
                'password' => [
                    PasswordType::class,
                    [
                        'label' => $this->translationManager->translate('Mot de passe', [], 'auth'),
                        'placeholder' => '••••••••'
                    ]
                ]
            ])
            ->add(
                'submit',
                SubmitType::class,
                [
                    'label' => $this->translationManager->translate('Connexion', [], 'auth')
                ]
            )
            ->generate();

        $form->addCsrfField();

        $form->addConstraint('username', new NotBlank(
            message: $this->translationManager->translate('Vous devez indiquer votre nom d\'utilisateur', [], 'auth')
        ));

        $form->addConstraint('password', new NotBlank(
            message: $this->translationManager->translate('Vous devez indiquer votre mot de passe', [], 'auth')
        ));

        $form->handleRequest($this->request);
        $form->setData($this->administrator);
        $form->populateData();

        return $form;
    }
}
