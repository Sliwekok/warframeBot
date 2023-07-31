<?php

namespace App\Controller;

use App\Form\LoginFormType;
use App\Security\LoginAuthenticator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use App\Repository\LoginRepository;

class LoginController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(
        Request                     $request,
        UserAuthenticatorInterface  $userAuthenticator,
        LoginAuthenticator          $authenticator,
        LoginRepository             $loginRepository,
    ): Response
    {
        if ($this->getUser()) {

            return $this->redirectToRoute('index');
        }

        $form = $this->createForm(LoginFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $loginRepository->findOneBy([
                'username' => $form->get('username')->getData()
            ]);

            if ($user) {
                $userAuthenticator->authenticateUser(
                    $user,
                    $authenticator,
                    $request
                );
            }

            return $this->redirectToRoute('index');
        }

        return $this->render('auth/login.html.twig', [
            'loginForm' => $form->createView(),
        ]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
