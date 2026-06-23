<?php

namespace App\Controller;

use App\Service\Admin\AdminService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin')]
class AdminController extends AbstractController
{
    private const VERSION = 'version';

    #[Route('/panel', name: 'admin_panel')]
    public function panel(
        AdminService    $adminService
    ): Response
    {
        $versions = $adminService->getGitVersions();
        $currentVersion = $adminService->getCurrentVersion();

        return $this->render('admin/panel.html.twig', [
            "versions"          => $versions,
            'currentVersion'    => $currentVersion
        ]);
    }

    #[Route('/change_version', name: 'admin_change_version')]
    public function changeVersion(
        AdminService    $adminService,
        Request         $request
    ): JsonResponse
    {
        $version = $request->request->all()[self::VERSION];
        $adminService->updateServer($version);

        return new JsonResponse("Started updating services", 200);
    }
}
