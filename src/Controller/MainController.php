<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    //AbstractController permet d'aller chercher les services automatiquement mais il n'est pas obligatoire
    //l'annotation suivante permet de créer l'adresse:
    #[Route('/', name: 'main')]
    public function index(): Response
    //la méthode ci-dessus renvoie une réponse (composant de HttpFoundation) 
    //qui est  un raccourci vers le moteur de twig pour indiquer le chemin
    {
        return $this->render('main/index.html.twig',);
    }
}
