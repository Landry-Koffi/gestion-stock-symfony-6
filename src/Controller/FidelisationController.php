<?php

namespace App\Controller;

use App\Entity\Fidelisation;
use App\Form\FidelisationType;
use App\Repository\ClientRepository;
use App\Repository\FidelisationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/dashboard/fidelisation')]
class FidelisationController extends AbstractController
{
    #[Route('/', name: 'app_fidelisation_index', methods: ['GET'])]
    public function index(FidelisationRepository $fidelisationRepository): Response
    {
        return $this->render('fidelisation/index.html.twig', [
            'fidelisations' => $fidelisationRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_fidelisation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, FidelisationRepository $fidelisationRepository, ClientRepository $clientRepository): Response
    {
        $fidelisation = new Fidelisation();
        $client_form = $request->request->get("client");

        $client = $clientRepository->findOneBy(['id' => $client_form]);

        if ($client != null){
            $fidelisation->setClient($client);
            $fidelisation->setEtat(true);
            $fidelisation->setCreatedAt(new \DateTimeImmutable('now'));
            $fidelisationRepository->save($fidelisation, true);
            $this->addFlash('success', 'Client ajouté à la fidelisation !');
            return $this->redirectToRoute('app_fidelisation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('fidelisation/new.html.twig', [
            'fidelisation' => $fidelisation,
            'fidelisations' => $fidelisationRepository->findAll(),
            'clients' => $clientRepository->findAll(),
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
