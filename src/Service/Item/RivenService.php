<?php

declare(strict_types=1);

namespace App\Service\Item;

use App\Entity\Riven;
use App\Repository\ItemRepository;
use App\Repository\LoginRepository;
use App\Repository\RivenRepository;
use App\Service\Notification\NotificationService;
use App\UniqueNameInterface\ItemInterface;
use App\Util\Helper\WarframeMarketApi;
use Doctrine\ORM\EntityManagerInterface;

class RivenService extends ItemService
{
    public function __construct (
        ItemRepository              $itemRepository,
        WarframeMarketApi           $warframeMarketApi,
        EntityManagerInterface      $entityManager,
        NotificationService         $notificationService,
        private LoginRepository     $loginRepository,
        private RivenRepository     $rivenRepository

    ) {
        parent::__construct($itemRepository, $warframeMarketApi, $entityManager, $notificationService);
    }

    public function addRivenToWatchlist(
        array   $data,
        int     $loginId
    ): void {
        $riven = new Riven();
        $login = $this->loginRepository->find($loginId);
        $rivenCurlName = strtolower(preg_replace('/\s+/', '_', $data[ItemInterface::FORM_NAME]));
        $rivenWikiUrl = $this->getRivenWikiUrl($rivenCurlName);
        $rivenImageUrl = $this->getImageUrl($rivenCurlName, rivenUrl: true);
        $riven
            ->setLogin($login)
            ->setPrice((int)$data[ItemInterface::FORM_PRICE])
            ->setWeaponName((string)$data[ItemInterface::FORM_NAME])
            ->setNameCurl($rivenCurlName)
            ->setImageUrl($rivenImageUrl)
            ->setWikiUrl($rivenWikiUrl)
            ->setAttrNeg((string)$data[ItemInterface::FORM_RIVEN_ATTR][ItemInterface::FORM_RIVEN_ATTR_NEGATIVE])
            ->setAttrPos1((string)$data[ItemInterface::FORM_RIVEN_ATTR][ItemInterface::FORM_RIVEN_ATTR_POSITIVE_1])
            ->setAttrPos2((string)$data[ItemInterface::FORM_RIVEN_ATTR][ItemInterface::FORM_RIVEN_ATTR_POSITIVE_2])
            ->setAttrPos3((string)$data[ItemInterface::FORM_RIVEN_ATTR][ItemInterface::FORM_RIVEN_ATTR_POSITIVE_3])
        ;
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

}
