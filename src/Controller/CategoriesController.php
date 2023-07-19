<?php

namespace App\Controller;

use App\Entity\Categories;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
// use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;


#[Route('/categories', name: 'categories_')]
class CategoriesController extends AbstractController
{

    #[Route('/{id}', name: 'list')]
    // #[ParamConverter('product', class: 'App\Entity\Products')]
    public function list(Categories $category): Response
    {
        //on va chercher la liste des produits de la catégorie :
        $products = $category->getProducts();
        //  dd($product);
        return $this->render('categories/list.html.twig', compact('category','products'));

        // Autre syntaxe présentée par Benoit:
        // return $this->render('categories/list.html.twig', [
        //     'category'=> $category,
        //     'prodcuts'=> $products
        // ]);
    }
}

