<?php

namespace App\Controller;

use App\Entity\Sorties;
use App\Form\SortiesType;
use App\Repository\ProduitRepository;
use App\Repository\SortiesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/dashboard/sorties')]
class SortiesController extends AbstractController
{
    #[Route('/', name: 'app_sorties_index', methods: ['GET'])]
    public function index(SortiesRepository $sortiesRepository): Response
    {
        return $this->render('sorties/index.html.twig', [
            'sorties' => $sortiesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_sorties_new', methods: ['GET', 'POST'])]
    public function new(Request $request, SortiesRepository $sortiesRepository, ProduitRepository $produitRepository): Response
    {
        $sorty = new Sorties();
        $form = $this->createForm(SortiesType::class, $sorty);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $produit = $form['produits']->getData();
            $prod = $produitRepository->findOneBy(['id' => $produit]);

            if ($prod->getStock() < $form['quantite']->getData()){
                $this->addFlash('error', 'Veuillez entrer une quantité inférieur ou égale à la quantité en stock !');
                return $this->redirectToRoute('app_sorties_new', [], Response::HTTP_SEE_OTHER);
            }

            $sorty->setPrixUnitaire($prod->getPrixVente());
            $sorty->setPrixTotal($prod->getPrixVente() * $form['quantite']->getData());
            $sorty->setAdmin($this->getUser());
            $sorty->setCreatedAt(new \DateTimeImmutable('now'));

            $prod->setStock($prod->getStock() - $form['quantite']->getData());

            $sortiesRepository->save($sorty, true);
            $produitRepository->save($prod, true);

            $this->addFlash('success', 'Action effectuée !');

            return $this->redirectToRoute('app_sorties_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('sorties/new.html.twig', [
            'sorty' => $sorty,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_sorties_show', methods: ['GET'])]
    public function show(Sorties $sorty): Response
    {
        return $this->render('sorties/show.html.twig', [
            'sorty' => $sorty,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_sorties_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Sorties $sorty, SortiesRepository $sortiesRepository): Response
    {
        $form = $this->createForm(SortiesType::class, $sorty);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $sortiesRepository->save($sorty, true);

            return $this->redirectToRoute('app_sorties_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('sorties/edit.html.twig', [
            'sorty' => $sorty,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_sorties_delete', methods: ['POST'])]
    public function delete(Request $request, Sorties $sorty, SortiesRepository $sortiesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$sorty->getId(), $request->request->get('_token'))) {
            $sortiesRepository->remove($sorty, true);
        }

        return $this->redirectToRoute('app_sorties_index', [], Response::HTTP_SEE_OTHER);
    }
}
