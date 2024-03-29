<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(CategoryRepository $cr)
    {
        $categories = $cr->findAll();
        return $this->render('home/index.html.twig', [
            'categories' => $categories
        ]);
    }

  
    /**
     * @Route("/acces-horaires", name="acces-horaires" ,methods={"GET"} )
     */
    public function acces()
    {
        return $this->render('home/horaires.html.twig');
    }


    /**
     * @Route("/history", name="history" ,methods={"GET"} )
     */
    public function history()
    {
        return $this->render('home/history.html.twig');
    }
 
}
