<?php

namespace App\Controller\Api;

use App\Entity\Equipment;
use App\Entity\Site;
use App\Entity\User;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends ApiController
{
    /**
     * @Route("/dashboard", name="homepage")
     */
    public function homePage(): Response
    {
        return $this->render('homepage.html.twig');
    }

    /**
     * @Route("/users", name="users_axios")
     */
    public function getUsers (): JsonResponse
    {
            $users =$users = [
                [
                    'id' => 1,
                    'name' => 'Olususi Oluyemi',
                    'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation',
                    'imageURL' => 'https://randomuser.me/api/portraits/women/50.jpg'
                ],
                [
                    'id' => 2,
                    'name' => 'Camila Terry',
                    'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation',
                    'imageURL' => 'https://randomuser.me/api/portraits/men/42.jpg'
                ],
                [
                    'id' => 3,
                    'name' => 'Joel Williamson',
                    'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation',
                    'imageURL' => 'https://randomuser.me/api/portraits/women/67.jpg'
                ],
                [
                    'id' => 4,
                    'name' => 'Deann Payne',
                    'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation',
                    'imageURL' => 'https://randomuser.me/api/portraits/women/50.jpg'
                ],
                [
                    'id' => 5,
                    'name' => 'Donald Perkins',
                    'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation',
                    'imageURL' => 'https://randomuser.me/api/portraits/men/89.jpg'
                ]
            ];
        $users = $this->getDoctrine()->getManager()->getRepository(User::class)->allUsers()->getArrayResult();

        return new JsonResponse($users);
    }

    /**
     * @Route("/dashboard_data", name="dashboard_data")
     */
    public function dashboardData(): JsonResponse
    {
        $em = $this->getDoctrine()->getManager();
        $equipments = $em->getRepository(Equipment::class)->allEquipments()->getArrayResult();
        $users = $em->getRepository(User::class)->allUsers()->getArrayResult();
        $sites = $em->getRepository(Site::class)->allSitesWithNbUser()->getScalarResult();

        $data = [
            'users' => $users,
            'equipments' => $equipments,
            'sites' => $sites,
        ];

        return $this->json($data);
    }
}
