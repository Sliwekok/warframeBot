<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin')]
class AdminController extends AbstractController
{
    #[Route('/panel', name: 'admin_panel')]
    public function panel(): Response
    {
        return $this->render('admin/panel.html.twig', [
        ]);
    }
}
