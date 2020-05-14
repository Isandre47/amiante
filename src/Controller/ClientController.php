<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\User;
use App\Form\UserType;
use App\Repository\ClientRepository;
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
     * @Route("/", name="client_index")
     */
    public function index(ClientRepository $clientRepository)
    {
        return $this->render('admin/client/index.html.twig', [
            'clients' => $clientRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="client_new")
     */
    public function new(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $client = new Client();
        $user = new User();
        $formClient = $this->createForm(UserType::class, $user);
        $formClient->remove('site');
        $formClient->remove('roles');
        $formClient->add('password', PasswordType::class);
        $formClient->add('name', TextType::class, [
            'mapped' => false
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
     * @Route("/edit/{id}", name="client_edit")
     */
    public function edit(Request $request, User $user)
    {
        $client = $this->getDoctrine()->getRepository(Client::class)->find($user->getClient()->getId());
        $formClient = $this->createForm(UserType::class, $user);
        $formClient->remove('site');
        $formClient->remove('roles');
        $formClient->add('name', TextType::class, [
            'mapped' => false,
            'attr' => [
                'value' => $user->getClient()->getName(),
            ]
        ]);
        $formClient->handleRequest($request);

        if ($formClient->isSubmitted() && $formClient->isValid()) {
            $client->setName($request->request->get('user')['name']);
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute('client_index');
        }

        return $this->render('admin/client/edit.html.twig', [
            'formClient' => $formClient->createView(),
        ]);
    }
}
