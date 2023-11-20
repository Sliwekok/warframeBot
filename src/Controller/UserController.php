<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\Notification\NotificationService;
use App\UniqueNameInterface\ItemInterface;
use App\Repository\NotificationsRepository;
use App\UniqueNameInterface\NotificationsInterface;
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
        NotificationsRepository $notificationsRepository,
        NotificationService     $notificationService
    ): Response {
        $notifications = $notificationsRepository->findBy([
            NotificationsInterface::ENTITY_LOGINID => $this->getUser()->getId(),
        ]);
        $notifications = $notificationService->getRelatedItems($notifications);
        $notificationService->setAsRead($notifications);

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
