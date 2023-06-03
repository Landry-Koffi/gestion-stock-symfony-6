<?php

namespace App\Security;

use App\Entity\Users;
use Symfony\Component\Security\Core\Exception\AccountExpiredException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAccountStatusException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserChecker implements UserCheckerInterface
{

    public function checkPreAuth(UserInterface $user): void
    {
        if (!$user instanceof Users) {
            return;
        }

        if ($user->isState() and $user->getDeletedAt() == null) {
            // the message passed to this exception is meant to be displayed to the user
            throw new CustomUserMessageAccountStatusException('Désolé, votre compte a été bloqué');
        }
        if (!$user->isState() and $user->getDeletedAt() != null) {
            // the message passed to this exception is meant to be displayed to the user
            throw new CustomUserMessageAccountStatusException("Désolé, votre compte n'existe pas");
        }
        if ($user->isState() and $user->getDeletedAt() != null) {
            // the message passed to this exception is meant to be displayed to the user
            throw new CustomUserMessageAccountStatusException("Désolé, vous ne pouvez pas vous connecter");
        }
    }

    public function checkPostAuth(UserInterface $user): void
    {
        if (!$user instanceof Users) {
            return;
        }

        // user account is expired, the user may be notified
        /*if ($user->getDeletedAt()) {
            throw new AccountExpiredException('...');
        }*/
    }
}