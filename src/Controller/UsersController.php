<?php

namespace App\Controller;

use App\Entity\Users;
use App\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UsersController extends AbstractController
{
    #[Route('/users', name: 'app_users')]
    public function index(UsersRepository $usersRepository): Response
    {
        return $this->render('users/index.html.twig', [
            'users' => $usersRepository->findBy(['deletedAt' => null], ['username'=>'ASC']),
        ]);
    }

    #[Route('/users/supprimer/{id}', name: 'app_users_delete')]
    public function delete(Users $users, UsersRepository $usersRepository)
    {
        $users->setDeletedAt(new \DateTimeImmutable('now'));
        $usersRepository->save($users, true);
        if ($users->getId() == $this->getUser()->getId()){
            return $this->redirectToRoute('app_logout');
        }
        return $this->redirectToRoute('app_users');
    }

    #[Route('/users/edit/{id}', name: 'app_users_edit')]
    public function edit(Users $users, Request $request, UsersRepository $usersRepository)
    {
        $username = $request->request->get("username");
        $adresse = $request->request->get("adresse");
        $user = $usersRepository->findOneBy(['username' => $username]);
        if ($user){
            // TODO :: Message pour informer que l'user est déjà prit
            return $this->redirectToRoute('app_users');
        }
        $users->setUsername($username);
        $users->setAdresse($adresse);
        $users->setUpdatedAt(new \DateTimeImmutable('now'));
        $usersRepository->save($users, true);
        if ($users->getId() == $this->getUser()->getId()){
            return $this->redirectToRoute('app_logout');
        }
        return $this->redirectToRoute('app_users');
    }

    #[Route('/users/{id}', name: 'app_users_state')]
    public function state(Users $users, UsersRepository $usersRepository)
    {
        if ($users->isState()){
            $users->setState(false);
        }else{
            $users->setState(true);
        }
        $usersRepository->save($users, true);
        return $this->redirectToRoute('app_users');
    }
}
