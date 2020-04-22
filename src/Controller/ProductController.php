<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\Category;
use App\Repository\ProductRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("/product/{id}", name="products", requirements={"id": "\d+"} ,methods={"GET"})
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
     * @Route("/product/category-{category_id}/detail/product-{product_id}", name="product-show", requirements={"id": "\d+"},methods={"GET"})
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

   

}
