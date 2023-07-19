<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
// use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use App\Entity\Products;

	#[Route('/produits', name: 'products_')]
	
	class ProductsController extends AbstractController
	{
    #[Route('/', name: 'app_products')]
	    public function index(): Response
	    {
	        return $this->render('products/index.html.twig', [
	            'controller_name' => 'ProductsController',
	        ]);
	    }
	
	    #[Route('/{id}', name: 'details')]
	    // #[App\Controller\ParamConverter('product', class: 'App\Entity\Products')]
	    public function details(Products $product): Response
	    {
	        // dd($product);
            //on lui demande de nous renvoyer dans un tableau associatif
	        return $this->render('products/details.html.twig', compact('product'));
	    }
    	}
