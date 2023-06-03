<?php

namespace App\Controller;

use App\Repository\ReglementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReglementController extends AbstractController
{
    #[Route('/dashboard/reglement', name: 'app_reglement_index')]
    public function index(ReglementRepository $reglementRepository): Response
    {
        return $this->render('reglement/index.html.twig', [
            'reglements' => $reglementRepository->findBy([], ['id' => 'DESC']),
        ]);
    }
}
