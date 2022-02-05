<?php

namespace App\Controller\Api;

use App\Repository\SiteRepository;
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
    public function index(SiteRepository $siteRepository): JsonResponse
    {
        return $this->json($siteRepository->indexSite());
    }
}
