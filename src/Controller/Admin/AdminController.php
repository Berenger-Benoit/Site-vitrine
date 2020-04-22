<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    
     /**
     * @Route("/admin/list", name="admin_list", methods={"GET"})
     */
    public function list(ProductRepository $pr)
    {
        $products = $pr->findAll();

        return $this->render('admin/list.html.twig', [
            'products' => $products,
        ]);
    }


        /**
     * @Route("/admin/new", name="admin_new",methods={"GET","POST"})
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

            return $this->redirectToRoute('admin_list');
        }

        return $this->render('admin/new.html.twig', [
            'form' => $form->createView(),
            ]);
    }

    /**
     * @Route("admin/edit/{id}", name="admin_product_edit", requirements={"id": "\d+"}, methods={"GET", "POST"})
     */
    public function edit(Product $product,Request $request)
    {
        $form = $this->createForm(ProductType::class, $product);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $product->setUpdatedAt(new \DateTime());
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('primary', 'Le Produit a été mis à jour!');


            return $this->redirectToRoute('admin_list');
        }

        return $this->render('admin/edit.html.twig', [
        'product' => $product,
        'form' => $form->createView(),
        ]);
    }

      /**
     * @Route("admin/delete/{id}", name="admin_product_delete", requirements={"id": "\d+"}, methods={"DELETE"})
     */
    public function delete(Product $product, Request $request)
    {
        if($this->isCsrfTokenValid('delete'. $product->getId(), $request->get('_token'))){
            $em = $this->getDoctrine()->getManager();
            $em->remove($product);
            $em->flush();
            $this->addFlash('danger', 'Le produit a été supprimé');
        }
        return $this->redirectToRoute('admin_list');
    }

}
