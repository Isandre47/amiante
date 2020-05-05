<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class UserController
 * @package App\Controller
 * @Route("/admin")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/users", name="users_index")
     */
    public function indexUsers(UserRepository $userRepository)
    {
        return $this->render('admin/user/index.html.twig',[
            'users' => $userRepository->findAll(),
        ]);
    }
}
