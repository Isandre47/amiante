<?php

namespace App\Controller\Api;

use App\Entity\Site;
use App\Repository\SiteRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/site")
 */
class SiteController extends ApiController
{
    /**
     * @Route("/index", name="api_site_index", methods={"GET"})
     */
    public function index(SiteRepository $siteRepository, ManagerRegistry $managerRegistry): JsonResponse
    {
        $em = $managerRegistry->getManager();
        $sites = $em->getRepository(Site::class)->indexSite()->getArrayResult();

        return $this->json(['sites' => $sites]);
    }
}
