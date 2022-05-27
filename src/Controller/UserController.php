<?php
/**
 *  Copyright (c) isandre.net
 *  Created by PhpStorm.
 *  User: Isandre47
 *  Date: 05/06/2020 21:15
 *
 */

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class UserController
 * @package App\Controller
 * @Route("/admin/users")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="user_index"), methods={"GET"})
     */
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('admin/user/index.html.twig',[
            'users' => $userRepository->findAll(),
        ]);
    }

    /**
     * @Route("/edit/{id}", name="user_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, User $user, ManagerRegistry $managerRegistry): Response
    {
        $siteOrigin = $user->getSite()->getName();
        $formUser = $this->createForm(UserType::class, $user);
        $formUser->handleRequest($request);
        $userRole = $user->getRoles();

        if ($formUser->isSubmitted() && $formUser->isValid()) {
            $user->setRoles([$request->request->get('user')['roles']]);
            if ($siteOrigin != $request->attributes->get('user')->getSite()->getName()) {
                $newSite = [
                    'date_arrived' => new \DateTime(),
                    'site' => $request->attributes->get('user')->getSite()->getName(),
                ];
                $new = $user->getHistory();
                $new[] = $newSite;
                $user->setHistory($new);
            }
            $managerRegistry->getManager()->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('admin/user/edit.html.twig',[
            'users' => $user,
            'userRole' => $userRole,
            'formUser' => $formUser->createView(),
        ]);
    }

    /**
     * @Route("/show/{id}", name="user_show_admin", methods={"GET"})
     */
    public function show(User $user): Response
    {
        return $this->render('admin/user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/new", name="user_new", methods={"GET","POST"})
     */
    public function new(Request $request, UserPasswordEncoderInterface $passwordEncoder, ManagerRegistry $managerRegistry): RedirectResponse|Response
    {
        $user = new User();
        $formUser = $this->createForm(UserType::class, $user);
        $formUser->add('password', PasswordType::class, [
            'attr' => [
                'class' => 'form-control m-1'
            ],
            'label' => 'Mot de passe'
        ]);
        $formUser->handleRequest($request);

        if ($formUser->isSubmitted() && $formUser->isValid()) {
            $em = $managerRegistry->getManager();
            $user->setPassword($passwordEncoder->encodePassword($user, $user->getPassword()));
            $user->setRoles(["ROLE_USER"]);
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('admin/user/new.html.twig', [
            'formUser' => $formUser->createView(),
        ]);
    }
}
