<?php

namespace App\Controller;

use App\Entity\CommandeClient;
use App\Entity\ProduitCommandeClient;
use App\Form\CommandeClientType;
use App\Repository\CommandeClientRepository;
use App\Repository\ProduitCommandeClientRepository;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/commande/client')]
class CommandeClientController extends AbstractController
{
    #[Route('/', name: 'app_commande_client_index', methods: ['GET'])]
    public function index(CommandeClientRepository $commandeClientRepository, ProduitCommandeClientRepository $produitCommandeClientRepository): Response
    {
        return $this->render('commande_client/index.html.twig', [
            'commande_clients' => $commandeClientRepository->findAll(),
            'produit_commande_clients' => $produitCommandeClientRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_commande_client_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ProduitRepository $produitRepository, ProduitCommandeClientRepository $produitCommandeClientRepository, CommandeClientRepository $commandeClientRepository): Response
    {
        $commandeClient = new CommandeClient();
        $form = $this->createForm(CommandeClientType::class, $commandeClient);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $commandeC = $commandeClientRepository->findOneBy([], ['id' => 'DESC']);
            if ($commandeC == null)
                $id_Commande = 1;
            else
                $id_Commande = $commandeC->getId() + 1;
            $numCommandeClient = "C".date('Y').$id_Commande;

            $numFacture = "F".time();
            $commandeClient->setNumeroCommande($numCommandeClient);
            $commandeClient->setNumeroFacture($numFacture);
            $commandeClient->setUpdatedAt(new \DateTimeImmutable('now'));
            $commandeClient->setDateCommandeAt(new \DateTimeImmutable('now'));
            $commandeClient->setDeletedAt(null);
            $commandeClient->setEtatValide(false);
            $commandeClient->setEtatTraite(false);
            $commandeClientRepository->save($commandeClient, true);

            $votreCookie = $request->cookies->get('produitsAjoutes');
            $cookieDatas = json_decode($votreCookie, true);

            foreach ($cookieDatas as $cookieData){
                $produit = $produitRepository->findOneBy(['id' => $cookieData['id_product']]);
                $produitCommandeClient = new ProduitCommandeClient();
                $produitCommandeClient->setCommandeClient($commandeClient);
                $produitCommandeClient->setProduit($produit);
                $produitCommandeClient->setNumeroCommande($numCommandeClient);
                $produitCommandeClient->setEtatTraite(false);
                $produitCommandeClient->setPrixTotal($cookieData['total']);
                $produitCommandeClient->setQuantite($cookieData['qte']);
                $produitCommandeClient->setUpdatedAt(new \DateTimeImmutable('now'));
                $produitCommandeClient->setCreatedAt(new \DateTimeImmutable('now'));
                $produitCommandeClientRepository->save($produitCommandeClient, true);
            }
            $response = new RedirectResponse($this->generateUrl('app_commande_client_index'), Response::HTTP_SEE_OTHER);
            $response->headers->setCookie(Cookie::create('produitsAjoutes', null, new \DateTime('yesterday')));
            return $response;
        }

        return $this->renderForm('commande_client/new.html.twig', [
            'commande_client' => $commandeClient,
            'form' => $form,
            'produits' => $produitRepository->findByStockNotNull()
        ]);
    }

    #[Route('/{id}', name: 'app_commande_client_show', methods: ['GET'])]
    public function show(CommandeClient $commandeClient): Response
    {
        return $this->render('commande_client/show.html.twig', [
            'commande_client' => $commandeClient,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_commande_client_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, CommandeClient $commandeClient, CommandeClientRepository $commandeClientRepository): Response
    {
        $form = $this->createForm(CommandeClientType::class, $commandeClient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $commandeClientRepository->save($commandeClient, true);

            return $this->redirectToRoute('app_commande_client_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('commande_client/edit.html.twig', [
            'commande_client' => $commandeClient,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_commande_client_delete', methods: ['POST'])]
    public function delete(Request $request, CommandeClient $commandeClient, CommandeClientRepository $commandeClientRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$commandeClient->getId(), $request->request->get('_token'))) {
            $commandeClientRepository->remove($commandeClient, true);
        }

        return $this->redirectToRoute('app_commande_client_index', [], Response::HTTP_SEE_OTHER);
    }
}
