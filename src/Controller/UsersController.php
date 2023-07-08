<?php

namespace App\Controller;

use App\Entity\Users;
use App\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class UsersController extends AbstractController
{
    #[Route('/dashboard/users', name: 'app_users')]
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
        $this->addFlash('success', 'Utilisateur supprimé !');
        if ($users->getId() == $this->getUser()->getId()){
            return $this->redirectToRoute('app_logout');
        }
        return $this->redirectToRoute('app_users');
    }

    #[Route('/users/edit/{id}', name: 'app_users_edit')]
    public function edit(Users $users, Request $request, UsersRepository $usersRepository, UserPasswordHasherInterface $userPasswordHasher)
    {
        $adresse = $request->request->get("adresse");
        $entreprise = $request->request->get("entreprise");
        $ville = $request->request->get("ville");
        $tel = $request->request->get("tel");
        $pass = $request->request->get("pass");
        //$username = $request->request->get("username");
        $users->setAdresse($adresse);
        $users->setEntreprise($entreprise);
        $users->setVille($ville);
        $users->setTel($tel);
        //$users->setUsername($username);
        if ($pass !== null){
            $users->setPassword(
                $userPasswordHasher->hashPassword(
                    $users,
                    $pass
                )
            );
        }
        $users->setUpdatedAt(new \DateTimeImmutable('now'));
        $usersRepository->save($users, true);
        $this->addFlash('success', 'Utilisateur modifié !');
        if ($users->getId() == $this->getUser()->getId()){
            return $this->redirectToRoute('app_logout');
        }
        return $this->redirectToRoute('app_users');
    }

    #[Route('/users/editPassword', name: 'app_users_edit_password')]
    public function editPassword(Request $request, UsersRepository $usersRepository, UserPasswordHasherInterface $userPasswordHasher)
    {
        $password = $request->request->get('password');
        $newPassword = $request->request->get('newPassword');
        $newPassword2 = $request->request->get('newPassword2');


        $user = $usersRepository->findOneBy(['id' => $this->getUser()]);

        if ($userPasswordHasher->isPasswordValid($user, $password) == false) {
            $this->addFlash('error', 'Mot de passe incorrect !');
            return $this->redirectToRoute('app_dashboard');
        }

        if ($newPassword != $newPassword2){
            $this->addFlash('error', 'Les deux mot de passe ne sont pas identique !');
            return $this->redirectToRoute('app_dashboard');
        }

        $user->setPassword(
            $userPasswordHasher->hashPassword(
                $user,
                $newPassword
            )
        );

        $usersRepository->save($user, true);

        $this->addFlash('success', 'Mot de passe modifié avec succès !');
        return $this->redirectToRoute('app_dashboard');
    }

    #[Route('/users/{id}', name: 'app_users_state')]
    public function state(Users $users, UsersRepository $usersRepository)
    {
        if ($users->isState()){
            $users->setState(false);
            $this->addFlash('success', 'Compte activé !');
        }else{
            $users->setState(true);
            $this->addFlash('success', 'Compte désactivé !');
        }
        $usersRepository->save($users, true);
        return $this->redirectToRoute('app_users');
    }
}
