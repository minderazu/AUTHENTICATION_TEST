<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\CreateUserType;
use App\Repository\UserRepository;
use App\Event\UserCreatedEvent;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class AdminController extends AbstractController
{

    /**
     * @Route("/admin", name="admin")
     */

    public function admin()
    {
        return $this->render('admin/dashboard.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    /**
     * @Route("/admin/create_user", name="create_user")
     * Method({"GET", "POST"})
     */

    public function create_user(Request $request, UserPasswordEncoderInterface $passwordEncoder, EventDispatcherInterface $dispatcher)
    {
        $user = new User();

        $form = $this->createForm(CreateUserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());

            $user->setPassword($password);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->getConnection()->beginTransaction();

            $entityManager->persist($user);
            $entityManager->flush();

            $event = new UserCreatedEvent($user);
            $dispatcher->dispatch(UserCreatedEvent::NAME, $event);

            $entityManager->commit();
        }

        return $this->render('admin/create_user.html.twig', [
            'user_form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/result", name="user_search")
     * Method({"POST"}) 
     */
    public function user_search(Request $request)
    {
        $email = $request->request->get('email');

        $result = $this->getDoctrine()
            ->getRepository(User::class)
            ->findByExampleField($email);

        if ($result) {

            return $this->render('admin/result.html.twig', ['result' => $result]);

        } else {

            return $this->render('admin/result.html.twig', [
                'error' => 'No user found with this email ' . $email
            ]);

        }
    }
}
