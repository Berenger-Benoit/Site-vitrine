<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    
     /**
     * @Route("/admin/list", name="admin_list")
     */
    public function list(ProductRepository $pr)
    {
        $products = $pr->findAll();

        return $this->render('admin/list.html.twig', [
            'products' => $products,
        ]);
    }


        /**
     * @Route("/admin/new", name="admin_new")
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

        return $this->render('admin/new.html.twig', [
            'form' => $form->createView(),
            ]);
    }

    /**
     * @Route("admin/edit/{id}", name="admin_product_edit", requirements={"id": "\d+"}, methods={"GET", "POST"})
     */
    public function edit()
    {
        dd('edit');
    }

      /**
     * @Route("admin/delete/{id}", name="admin_product_delete", requirements={"id": "\d+"}, methods={"DELETE"})
     */
    public function delete()
    {
        dd('delete');
    }

}
