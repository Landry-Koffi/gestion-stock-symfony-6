<?php

namespace App\Controller;

use App\Repository\LotRepository;
use App\Services\Pagination;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/dashboard/lot')]
class LotController extends AbstractController
{
    #[Route('/', name: 'app_lot')]
    public function index(LotRepository $lotRepository, Pagination $paginator): Response
    {
        return $this->render('lot/index.html.twig', [
            'lots' => $paginator->generate($lotRepository->findBy([], ['datePeremptionAt' => 'ASC'])),
        ]);
    }
}
