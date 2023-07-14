<?php

namespace App\Services;

use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class Pagination
{
    private PaginatorInterface $paginator;
    private Request $request;
    public function __construct(PaginatorInterface $paginator, RequestStack $requestStack)
    {
        $this->paginator = $paginator;
        $this->request = $requestStack->getCurrentRequest();
    }

    public function generate(array $categories){
        return $this->paginator->paginate(
            $categories,
            $this->request->query->getInt('page', 1), // Numéro de page actuel, récupéré à partir de la requête GET
            10 // Nombre d'éléments à afficher par page
        );
    }
}
