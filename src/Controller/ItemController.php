<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Repository\WatchlistRepository;
use App\Service\Item\ItemService;
use App\UniqueNameInterface\JsonResponseInterface;
use App\Service\WarframeMarket\MarketService;
use App\UniqueNameInterface\ItemInterface;
use App\UniqueNameInterface\WarframeApiInterface;

#[Route('/item')]
class ItemController extends AbstractController
{
    #[Route('/watched', name: 'item_watched')]
    public function watched (
        WatchlistRepository $watchlistRepository,
        UserInterface       $login
    ): Response
    {
        $itemsWatched = $watchlistRepository->findBy(['login_id' => $login->getId()]);

        return $this->render('item/watched.html.twig', [
            'items_watched' => $itemsWatched,
        ]);
    }

    #[Route('/add', name: 'item_add')]
    public function add (
        Request         $request,
        ItemService     $itemService
    ): JsonResponse|RedirectResponse
    {
        $loginId = $this->getUser()->getId();
        $data = $request->request->all();
        $statusCode = 200;
        $validator = $itemService->validateData($data);

        if ($itemService->checkIfAlreadyWatched($loginId, (int)$data[ItemInterface::FORM_PLATFORMID], $data[ItemInterface::ENTITY_NAME])) {

            return $this->redirectToRoute('item_edit', $data);
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
    public function searchMarket (
        string          $name,
        MarketService   $marketService,
        ItemService     $itemService,
    ): Response {
        /**
         TODO - add platform select (basic - user default)
        */
        $items = $marketService->getWarframeMarketData($name);
        usort($items, function ($a, $b) {return $a[WarframeApiInterface::MARKET_PLATINUM] > $b[WarframeApiInterface::MARKET_PLATINUM];});
        $wikiUrl = $itemService->getImageUrl(
            strtolower(preg_replace('/\s+/', '_', $name))
        );

        return $this->render('item/searchMarket.html.twig', [
            'items'     => array_slice($items, 0, 20),
            'item_name' => $name,
            'wiki_url'  => $wikiUrl
        ]);
    }

    #[Route('/delete', name: 'item_delete', methods: 'DELETE')]
    public function delete (
        Request     $request,
        ItemService $itemService
    ): JsonResponse {
        $data = $request->request->all();
        $statusCode = 200;
        $itemService->deleteItem($this->getUser(), $data);
        $msg = [
            JsonResponseInterface::MESSAGE => 'Successfully deleted item from watch-list'
        ];

        return new JsonResponse($msg, $statusCode);
    }

    #[Route('/edit', name: 'item_edit')]
    public function edit (
        Request     $request,
        ItemService $itemService
    ): JsonResponse {
        $data = $request->query->all();
        $statusCode = 200;
        $validator = $itemService->validateData($data);
        if (0 !== count($validator)) {
            $msg = $validator[0]; // show first error only
            $statusCode = 400;
        } else {
            $itemService->editItem($this->getUser(), $data);
            $msg = [
                JsonResponseInterface::MESSAGE => 'You have edited price of: ' . $data[ItemInterface::FORM_NAME]
            ];
        }
        return new JsonResponse($msg, $statusCode);
    }
}
