<?php

namespace App\Controller\Api;

use App\Entity\Equipment;
use App\Entity\Site;
use App\Entity\User;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
use function Symfony\Component\Translation\t;

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
     * @Route("/users_page", name="users_axios")
     */
    public function getUsers(): JsonResponse
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

        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository(User::class)->allUsersWithSites()->getArrayResult();

        $data = [
            'users' => $users,
        ];

        return $this->json($data);
    }

    /**
     * @Route("/user/{id}", name="users_show_react")
     */
    public function getUserInfo(User $user, SerializerInterface $serializer, ObjectNormalizer $objectNormalizer): Response
    {
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository(User::class)->findOneBy(['id' => $user->getId()]);
        // On spécifie qu'on utilise l'encodeur JSON
        $encoders = [new JsonEncoder()];

        // On instancie le "normaliseur" pour convertir la collection en tableau
        $normalizers = [new ObjectNormalizer()];

        // On instancie le convertisseur
        $serializer = new Serializer($normalizers, $encoders);

        // On convertit en json
        $jsonContent = $serializer->serialize($users, 'json', [
            'circular_reference_limit' => 1,
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);

        // On instancie la réponse
        $response = new Response($jsonContent);

        // On ajoute l'entête HTTP
        $response->headers->set('Content-Type', 'application/json');
        $trimmed  = trim($jsonContent,"\"" );

        return $this->json('', 200)->setContent($trimmed);
    }

    /**
     * @Route("/dashboard_data", name="dashboard_data")
     */
    public function dashboardData(): JsonResponse
    {
        $em = $this->getDoctrine()->getManager();

        try {
            $equipments = $em->getRepository(Equipment::class)->allEquipments()->getArrayResult();
            $users = $em->getRepository(User::class)->allUsers()->getArrayResult();
            $sites = $em->getRepository(Site::class)->allSitesWithNbUser()->getScalarResult();
        } catch (\Exception $exception) {
            return $this->json($exception->getMessage(), 404, []);
        }

        $data = [
            'users' => $users,
            'equipments' => $equipments,
            'sites' => $sites,
        ];

        return $this->json($data);
    }
}
