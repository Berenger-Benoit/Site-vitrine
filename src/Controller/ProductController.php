<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\ProductRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController
{
    /**
     * @Route("/product/{id}", name="product", requirements={"id": "\d+"})
     */
    public function list(ProductRepository $pr, Category $category)
    {
        $products = $pr->find($category);
        return $this->render('product/list.html.twig', [
            'products' => $products,
        ]);
    }
}
