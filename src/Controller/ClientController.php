<?php
/**
 *  Copyright (c) isandre.net
 *  Created by PhpStorm.
 *  User: Isandre47
 *  Date: 05/06/2020 21:15
 *
 */

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Site;
use App\Entity\User;
use App\Form\UserType;
use App\Repository\ClientRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class ClientController
 * @package App\Controller
 * @Route("/client")
 */
class ClientController extends AbstractController
{
    /**
     * @Route("/", name="client_index", methods={"GET"})
     */
    public function index(ClientRepository $clientRepository)
    {
        return $this->render('admin/client/index.html.twig', [
            'clients' => $clientRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="client_new", methods={"GET","POST"})
     */
    public function new(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $client = new Client();
        $user = new User();
        $formClient = $this->createForm(UserType::class, $user);
        $formClient->remove('site');
        $formClient->remove('roles');
        $formClient->add('password', PasswordType::class, [
            'label' => 'Mot de passe',
            'attr' => [
                'class' => 'form-control m-1'
            ],
        ]);
        $formClient->add('name', TextType::class, [
            'mapped' => false,
            'label' => 'Nom de l\'entreprise',
            'attr' => [
                'class' => 'form-control m-1'
            ],
        ]);
        $formClient->handleRequest($request);

        if ($formClient->isSubmitted() && $formClient->isValid()) {
            $client->setName($request->request->get('user')['name']);
            $user->setRoles(["ROLE_CLIENT"]);
            $em = $this->getDoctrine()->getManager();
            $em->persist($client);
            $em->flush();
            $user->setClient($em->getRepository(Client::class)->findOneByName($client->getName()));
            $user->setPassword($passwordEncoder->encodePassword($user, $user->getPassword()));
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('client_index');
        }

        return $this->render('admin/client/new.html.twig', [
            'formClient' => $formClient->createView(),
        ]);
    }

    /**
     * @Route("/edit/{id}", name="client_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Client $client)
    {
        $user = $client->getUser();
        $formClient = $this->createForm(UserType::class, $user);
        $formClient->remove('site');
        $formClient->remove('roles');
        $formClient->add('site', EntityType::class, [
            'class' => Site::class,
            'choice_label' => 'name',
            'expanded' => true,
            'multiple' => false,
            'label' => 'Chantier à ajouter',
            'attr' => [
                'class' => 'form-check m-1'
            ]
        ]);
        $formClient->add('name', TextType::class, [
            'mapped' => false,
            'attr' => [
                'value' => $client->getName(),
                'class' =>  'form-control m-1'
            ],
            'label' => 'Nom de l\'entreprise',
        ]);
        $formClient->handleRequest($request);

        if ($formClient->isSubmitted() && $formClient->isValid()) {
            // Pour conserver le site_id d'un client à null lors de l'édition de sa fiche
            $user->setSite(null);
            $em = $this->getDoctrine()->getManager();
            $site = $em->getRepository(Site::class)->find($request->request->get('user')['site']);
            $site->setClient($client);
            $client->setName($request->request->get('user')['name']);
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute('client_index');
        }

        return $this->render('admin/client/edit.html.twig', [
            'formClient' => $formClient->createView(),
            'sites' => $client->getSite(),
        ]);
    }

    /**
     * @Route("/show/{id}", name="client_show", methods={"GET"})
     */
    public function show(Client $client)
    {
        return $this->render('admin/client/show.html.twig', [
            'client' => $client,
        ]);
    }
}
