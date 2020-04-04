<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\Category;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController
{
    /**
     * @Route("/product/{id}", name="product", requirements={"id": "\d+"})
     */
    public function list(ProductRepository $pr, Category $category)
    {
        $products = $pr->findProducts($category);
        //  dd($products);
        return $this->render('product/list.html.twig', [
            'products' => $products,
            'category' => $category,
        ]);
    }

        /**
     * @Route("/product/new", name="new_product")
     */
    public function new(Request $request)
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($product);

            $em->flush();

            $this->addFlash('success', 'Le bien a été ajouté!');

            return $this->redirectToRoute('home');
        }

        return $this->render('product/new.html.twig', [
            'form' => $form->createView(),
            ]);
    }

}
