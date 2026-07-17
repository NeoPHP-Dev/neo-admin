<?php
declare(strict_types=1);

namespace Neo\Src\Neo_Admin\App\Controllers\Auth;

use Neo\Core\Controller\AbstractController;
use Neo\Core\Http\Response\JsonResponse;
use Neo\Core\Routing\Attribute\MainRoute;
use Neo\Core\Routing\Attribute\Route;
use Neo\Core\Http\Response\Response;
use Neo\Core\Security\Auth\PasswordManager;
use Neo\Core\Security\Middleware\Attribute\Middleware;
use Neo\Core\Security\Middleware\Default\GuestMiddleware;
use Neo\Core\Translation\TranslationManager;
use Neo\Src\Neo_Admin\Database\Forms\AdministratorForm;

#[Middleware(use: GuestMiddleware::class, redirect: 'default.index')]
#[MainRoute(path: '/auth/login', name: 'auth.login')]
final class LoginController extends AbstractController
{
    public function __construct(
        protected TranslationManager $translationManager,
    ) {
    }

    #[Route(path: '/', name: 'index', methods: ['GET', 'POST'])]
    public function index(AdministratorForm $administratorForm, PasswordManager $passwordManager): Response
    {
        $loginForm = $administratorForm->buildLogin();

        if ($loginForm->isSubmitted() && $loginForm->isValid()) {
            $data = $loginForm->getData();
            $isAuth = $this->auth()->attempt([
                'username' => $data->getUsername(),
                'password' => $data->getPassword()
            ]);

            if ($isAuth) {

                $this->getLogger()->channel('security')->info(
                    msg: sprintf('%s was successfull logged in at %s',
                        $this->auth()->user()->getUsername(),
                        date('d-m-Y H:i:s'),
                    ),
                    origin: 'auth.login'
                );

                return $this->redirectToRoute('default.index');
            } else {
                $this->getFlash()->add(
                    'error',
                    $this->translationManager->translate(
                        'Nom d\'utilisateur et/ou mot de passe invalide',
                        [],
                        'auth'
                    )
                );
            }
        }

        return $this->render('pages/auth/login/index.html.twig', [
            'loginForm' => $loginForm,
        ]);
    }
}