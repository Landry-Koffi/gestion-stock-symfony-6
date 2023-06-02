<?php

namespace App\Controller;

use App\Entity\CommandeClient;
use App\Entity\CommandeFournisseur;
use App\Entity\ProduitCommandeClient;
use App\Entity\ProduitCommandeFournisseur;
use App\Form\CommandeClientType;
use App\Form\CommandeFournisseurType;
use App\Repository\CommandeFournisseurRepository;
use App\Repository\ProduitCommandeFournisseurRepository;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/commande/fournisseur')]
class CommandeFournisseurController extends AbstractController
{
    #[Route('/', name: 'app_commande_fournisseur_index', methods: ['GET'])]
    public function index(CommandeFournisseurRepository $commandeFournisseurRepository, ProduitCommandeFournisseurRepository $produitCommandeFournisseurRepository): Response
    {
        return $this->render('commande_fournisseur/index.html.twig', [
            'commande_fournisseurs' => $commandeFournisseurRepository->findBy(['deletedAt' => null], ['dateCommandeAt' => 'DESC']),
            'produit_commande_fournisseurs' => $produitCommandeFournisseurRepository->findBy([],["numeroCommande" => "DESC"]),
        ]);
    }

    #[Route('/new', name: 'app_commande_fournisseur_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CommandeFournisseurRepository $commandeFournisseurRepository, ProduitRepository $produitRepository, ProduitCommandeFournisseurRepository $produitCommandeFournisseurRepository): Response
    {
        $commandeFournisseur = new CommandeFournisseur();
        $form = $this->createForm(CommandeFournisseurType::class, $commandeFournisseur);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $commandeF = $commandeFournisseurRepository->findOneBy([], ['id' => 'DESC']);
            if ($commandeF == null)
                $id_Commande = 1;
            else
                $id_Commande = $commandeF->getId() + 1;
            $numCommandeFournisseur = "F".date('Y').$id_Commande;

            $numFacture = "F".time();
            $commandeFournisseur->setNumeroCommande($numCommandeFournisseur);
            $commandeFournisseur->setNumeroFacture($numFacture);
            $commandeFournisseur->setUpdatedAt(new \DateTimeImmutable('now'));
            $commandeFournisseur->setDateCommandeAt(new \DateTimeImmutable('now'));
            $commandeFournisseur->setDeletedAt(null);
            $commandeFournisseur->setEtatValide(false);
            $commandeFournisseur->setEtatTraite(false);
            $commandeFournisseurRepository->save($commandeFournisseur, true);

            $votreCookie = $request->cookies->get('produitsAjoutesFournisseur');
            $cookieDatas = json_decode($votreCookie, true);

            foreach ($cookieDatas as $cookieData){
                $produit = $produitRepository->findOneBy(['id' => $cookieData['id_product']]);
                $produitCommandeFounisseur = new ProduitCommandeFournisseur();
                $produitCommandeFounisseur->setCommandeFournisseur($commandeFournisseur);
                $produitCommandeFounisseur->setProduit($produit);
                $produitCommandeFounisseur->setNumeroCommande($numCommandeFournisseur);
                $produitCommandeFounisseur->setEtatTraite(false);
                $produitCommandeFounisseur->setQuantite($cookieData['qte']);
                $produitCommandeFounisseur->setUpdatedAt(new \DateTimeImmutable('now'));
                $produitCommandeFounisseur->setCreatedAt(new \DateTimeImmutable('now'));
                $produitCommandeFournisseurRepository->save($produitCommandeFounisseur, true);
            }
            $response = new RedirectResponse($this->generateUrl('app_commande_fournisseur_index'), Response::HTTP_SEE_OTHER);
            $response->headers->setCookie(Cookie::create('produitsAjoutesFournisseur', null, new \DateTime('yesterday')));
            return $response;
        }

        return $this->renderForm('commande_fournisseur/new.html.twig', [
            'commande_fournisseur' => $commandeFournisseur,
            'form' => $form,
            'produits' => $produitRepository->findAll()
        ]);
    }

    #[Route('/voir-bons/{id}', name: 'app_commande_fournisseur_voir_bons', methods: ['GET'])]
    public function voirBons(CommandeFournisseur $commandeFournisseur, Request $request, ProduitCommandeFournisseurRepository $produitCommandeFournisseurRepository): Response
    {
        $produitCommandeFournisseurs = $produitCommandeFournisseurRepository->findBy(["commandeFournisseur" => $commandeFournisseur]);
        return $this->render('commande_fournisseur/voir_bons.html.twig', [
            'commande_fournisseur' => $commandeFournisseur,
            'produitCommandeFournisseurs' => $produitCommandeFournisseurs,
        ]);
    }

    #[Route('/modifier/{id}', name: 'app_commande_fournisseur_modifier', methods: ['GET', 'POST'])]
    public function modifier($id, Request $request, ProduitCommandeFournisseurRepository $produitCommandeFournisseurRepository, ProduitRepository $produitRepository): Response
    {
        $qteLivree = $request->request->get("qte".$id);
        $produitCommandeFournisseur = $produitCommandeFournisseurRepository->findOneBy(['id' => $id]);
        $quantiteUpdate = $produitCommandeFournisseur->getQuantiteUpdate();
        $produitCommandeFournisseur->setQuantiteLivree($qteLivree);
        $produitCommandeFournisseur->setQuantiteUpdate($qteLivree);
        $produitCommandeFournisseur->setUpdatedAt(new \DateTimeImmutable('now'));
        $produitCommandeFournisseurRepository->save($produitCommandeFournisseur, true);

        $produit = $produitRepository->findOneBy(['id' => $produitCommandeFournisseur->getProduit()->getId()]);
        if ($quantiteUpdate !== null){
            $produit->setStock($produit->getStock() - $quantiteUpdate + $qteLivree);
        }else{
            $produit->setStock($produit->getStock() + $qteLivree);
        }
        $produitRepository->save($produit, true);

        return $this->redirectToRoute('app_commande_fournisseur_index', [], Response::HTTP_SEE_OTHER);
    }


    #[Route('/supprimer/{id}', name: 'app_commande_fournisseur_supprimer', methods: ['GET', 'POST'])]
    public function supprimer($id, CommandeFournisseurRepository $commandeFournisseurRepository): Response
    {
        $commandeFournisseur = $commandeFournisseurRepository->findOneBy(['id' => $id]);
        $commandeFournisseur->setDeletedAt(new \DateTimeImmutable('now'));
        $commandeFournisseurRepository->save($commandeFournisseur, true);
        return $this->redirectToRoute('app_commande_fournisseur_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/traiter/{id}', name: 'app_commande_fournisseur_traiter', methods: ['GET', 'POST'])]
    public function traiter($id, CommandeFournisseurRepository $commandeFournisseurRepository): Response
    {
        $commandeFournisseur = $commandeFournisseurRepository->findOneBy(['id' => $id]);
        $commandeFournisseur->setEtatTraite(true);
        $commandeFournisseur->setUpdatedAt(new \DateTimeImmutable('now'));
        $commandeFournisseurRepository->save($commandeFournisseur, true);
        return $this->redirectToRoute('app_commande_fournisseur_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/valider/{id}', name: 'app_commande_fournisseur_valider', methods: ['GET', 'POST'])]
    public function valider($id, Request $request, CommandeFournisseurRepository $commandeFournisseurRepository): Response
    {
        $dateLivraison = $request->request->get("dateLivraison");
        if ($dateLivraison != null){
            $commandeFournisseur = $commandeFournisseurRepository->findOneBy(['id' => $id]);
            $commandeFournisseur->setEtatValide(true);
            $commandeFournisseur->setDateLivraisonAt(new \DateTimeImmutable($dateLivraison));
            $commandeFournisseur->setUpdatedAt(new \DateTimeImmutable('now'));
            $commandeFournisseurRepository->save($commandeFournisseur, true);
        }else{
            // TODO :: Message d'erreur
        }
        return $this->redirectToRoute('app_commande_fournisseur_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}', name: 'app_commande_fournisseur_show', methods: ['GET'])]
    public function show(CommandeFournisseur $commandeFournisseur): Response
    {
        return $this->render('commande_fournisseur/show.html.twig', [
            'commande_fournisseur' => $commandeFournisseur,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_commande_fournisseur_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, CommandeFournisseur $commandeFournisseur, CommandeFournisseurRepository $commandeFournisseurRepository): Response
    {
        $form = $this->createForm(CommandeFournisseurType::class, $commandeFournisseur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $commandeFournisseurRepository->save($commandeFournisseur, true);

            return $this->redirectToRoute('app_commande_fournisseur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('commande_fournisseur/edit.html.twig', [
            'commande_fournisseur' => $commandeFournisseur,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_commande_fournisseur_delete', methods: ['POST'])]
    public function delete(Request $request, CommandeFournisseur $commandeFournisseur, CommandeFournisseurRepository $commandeFournisseurRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$commandeFournisseur->getId(), $request->request->get('_token'))) {
            $commandeFournisseurRepository->remove($commandeFournisseur, true);
        }

        return $this->redirectToRoute('app_commande_fournisseur_index', [], Response::HTTP_SEE_OTHER);
    }
}
