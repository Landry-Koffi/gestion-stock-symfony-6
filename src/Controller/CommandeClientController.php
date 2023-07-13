<?php

namespace App\Controller;

use App\Entity\CommandeClient;
use App\Entity\Lot;
use App\Entity\ProduitCommandeClient;
use App\Entity\Reglement;
use App\Form\CommandeClientType;
use App\Repository\ClientCouponsRepository;
use App\Repository\ClientRepository;
use App\Repository\CommandeClientRepository;
use App\Repository\CouponsRepository;
use App\Repository\FidelisationRepository;
use App\Repository\LotRepository;
use App\Repository\MoyenReglementRepository;
use App\Repository\ProduitCommandeClientRepository;
use App\Repository\ProduitRepository;
use App\Repository\ReglementRepository;
use App\Services\GenerationPoints;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use DateTime;

#[Route('/dashboard/commande/client')]
class CommandeClientController extends AbstractController
{
    #[Route('/', name: 'app_commande_client_index', methods: ['GET'])]
    public function index(MoyenReglementRepository $moyenReglementRepository, CommandeClientRepository $commandeClientRepository, ProduitCommandeClientRepository $produitCommandeClientRepository): Response
    {
        $count_commande_client_etat_false = $commandeClientRepository->count(['etatValide' => false, 'deletedAt' => null]);
        return $this->render('commande_client/index.html.twig', [
            'commande_clients' => $commandeClientRepository->findBy(['deletedAt' => null], ['dateCommandeAt' => 'DESC']),
            'produit_commande_clients' => $produitCommandeClientRepository->findBy([],["numeroCommande" => "DESC"]),
            'moyen_reglements' => $moyenReglementRepository->findBy([],["libelle" => "DESC"]),
            'count_commande_client_etat_false' => $count_commande_client_etat_false
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
                $produitCommandeClient->setCommentaire($cookieData['comment']);
                $produitCommandeClient->setUpdatedAt(new \DateTimeImmutable('now'));
                $produitCommandeClient->setCreatedAt(new \DateTimeImmutable('now'));
                $produitCommandeClientRepository->save($produitCommandeClient, true);
            }
            $this->addFlash('success', 'Commande client créée !');
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

    #[Route('/voir-bons/{id}', name: 'app_commande_client_voir_bons', methods: ['GET'])]
    public function voirBons(CommandeClient $commandeClient, Request $request, ProduitCommandeClientRepository $produitCommandeClientRepository): Response
    {
        $produitCommandeClients = $produitCommandeClientRepository->findBy(["commandeClient" => $commandeClient]);
        return $this->render('commande_client/voir_bons.html.twig', [
            'commande_client' => $commandeClient,
            'produitCommandeClients' => $produitCommandeClients,
        ]);
    }

    #[Route('/modifier/{id}', name: 'app_commande_client_modifier', methods: ['GET', 'POST'])]
    public function modifier($id, Request $request, ProduitCommandeClientRepository $produitCommandeClientRepository, ProduitRepository $produitRepository): Response
    {
        $qteLivree = $request->request->get("qte".$id);
        $produitCommandeClient = $produitCommandeClientRepository->findOneBy(['id' => $id]);
        $quantiteUpdate = $produitCommandeClient->getQuantiteUpdate();
        $produitCommandeClient->setQuantiteLivree($qteLivree);
        $produitCommandeClient->setQuantiteUpdate($qteLivree);
        $produitCommandeClient->setEtatTraite(true);
        $produitCommandeClient->setUpdatedAt(new \DateTimeImmutable('now'));
        $produitCommandeClientRepository->save($produitCommandeClient, true);

        $produit = $produitRepository->findOneBy(['id' => $produitCommandeClient->getProduit()->getId()]);

        if ($quantiteUpdate !== null){
            $produit->setStock($produit->getStock() + $quantiteUpdate - $qteLivree);
        }else{
            $produit->setStock($produit->getStock() - $qteLivree);
        }
        $produitRepository->save($produit, true);
        $this->addFlash('success', 'Commande client modifiée !');
        return $this->redirectToRoute('app_commande_client_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/supprimer/{id}', name: 'app_commande_client_supprimer', methods: ['GET', 'POST'])]
    public function supprimer($id, CommandeClientRepository $commandeClientRepository): Response
    {
        $commandeClient = $commandeClientRepository->findOneBy(['id' => $id]);
        $commandeClient->setDeletedAt(new \DateTimeImmutable('now'));
        $commandeClientRepository->save($commandeClient, true);
        $this->addFlash('success', 'Commande client supprimée !');
        return $this->redirectToRoute('app_commande_client_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/traiter/{id}', name: 'app_commande_client_traiter', methods: ['GET', 'POST'])]
    public function traiter($id, CommandeClientRepository $commandeClientRepository): Response
    {
        $commandeClient = $commandeClientRepository->findOneBy(['id' => $id]);
        $commandeClient->setEtatTraite(true);
        $commandeClient->setUpdatedAt(new \DateTimeImmutable('now'));
        $commandeClientRepository->save($commandeClient, true);
        $this->addFlash('success', 'Commande client traitée !');
        return $this->redirectToRoute('app_commande_client_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @throws \Exception
     */
    #[Route('/valider/{id}', name: 'app_commande_client_valider', methods: ['GET', 'POST'])]
    public function valider($id, Request $request, LotRepository $lotRepository, FidelisationRepository $fidelisationRepository, GenerationPoints $generationPoints, CouponsRepository $couponsRepository, ClientCouponsRepository $clientCouponsRepository, ClientRepository $clientRepository, MoyenReglementRepository $moyenReglementRepository, CommandeClientRepository $commandeClientRepository, ReglementRepository $reglementRepository, ProduitCommandeClientRepository $produitCommandeClientRepository): Response
    {
        $dateLivraison = $request->request->get("dateLivraison");
        $moyenPaiement = $request->request->get("moyenPaiement");
        $echeance = $request->request->get("echeance");
        $coupon_get = $request->request->get("coupon");


        if ($dateLivraison != null and $moyenPaiement != null and $echeance != null){
            $moyenPaiement = $moyenReglementRepository->findOneBy(['id' => $moyenPaiement]);

            $commandeClient = $commandeClientRepository->findOneBy(['id' => $id]);


            if ($coupon_get != null){
                $coupon = $couponsRepository->findOneBy(['libelle' => $coupon_get]);
                if (!$coupon){
                    $this->addFlash('error', 'Le coupon n\'existe pas !');
                    return $this->redirectToRoute('app_commande_client_index', [], Response::HTTP_SEE_OTHER);
                }

                if ($coupon->getDateFin() != null){
                    if ($coupon->getDateFin()->format('Y-m-d') < date('Y-m-d') OR !$coupon->isEtat()){
                        $this->addFlash('error', 'Le coupon n\'est plus valide !');
                        return $this->redirectToRoute('app_commande_client_index', [], Response::HTTP_SEE_OTHER);
                    }
                }else{
                    if (!$coupon->isEtat()){
                        $this->addFlash('error', 'Le coupon n\'est plus valide !');
                        return $this->redirectToRoute('app_commande_client_index', [], Response::HTTP_SEE_OTHER);
                    }
                }

                $clientCoupon = $clientCouponsRepository->findOneBy(['coupon' => $coupon, 'client' => $commandeClient->getClient()]);

                if (!$clientCoupon){
                    $this->addFlash('error', 'Le coupon n\'existe pas !');
                    return $this->redirectToRoute('app_commande_client_index', [], Response::HTTP_SEE_OTHER);
                }

                if (!$clientCoupon->getCoupon()->isEtat()){
                    $this->addFlash('error', 'Votre coupon n\'est plus valide !');
                    return $this->redirectToRoute('app_commande_client_index', [], Response::HTTP_SEE_OTHER);
                }

                $montantCouponFinal = $coupon->getMontant() - $clientCoupon->getMontantUtilise();

                if ($montantCouponFinal > $commandeClient->getTotalTtc()){
                    $commandeClient->setCoupon($commandeClient->getTotalTtc());
                    $clientCoupon->setMontantUtilise($clientCoupon->getMontantUtilise() + $commandeClient->getTotalTtc());
                }elseif ($montantCouponFinal == $commandeClient->getTotalTtc()){
                    $commandeClient->setCoupon($commandeClient->getTotalTtc());
                    $clientCoupon->setMontantUtilise($clientCoupon->getMontantUtilise() + $commandeClient->getTotalTtc());
                    $clientCoupon->setEtat(false);
                } else{
                    $commandeClient->setCoupon($montantCouponFinal);
                    $clientCoupon->setMontantUtilise($clientCoupon->getMontantUtilise() + $montantCouponFinal);
                }
            }

            $commandeClient->setEtatValide(true);
            $commandeClient->setDateLivraisonAt(new \DateTimeImmutable($dateLivraison));
            $commandeClient->setMoyenPaiement($moyenPaiement);
            $commandeClient->setEcheance($echeance);
            $commandeClient->setUpdatedAt(new \DateTimeImmutable('now'));
            $commandeClientRepository->save($commandeClient, true);

            $client = $commandeClient->getClient();
            $clientFidel = $fidelisationRepository->findOneBy(['client' => $client, 'etat' => true]);
            if ($clientFidel){
                $clientFidel->setPoints($generationPoints->addPoints($clientFidel, $commandeClient->getTotalTtc()));
                $fidelisationRepository->save($clientFidel, true);
            }

            // Edit Lot
            $produitCommandeClients = $produitCommandeClientRepository->findBy(['commandeClient' => $commandeClient]);
            foreach ($produitCommandeClients as $produitCommandeClient) {
                $quantiteCommandee = $produitCommandeClient->getQuantiteLivree(); // Quantité commandée initiale
                // Triez les lots par ordre croissant de la date de péremption
                $lots = $lotRepository->findBy(['produit' => $produitCommandeClient->getProduit()], ['datePeremptionAt' => 'ASC']);
                foreach ($lots as $lot) {
                    if ($quantiteCommandee <= 0) {
                        break; // Toutes les quantités ont été satisfaites, sortir de la boucle
                    }
                    // Vérifier si le lot a suffisamment de stock pour satisfaire la quantité restante
                    if ($lot->getStock() >= $quantiteCommandee) {
                        $lot->setStock($lot->getStock() - $quantiteCommandee);
                        $quantiteCommandee = 0; // Toutes les quantités ont été satisfaites
                    } else {
                        // Le stock du lot est insuffisant pour satisfaire la quantité restante,
                        // déduire la quantité disponible du lot et mettre à jour la quantité restante
                        $quantiteCommandee -= $lot->getStock();
                        $lot->setStock(0);
                    }
                    // Enregistrer les modifications du lot
                    $lotRepository->save($lot, true);
                }
            }


            // Save reglement
            $reglement = new Reglement();
            $reglement->setCommandeClient($commandeClient);
            $reglement->setMontant($commandeClient->getTotalTtc());
            $reglement->setModeReglement($moyenPaiement);
            $reglement->setEcheanceAt($echeance);
            $reglementRepository->save($reglement, true);

            $this->addFlash('success', 'Commande client validée !');
        }else{
            $this->addFlash('error', 'Veuillez renseigner tous les champs svp !');
        }
        return $this->redirectToRoute('app_commande_client_index', [], Response::HTTP_SEE_OTHER);
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
            $this->addFlash('success', 'Commande client modifiée !');
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
            $this->addFlash('success', 'Commande client supprimée !');
        }

        return $this->redirectToRoute('app_commande_client_index', [], Response::HTTP_SEE_OTHER);
    }
}
