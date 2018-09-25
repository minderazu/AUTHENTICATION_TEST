<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AdminSecurityController extends AbstractController
{
    /**
     * @Route("/admin_login", name="admin_login")
     */

    public function admin_login(Request $request, AuthenticationUtils $utils)
    {
        $error = $utils->getLastAuthenticationError();

        $auth_checker = $this->get('security.authorization_checker');

        if ($auth_checker->isGranted('ROLE_SUPER_ADMIN')) {
            return $this->render('admin/dashboard.html.twig', [
                'controller_name' => 'AdminController',
            ]);
                } else{
                    return $this->render('admin_security/admin_login.html.twig', [
                        'error' => $error
                    ]);
        }
    }

    /**
     * @Route("/admin_logout", name="admin_logout")
     */
        
    public function admin_logout()
    {
    
    }
}
