<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Repository\ItemRepository;
use App\Service\Item\ItemService;
use App\UniqueNameInterface\JsonResponseInterface;
use App\Service\WarframeMarket\MarketService;
use App\UniqueNameInterface\ItemInterface;
use App\UniqueNameInterface\WarframeApi;

#[Route('/item')]
class ItemController extends AbstractController
{
    #[Route('/watched', name: 'item_watched')]
    public function watched(
        ItemRepository  $itemRepository,
        UserInterface   $login
    ): Response
    {
        $itemsWatched = $itemRepository->findAllForUser($login->getId(), $login->getPlatformId());

        return $this->render('item/watched.html.twig', [
            'items_watched' => $itemsWatched,
        ]);
    }

    #[Route('/add', name: 'item_add')]
    public function add(
        Request         $request,
        ItemService     $itemService
    ): JsonResponse
    {
        $loginId = $this->getUser()->getId();
        $data = $request->request->all();
        $statusCode = 200;
        $validator = $itemService->validateData($data);

        if ($itemService->checkIfAlreadyWatched($loginId, (int)$data[ItemInterface::FORM_PLATFORMID], $data[ItemInterface::ENTITY_NAME])) {
            $msg = [
                JsonResponseInterface::MESSAGE => 'Item already on watch-list. Update price if you want to make your chances higher!'
            ];
            $statusCode = 400;
        }
        elseif (!$itemService->itemExistsInApi($data[ItemInterface::FORM_NAME])) {
            $msg = [
                JsonResponseInterface::MESSAGE => 'Something wrong with name of searched item'
            ];
            $statusCode = 400;
        }
        elseif (0 !== count($validator)) {
            $msg = $validator[0]; // show first error only
            $statusCode = 400;
        }
        else {
            $itemService->addItemToWatchlist($data, $loginId);
            $msg = [
                JsonResponseInterface::MESSAGE => 'Successfully added item to watch-list'
            ];
        }

        return new JsonResponse($msg, $statusCode);
    }

    #[Route('/search_market/{name}', name: 'item_search_market', methods: ['GET'])]
    public function searchMarket(
        string          $name,
        MarketService   $marketService
    ): Response {
        $items = $marketService->getWarframeMarketData($name);
        usort($items, function ($a, $b) {return $a[WarframeApi::MARKET_PLATINUM] > $b[WarframeApi::MARKET_PLATINUM];});

        return $this->render('item/searchMarket.html.twig', [
            'items'     => array_slice($items, 0, 20),
            'item_name' => $name,
        ]);
    }
}
