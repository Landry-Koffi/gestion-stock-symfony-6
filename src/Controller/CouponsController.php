<?php

namespace App\Controller;

use App\Entity\ClientCoupons;
use App\Entity\Coupons;
use App\Form\CouponsType;
use App\Repository\ClientCouponsRepository;
use App\Repository\ClientRepository;
use App\Repository\CouponsRepository;
use App\Repository\FidelisationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/dashboard/coupons')]
class CouponsController extends AbstractController
{
    #[Route('/', name: 'app_coupons_index', methods: ['GET'])]
    public function index(CouponsRepository $couponsRepository): Response
    {
        return $this->render('coupons/index.html.twig', [
            'coupons' => $couponsRepository->findBy([], ['id' => 'DESC']),
        ]);
    }

    #[Route('/new', name: 'app_coupons_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CouponsRepository $couponsRepository): Response
    {
        $coupon = new Coupons();
        $form = $this->createForm(CouponsType::class, $coupon);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $coupon->setEtat(true);
            $couponsRepository->save($coupon, true);

            return $this->redirectToRoute('app_coupons_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('coupons/new.html.twig', [
            'coupon' => $coupon,
            'form' => $form,
        ]);
    }

    #[Route('/coupon/{id}', name: 'app_coupon_state')]
    public function state(Coupons $coupons, CouponsRepository $couponsRepository)
    {
        if ($coupons->isEtat()){
            $coupons->setEtat(false);
            $this->addFlash('success', 'Coupon désactivé !');
        }else{
            $coupons->setEtat(true);
            $this->addFlash('success', 'Coupon activé !');
        }
        $couponsRepository->save($coupons, true);
        return $this->redirectToRoute('app_coupons_index');
    }

    #[Route('/attributer/coupon', name: 'app_attribuer_coupon')]
    public function attribuerCoupon(CouponsRepository $couponsRepository, FidelisationRepository $fidelisationRepository): Response
    {
        return $this->renderForm('coupons/attribuer_coupon.html.twig', [
            'coupons' => $couponsRepository->findBy(['etat' => true]),
            'fidelisations' => $fidelisationRepository->findBy(['etat' => true])
        ]);
    }

    #[Route('/attributer/coupon/add', name: 'app_attribuer_coupon_add')]
    public function addAttribuerCoupon(CouponsRepository $couponsRepository, ClientRepository $clientRepository, ClientCouponsRepository $clientCouponsRepository, Request $request)
    {
        $clientFidels = $request->request->all('clientFidels');
        $coupon_get = $request->request->get('coupon');
        $coupon = $couponsRepository->findOneBy(['libelle' => $coupon_get]);

        if ($clientFidels !== null and $coupon != null){
            foreach ($clientFidels as $clientFidel){
                $client = $clientRepository->findOneBy(['id' => $clientFidel]);
                $clientCoupons = new ClientCoupons();
                $clientCoupons->setClient($client);
                $clientCoupons->setCoupon($coupon);
                $clientCoupons->setMontantUtilise(0);
                $clientCoupons->setCreatedAt(new \DateTimeImmutable('now'));
                $clientCoupons->setUpdatedAt(new \DateTimeImmutable('now'));
                $clientCouponsRepository->save($clientCoupons, true);
            }
            $this->addFlash('success', 'Coupon attribué avec succès !');
        }else{
            $this->addFlash('error', 'Veuillez renseigner tous les champs !');
        }

        return $this->redirectToRoute('app_coupons_index');
    }

    #[Route('/{id}/edit', name: 'app_coupons_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Coupons $coupon, CouponsRepository $couponsRepository): Response
    {
        $form = $this->createForm(CouponsType::class, $coupon);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $couponsRepository->save($coupon, true);

            return $this->redirectToRoute('app_coupons_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('coupons/edit.html.twig', [
            'coupon' => $coupon,
            'form' => $form,
        ]);
    }
}
