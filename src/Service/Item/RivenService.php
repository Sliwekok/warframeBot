<?php

declare(strict_types=1);

namespace App\Service\Item;

use App\Entity\Riven;
use App\Entity\RivenAttribute;
use App\Repository\LoginRepository;
use App\Repository\RivenAttributeExternalRepository;
use App\Repository\RivenRepository;
use App\Service\Notification\NotificationService;
use App\UniqueNameInterface\ItemInterface;
use Doctrine\ORM\EntityManagerInterface;

class RivenService extends ItemService
{
    public function __construct(
        private EntityManagerInterface              $entityManager,
        private NotificationService                 $notificationService,
        private LoginRepository                     $loginRepository,
        private RivenRepository                     $rivenRepository,
        private RivenAttributeExternalRepository    $attributeExternalRepository
    ) {}

    public function addRivenToWatchlist(
        array   $data,
        int     $loginId
    ): void {
        $riven = new Riven();
        $login = $this->loginRepository->find($loginId);
        $rivenCurlName = strtolower(preg_replace('/\s+/', '_', $data[ItemInterface::FORM_NAME]));
        $riven
            ->setLogin($login)
            ->setPrice((int)$data[ItemInterface::FORM_PRICE])
            ->setWeaponName((string)$data[ItemInterface::FORM_NAME])
        ;

        dd($data);
        foreach ($data[ItemInterface::FORM_RIVEN_ATTR] as $attributes) {
            $attribute = new RivenAttribute();
//            $attribute->setName();
        }

        $this->entityManager->persist($riven);
        $this->entityManager->flush();
    }

    private function getRivenWikiUrl (
        string $name
    ): string {
        $exploded = explode('_', $name);
        $newUrl = implode('_', array_map('ucfirst', $exploded));

        return $newUrl;
    }

    /**
     * delete Riven and related notifications
     *
     * @param int $id
     */
    public function deleteRiven(
        int             $id
    ): void {
        $riven = $this->rivenRepository->find($id);

        $this->notificationService->deleteNotifications($riven);
        $this->entityManager->remove($riven);
        $this->entityManager->flush();
    }

    public function getAttributeList()
    {
        $attributes = $this->attributeExternalRepository->getList([]);

        return json_encode(['attributes' => $attributes]);
    }

}
