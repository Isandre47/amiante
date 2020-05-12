<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class UserController
 * @package App\Controller
 * @Route("/admin/users")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="user_index")
     */
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('admin/user/index.html.twig',[
            'users' => $userRepository->findAll(),
        ]);
    }

    /**
     * @Route("/edit/{id}", name="user_edit")
     */
    public function edit(Request $request, User $user): Response
    {
        $formUser = $this->createForm(UserType::class, $user);
        $formUser->handleRequest($request);
        $userRole = $user->getRoles();

        if ($formUser->isSubmitted() && $formUser->isValid()) {
            $user->setRoles([$request->request->get('user')['roles']]);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('admin/user/edit.html.twig',[
            'users' => $user,
            'userRole' => $userRole,
            'formUser' => $formUser->createView(),
        ]);
    }

    /**
     * @Route("/show/{id}", name="user_show_admin")
     */
    public function show(User $user)
    {
        return $this->render('admin/user/show.html.twig', [
            'user' => $user,
        ]);
    }
}
