<?php

namespace App\Controller;

use App\Entity\MoyenReglement;
use App\Form\MoyenReglementType;
use App\Repository\MoyenReglementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/dashboard/moyen/reglement')]
class MoyenReglementController extends AbstractController
{
    #[Route('/', name: 'app_moyen_reglement_index', methods: ['GET'])]
    public function index(MoyenReglementRepository $moyenReglementRepository): Response
    {
        return $this->render('moyen_reglement/index.html.twig', [
            'moyen_reglements' => $moyenReglementRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_moyen_reglement_new', methods: ['GET', 'POST'])]
    public function new(Request $request, MoyenReglementRepository $moyenReglementRepository): Response
    {
        $moyenReglement = new MoyenReglement();
        $form = $this->createForm(MoyenReglementType::class, $moyenReglement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $moyenReglementRepository->save($moyenReglement, true);
            $this->addFlash('success', 'Moyen de paiement ajouté !');
            return $this->redirectToRoute('app_moyen_reglement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('moyen_reglement/new.html.twig', [
            'moyen_reglement' => $moyenReglement,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_moyen_reglement_show', methods: ['GET'])]
    public function show(MoyenReglement $moyenReglement): Response
    {
        return $this->render('moyen_reglement/show.html.twig', [
            'moyen_reglement' => $moyenReglement,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_moyen_reglement_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, MoyenReglement $moyenReglement, MoyenReglementRepository $moyenReglementRepository): Response
    {
        $form = $this->createForm(MoyenReglementType::class, $moyenReglement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $moyenReglementRepository->save($moyenReglement, true);
            $this->addFlash('success', 'Moyen de paiement modifié !');
            return $this->redirectToRoute('app_moyen_reglement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('moyen_reglement/edit.html.twig', [
            'moyen_reglement' => $moyenReglement,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_moyen_reglement_delete', methods: ['POST'])]
    public function delete(Request $request, MoyenReglement $moyenReglement, MoyenReglementRepository $moyenReglementRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$moyenReglement->getId(), $request->request->get('_token'))) {
            $moyenReglementRepository->remove($moyenReglement, true);
            $this->addFlash('success', 'Moyen de paiement supprimé !');
        }

        return $this->redirectToRoute('app_moyen_reglement_index', [], Response::HTTP_SEE_OTHER);
    }
}
