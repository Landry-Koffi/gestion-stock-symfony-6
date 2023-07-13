<?php

namespace App\Controller;

use App\Repository\ReglementRepository;
use App\Services\Pagination;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReglementController extends AbstractController
{
    #[Route('/dashboard/reglement', name: 'app_reglement_index')]
    public function index(ReglementRepository $reglementRepository, Pagination $paginator): Response
    {
        return $this->render('reglement/index.html.twig', [
            'reglements' => $paginator->generate($reglementRepository->findBy([], ['id' => 'DESC'])),
        ]);
    }
}
