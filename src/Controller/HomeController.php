<?php
/**
 *  Copyright (c) isandre.net
 *  Created by PhpStorm.
 *  User: Isandre47
 *  Date: 05/06/2020 21:15
 *
 */

namespace App\Controller;

use App\Entity\Site;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    /**
     * @return Response
     */
    #[Route('/', name: 'home')]
    public function index()
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    /**
     * @Route("/about", name="about", methods={"GET"})
     */
    public function about()
    {
        return $this->render('home/about.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    /**
     * @Route("/services", name="services", methods={"GET"})
     */
    public function services()
    {
        return $this->render('home/services.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    /**
     * @Route("/contact", name="contact"), methods={"GET"})
     */
    public function contact()
    {
        return $this->render('home/contact.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    /**
     * @Route("/user-show/{id}", name="user_show", methods={"GET"})
     */
    public function show(User $user)
    {
        $siteClient = "";

        if ($user->getRoles()[0] == 'ROLE_CLIENT') {
            $em = $this->getDoctrine()->getManager();
            $siteClient = $em->getRepository(Site::class)->findBy([
                'client' => $user->getClient()->getId(),
                ]
            );
        }

        return $this->render('home/userShow.html.twig', [
            'user' => $this->getUser(),
            'siteClient' => $siteClient,
        ]);
    }
}
