<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function contact(Request $request)
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
          
            $this->addFlash(
                'success',
                'Votre email a bien été envoyé !'
            );
           
            return $this->redirectToRoute('contact',[
                'form' => $form->createView(),
            ]);

          
        }
        
   
        return $this->render('contact/contact.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
