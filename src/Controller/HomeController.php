<?php

namespace App\Controller;

use App\Repository\CommandeClientRepository;
use App\Repository\CommandeFournisseurRepository;
use App\Repository\ProduitCommandeClientRepository;
use App\Repository\ProduitCommandeFournisseurRepository;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/dashboard', name: 'app_dashboard')]
    public function index(CommandeClientRepository $commandeClientRepository, CommandeFournisseurRepository $commandeFournisseurRepository, ProduitCommandeClientRepository $produitCommandeClientRepository, ProduitCommandeFournisseurRepository $produitCommandeFournisseurRepository, ProduitRepository $produitRepository): Response
    {
        $commandeClients_encours = $commandeClientRepository->findBy(['deletedAt' => null, 'etatTraite' => false]);
        $commandeClients_traites = $commandeClientRepository->findBy(['deletedAt' => null, 'etatTraite' => true]);
        $commandeClients_attente_validations = $commandeClientRepository->findBy(['deletedAt' => null, 'etatValide' => false]);
        $commandeClients_validees = $commandeClientRepository->findBy(['deletedAt' => null, 'etatValide' => true]);
        $somme_commande_client_encours = 0;
        $somme_commande_client_traites = 0;
        $somme_commande_client_attente_validations = 0;
        $somme_commande_client_validees = 0;
        if ($commandeClients_encours != null){
            foreach ($commandeClients_encours as $commandeClient){
                $somme_commande_client_encours = $somme_commande_client_encours + $commandeClient->getTotalTtc();
            }
        }
        if ($commandeClients_traites != null){
            foreach ($commandeClients_traites as $commandeClient){
                $somme_commande_client_traites = $somme_commande_client_traites + $commandeClient->getTotalTtc();
            }
        }
        if ($commandeClients_attente_validations != null){
            foreach ($commandeClients_attente_validations as $commandeClient){
                $somme_commande_client_attente_validations = $somme_commande_client_attente_validations + $commandeClient->getTotalTtc();
            }
        }
        if ($commandeClients_validees != null){
            foreach ($commandeClients_validees as $commandeClient){
                $produitCommandeClients = $produitCommandeClientRepository->findBy(['commandeClient' => $commandeClient]);
                if($produitCommandeClients != null){
                    foreach ($produitCommandeClients as $produitCommandeClient){
                        $somme_commande_client_validees = $somme_commande_client_validees + $produitCommandeClient->getProduit()->getPrixVente() * $produitCommandeClient->getQuantiteLivree();
                    }
                }
            }
        }
        return $this->render('home/index.html.twig', [
            "nb_commande_client_encours" => $commandeClientRepository->count(['deletedAt' => null ,'etatTraite' => false]),
            "nb_commande_client_traite" => $commandeClientRepository->count(['deletedAt' => null ,'etatTraite' => true]),
            "nb_commande_client_en_attente_validation" => $commandeClientRepository->count(['deletedAt' => null ,'etatValide' => false]),
            "nb_commande_client_validee" => $commandeClientRepository->count(['deletedAt' => null ,'etatValide' => true]),
            "nb_commande_fournisseur_encours" => $commandeFournisseurRepository->count(['deletedAt' => null ,'etatTraite' => false]),
            "nb_commande_fournisseur_traite" => $commandeFournisseurRepository->count(['deletedAt' => null ,'etatTraite' => true]),
            "nb_commande_fournisseur_en_attente_validation" => $commandeFournisseurRepository->count(['deletedAt' => null ,'etatValide' => false]),
            "nb_commande_fournisseur_validee" => $commandeFournisseurRepository->count(['deletedAt' => null ,'etatValide' => true]),
            "somme_commande_client_encours" => $somme_commande_client_encours,
            "somme_commande_client_traites" => $somme_commande_client_traites,
            "somme_commande_client_attente_validations" => $somme_commande_client_attente_validations,
            "somme_commande_client_validees" => $somme_commande_client_validees,
        ]);
    }
}
