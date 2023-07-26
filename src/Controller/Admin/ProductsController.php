<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Products;
use App\Form\ProductsFormType;
use Doctrine\ORM\EntityManagerInterface;

#[Route('/admin/produits', name: 'admin_products_')]
class ProductsController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('admin/products/index.html.twig');
    }

    #[Route('/ajout', name: 'add')]
    public function add(Request $request, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        //création d'un nouveau produit:
        $product = new Products();
        //création du formulaire
        $productForm = $this->createForm(ProductsFormType::class, $product);

        //Traitement de la requête du formulaire
        $productForm->handleRequest($request);
        // dd pour le dumper: 
        // dd($productForm);

        //Vérification de la validité du formulaire soumis
        if($productForm->isSubmitted() && $productForm->isValid()){
            //Conversion du prix en centimes
            $prix = $product->getPrice() * 100;
            $product->setPrice($prix);
            // dd($prix);

            //Enregistrement dans la BDD (stockage)
            $em->persist($product);
            $em->flush();

            //Redirection
            return $this->redirectToRoute('admin_products_index');           
        }



        // 1ère syntaxe du return possible:
        return $this->render('admin/products/add.html.twig', [
            'productForm' => $productForm->createView()
        ]);

        // 2nd syntaxe du return possible
        // return $this->renderForm('admin/products/add.html.twig', compact('productForm'));
        // compact('productForm') signifie  ['productForm' => $productForm]
    }

    #[Route('/edition/{id}', name: 'edit')]
    public function edit(Products $product): Response
    {
        // vérification de la possiblité d'édition avec le voter pour l'utilisateur:
        $this->denyAccessUnlessGranted('PRODUCT_EDIT', $product);
        return $this->render('admin/products/index.html.twig');
    }
    #[Route('/suppression/{id}', name: 'delete')]
    public function delete(Products $product): Response
    {
        return $this->render('admin/products/index.html.twig', );
    }
}
