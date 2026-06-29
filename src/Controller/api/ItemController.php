<?php

declare(strict_types=1);

namespace App\Controller\api;

use App\Controller\BaseController;
use App\Repository\RivenRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Repository\WatchlistRepository;
use App\Service\Item\ItemService;
use App\UniqueNameInterface\JsonResponseInterface;
use App\Service\WarframeMarket\MarketService;
use App\UniqueNameInterface\ItemInterface;
use App\UniqueNameInterface\WarframeApiInterface;

#[Route('/api/item')]
class ItemController extends BaseController
{
}
