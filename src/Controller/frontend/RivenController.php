<?php

namespace App\Controller\frontend;

use App\Controller\BaseController;
use App\Service\Item\RivenService;
use App\UniqueNameInterface\ItemInterface;
use App\UniqueNameInterface\JsonResponseInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/riven')]

class RivenController extends BaseController
{
    #[Route('/add', name: 'riven_add')]
    public function addNew(
        Request         $request,
        RivenService    $rivenService
    ): JsonResponse|RedirectResponse {
        $loginId = $this->getUser()->getId();
        $data = $request->request->all();
        $statusCode = 200;
        $validator = $rivenService->validateData($data);

        if (0 !== count($validator)) {
            $msg = $validator[0]; // show first error only
            $statusCode = 400;
        }
        else {
            $rivenService->addRivenToWatchlist($data, $loginId);
            $msg = [
                JsonResponseInterface::MESSAGE => 'Successfully added item to watch-list'
            ];
        }

        return new JsonResponse($msg, $statusCode);
    }

    #[Route('/delete', name: 'riven_delete', methods: 'DELETE')]
    public function delete (
        Request         $request,
        RivenService    $rivenService
    ): JsonResponse {
        $data = $request->request->all();

        $statusCode = 200;
        $rivenService->deleteRiven((int)$data[ItemInterface::FORM_ID]);
        $msg = [
            JsonResponseInterface::MESSAGE => 'Successfully deleted riven from watch-list'
        ];

        return new JsonResponse($msg, $statusCode);
    }

    #[Route('/test', name: 'item_test')]
    public function test (RivenService $rivenService)
    {
        dd($rivenService->getAttributeList());
    }
}
