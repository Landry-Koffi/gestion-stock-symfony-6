<?php

namespace App\Controller;

use App\Entity\FeedBack;
use App\Repository\ClientCouponsRepository;
use App\Repository\ClientRepository;
use App\Repository\CommandeClientRepository;
use App\Repository\CommandeFournisseurRepository;
use App\Repository\FeedBackRepository;
use App\Repository\FidelisationRepository;
use App\Repository\ProduitCommandeClientRepository;
use App\Repository\ProduitCommandeFournisseurRepository;
use App\Repository\ProduitRepository;
use App\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/dashboard')]
class HomeController extends AbstractController
{
    #[Route('/', name: 'app_dashboard')]
    public function index(CommandeClientRepository $commandeClientRepository, FidelisationRepository $fidelisationRepository, ClientCouponsRepository $clientCouponsRepository, UsersRepository $usersRepository, ClientRepository $clientRepository, CommandeFournisseurRepository $commandeFournisseurRepository, ProduitCommandeClientRepository $produitCommandeClientRepository, ProduitCommandeFournisseurRepository $produitCommandeFournisseurRepository, ProduitRepository $produitRepository): Response
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

        $user = $usersRepository->findOneBy(['id' => $this->getUser()]);

        if (in_array('ROLE_ADMIN', $user->getRoles())){
            $point = 0;
            $cmdClients = null;
            $prdCmdClients = null;
            $coupons = null;
            $monnaie = 0;
        }else{
            $client = $clientRepository->findOneBy(['tel' => $user->getTel()]);

            $cmdClients = $commandeClientRepository->findBy(['client' => $client], ['dateCommandeAt'=> 'DESC']);
            $prdCmdClients = $produitCommandeClientRepository->findBy([], ['createdAt'=> 'DESC']);
            $coupons = $clientCouponsRepository->findBy(['client' => $client, 'etat' => true], ['createdAt'=> 'DESC']);
            $monnaie = $fidelisationRepository->findOneBy(['client' => $client])->getMonnaie();
            $point = $fidelisationRepository->findOneBy(['client' => $client])->getPoints();
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
            "points" => $point,
            "cmdClients" => $cmdClients,
            "prdCmdClients" => $prdCmdClients,
            'coupons' => $coupons,
            'monnaie' => $monnaie,
        ]);
    }

    #[Route('/add-feedback', name: 'app_add_feedback')]
    public function feedback(UsersRepository $usersRepository, ClientRepository $clientRepository, FeedBackRepository $feedBackRepository, Request $request)
    {
        $title = $request->request->get('title');
        $content = $request->request->get('content');

        $user = $usersRepository->findOneBy(['id' => $this->getUser()]);
        $client = $clientRepository->findOneBy(['tel' => $user->getTel()]);

        if ($title != "" and $content != ""){
            $feedback = new FeedBack();
            $feedback->setTitle($title);
            $feedback->setContent($content);
            $feedback->setClient($client);
            $feedback->setCreatedAt(new \DateTimeImmutable('now'));
            $feedBackRepository->save($feedback, true);
            $this->addFlash('success', 'Feedback envoyé avec succès !');
            return $this->redirectToRoute('app_dashboard');
        }else{
            $this->addFlash('error', 'Veuillez renseigner tous les champs !');
            return $this->redirectToRoute('app_dashboard');
        }
    }


}
