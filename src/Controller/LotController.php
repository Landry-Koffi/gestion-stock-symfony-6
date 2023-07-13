<?php

namespace App\Controller;

use App\Repository\LotRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/dashboard/lot')]
class LotController extends AbstractController
{
    #[Route('/', name: 'app_lot')]
    public function index(LotRepository $lotRepository): Response
    {
        return $this->render('lot/index.html.twig', [
            'lots' => $lotRepository->findBy([], ['datePeremptionAt' => 'ASC'])
        ]);
    }
}
