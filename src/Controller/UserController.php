<?php

declare(strict_types=1);

namespace App\Controller;

use App\UniqueNameInterface\ItemInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Service\User\UserService;
use App\UniqueNameInterface\JsonResponseInterface;

#[Route('/user')]
class UserController extends AbstractController
{
    #[Route('/', name: 'user_account')]
    public function index(
    ): Response {
        $notifications = [];

        return $this->render('user/account.html.twig', [
            'notifications' => $notifications,
            'user'          => $this->getUser()
        ]);
    }

    #[Route('/change_platform', name: 'user_change_platform')]
    public function changePlatform(
        Request     $request,
        UserService $userService
    ): JsonResponse {
        $newPlatform = $request->request->all();
        $userService->updatePlatform($this->getUser()->getId(), (int)$newPlatform[ItemInterface::FORM_PLATFORMID]);
        $msg = [
            JsonResponseInterface::MESSAGE => 'You have changed your default platform. Remember that already existing item will stay untouched'
        ];

        return new JsonResponse($msg);
    }
}
