<?php

namespace App\Controller;

use App\Entity\Fidelisation;
use App\Entity\Users;
use App\Form\FidelisationType;
use App\Repository\ClientRepository;
use App\Repository\FidelisationRepository;
use App\Repository\RolesRepository;
use App\Repository\UsersRepository;
use App\Services\Pagination;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/dashboard/fidelisation')]
class FidelisationController extends AbstractController
{
    #[Route('/', name: 'app_fidelisation_index', methods: ['GET'])]
    public function index(FidelisationRepository $fidelisationRepository, Pagination $paginator): Response
    {
        return $this->render('fidelisation/index.html.twig', [
            'fidelisations' => $paginator->generate($fidelisationRepository->findBy([], ['id' => 'DESC'])),
        ]);
    }


    #[Route('/etat/{id}', name: 'app_fidelisation_state')]
    public function fidelisationState(Fidelisation $fidelisation,UsersRepository $usersRepository, FidelisationRepository $fidelisationRepository)
    {
        $user = $usersRepository->findOneBy(['tel' => $fidelisation->getClient()->getTel()]);
        if ($fidelisation->isEtat()){
            $fidelisation->setEtat(false);
            $user->setState(true);
            $this->addFlash('success', 'Fidélisation désactivée !');
        }else{
            $fidelisation->setEtat(true);
            $user->setState(false);
            $this->addFlash('success', 'Fidélisation activée !');
        }
        $fidelisationRepository->save($fidelisation, true);
        $usersRepository->save($user, true);
        return $this->redirectToRoute('app_fidelisation_index');
    }
    #[Route('/add-monnaie', name: 'app_fidelisation_add_monnaie', methods: ['GET', 'POST'])]
    public function addMonnaie(FidelisationRepository $fidelisationRepository, ClientRepository $clientRepository, Request $request)
    {
        $montant = $request->request->get('montant');
        $client_get = $request->request->get('client');
        $client = $clientRepository->findOneBy(['id' => $client_get]);
        if ($client and $montant){
            $clientFidel = $fidelisationRepository->findOneBy(['client' => $client]);
            if ($clientFidel->getMonnaie() == null){
                $montantBase = 0;
            }else{
                $montantBase = $clientFidel->getMonnaie();
            }
            $clientFidel->setMonnaie($montantBase + $montant);
            $fidelisationRepository->save($clientFidel, true);
            $this->addFlash('success', 'Monnaie ajoutée !');
        }else{
            $this->addFlash('error', 'Client ou montant invalid !');
        }
        return $this->redirectToRoute('app_fidelisation_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/retirer-monnaie', name: 'app_fidelisation_retirer_monnaie', methods: ['GET', 'POST'])]
    public function retirerMonnaie(FidelisationRepository $fidelisationRepository, ClientRepository $clientRepository, Request $request)
    {
        $montant = $request->request->get('montant');
        $client_get = $request->request->get('client');
        $client = $clientRepository->findOneBy(['id' => $client_get]);
        if ($client and $montant){
            $clientFidel = $fidelisationRepository->findOneBy(['client' => $client]);
            if ($clientFidel->getMonnaie() == null or $clientFidel->getMonnaie() < $montant){
                $this->addFlash('error', 'Montant invalid !');
            }else{
                $montantBase = $clientFidel->getMonnaie();
                $clientFidel->setMonnaie($montantBase - $montant);
                $fidelisationRepository->save($clientFidel, true);
                $this->addFlash('success', 'Monnaie retiré !');
            }
        }else{
            $this->addFlash('error', 'Client ou montant invalid !');
        }
        return $this->redirectToRoute('app_fidelisation_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/retirer-points/{id}', name: 'app_fidelisation_retirer_points', methods: ['GET', 'POST'])]
    public function retirerPoints($id, FidelisationRepository $fidelisationRepository)
    {
        $fidelisation = $fidelisationRepository->findOneBy(['id' => $id]);
        $fidelisation->setPoints(0);
        $fidelisationRepository->save($fidelisation, true);
        $this->addFlash('success', 'Points retirés !');
        return $this->redirectToRoute('app_fidelisation_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/new', name: 'app_fidelisation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, FidelisationRepository $fidelisationRepository,
                        ClientRepository $clientRepository, RolesRepository $rolesRepository,
                        UserPasswordHasherInterface $userPasswordHasher, UsersRepository $usersRepository): Response
    {
        $fidelisation = new Fidelisation();
        $client_form = $request->request->get("client");
        $roles = $request->request->get("roles");

        $client = $clientRepository->findOneBy(['id' => $client_form]);

        if ($client != null){

            $users = new Users();
            $users->setTel($client->getTel());
            $users->setVille($client->getVille());
            $users->setEntreprise('Pas entreprise');
            $users->setAdresse($client->getAdresse());
            $users->setState(false); // Client non bloqué
            $username = $client->getTel();
            $users->setPassword($userPasswordHasher->hashPassword($users, $username));
            $users->setUsername($username);
            $users->setRoles([$roles]);
            $users->setCreatedAt(new \DateTimeImmutable('now'));
            $users->setUpdatedAt(new \DateTimeImmutable('now'));

            $words = explode(" ", trim($client->getLibelle()));

            $users->setNom($words[0]);
            $users->setPrenoms(implode(" ", array_slice($words, 1)));

            $usersRepository->save($users, true);

            $fidelisation->setClient($client);
            $fidelisation->setEtat(true);
            $fidelisation->setMonnaie(0);
            $fidelisation->setCreatedAt(new \DateTimeImmutable('now'));
            $fidelisationRepository->save($fidelisation, true);
            $this->addFlash('success', 'Client ajouté à la fidelisation !');
            return $this->redirectToRoute('app_fidelisation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('fidelisation/new.html.twig', [
            'fidelisation' => $fidelisation,
            'fidelisations' => $fidelisationRepository->findBy([], ['id' => 'DESC']),
            'clients' => $clientRepository->findBy([], ['id' => 'DESC']),
            'roles' => $rolesRepository->findBy([], ['id' => 'DESC'])
        ]);
    }

    #[Route('/{id}', name: 'app_fidelisation_delete', methods: ['POST'])]
    public function delete(Request $request, Fidelisation $fidelisation, FidelisationRepository $fidelisationRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$fidelisation->getId(), $request->request->get('_token'))) {
            $fidelisationRepository->remove($fidelisation, true);
        }

        return $this->redirectToRoute('app_fidelisation_index', [], Response::HTTP_SEE_OTHER);
    }
}
