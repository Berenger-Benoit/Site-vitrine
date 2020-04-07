<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\Category;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("/product/{id}", name="products", requirements={"id": "\d+"})
     */
    public function list(ProductRepository $pr, Category $category)
    {
        $products = $pr->findProducts($category);
        return $this->render('product/list.html.twig', [
            'products' => $products,
            'category' => $category,
        ]);
    }

     /**
     * @Route("/product/category-{category_id}/detail/product-{product_id}", name="product-show", requirements={"id": "\d+"})
     * @ParamConverter("category", options={"id" = "category_id"})
     * @ParamConverter("product", options={"id" = "product_id"})
     * 
     */
    public function show(ProductRepository $pr, Product $product, Category $category)
    {
        $product = $pr->find($product);
        return $this->render('product/show.html.twig', [
            'product' => $product,
            'category'=> $category
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
