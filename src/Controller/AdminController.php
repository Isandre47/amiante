<?php
/**
 *  Copyright (c) isandre.net
 *  Created by PhpStorm.
 *  User: Isandre47
 *  Date: 22/05/2020 20:06
 *
 */

namespace App\Controller;

use App\Entity\Equipment;
use App\Entity\Site;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AdminController
 * @package App\Controller
 * @Route("/admin")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/", name="admin")
     */
    public function index(UserRepository $userRepository)
    {
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository(User::class)->findAll();
        $equipments = $em->getRepository(Equipment::class)->findAll();
        $sites = $em->getRepository(Site::class)->findAll();

        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
            'users' => $users,
            'equipments' => $equipments,
            'sites' => $sites,
            'nbClient' => $userRepository->count(['site' => null]),
        ]);
    }
}
