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

        return $this->response($data);
    }
}
