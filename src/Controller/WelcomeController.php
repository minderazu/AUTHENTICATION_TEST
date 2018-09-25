<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class WelcomeController extends AbstractController
{
    /**
     * @Route("/welcome", name="welcome")
     */
    
    public function welcome()
    {

        return $this->render('welcome/welcome.html.twig', [
            'controller_name' => 'WelcomeController',
        ]);
    }
}
