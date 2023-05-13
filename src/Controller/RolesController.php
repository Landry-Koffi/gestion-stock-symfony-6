<?php

namespace App\Controller;

use App\Entity\Roles;
use App\Form\RolesType;
use App\Repository\RolesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/roles')]
class RolesController extends AbstractController
{
    #[Route('/', name: 'app_roles_index', methods: ['GET'])]
    public function index(RolesRepository $rolesRepository): Response
    {
        return $this->render('roles/index.html.twig', [
            'roles' => $rolesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_roles_new', methods: ['GET', 'POST'])]
    public function new(Request $request, RolesRepository $rolesRepository): Response
    {
        $role = new Roles();
        $form = $this->createForm(RolesType::class, $role);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $rolesRepository->save($role, true);

            return $this->redirectToRoute('app_roles_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('roles/new.html.twig', [
            'role' => $role,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_roles_show', methods: ['GET'])]
    public function show(Roles $role): Response
    {
        return $this->render('roles/show.html.twig', [
            'role' => $role,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_roles_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Roles $role, RolesRepository $rolesRepository): Response
    {
        $form = $this->createForm(RolesType::class, $role);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $rolesRepository->save($role, true);

            return $this->redirectToRoute('app_roles_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('roles/edit.html.twig', [
            'role' => $role,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_roles_delete', methods: ['POST'])]
    public function delete(Request $request, Roles $role, RolesRepository $rolesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$role->getId(), $request->request->get('_token'))) {
            $rolesRepository->remove($role, true);
        }

        return $this->redirectToRoute('app_roles_index', [], Response::HTTP_SEE_OTHER);
    }
}
