<?php

declare(strict_types=1);

namespace App\Service\User;

use App\Entity\Login;
use App\Repository\LoginRepository;
use Doctrine\ORM\EntityManagerInterface;

class UserService
{
    public function __construct(
        private LoginRepository         $loginRepository,
        private EntityManagerInterface  $entityManager
    )
    {}

    public function updatePlatform(
        int $userId,
        int $platformId
    ): void {
        $user = $this->loginRepository->find($userId);
        $user->setPlatformId($platformId);
        $this->entityManager->flush();
    }

}