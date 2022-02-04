<?php

namespace App\Controller\Api;

use App\Repository\SiteRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/site")
 */
class SiteController extends ApiController
{
    /**
     * @Route("/index", name="site_index", methods={"GET"})
     */
    public function index(SiteRepository $siteRepository): Response
    {
        return $this->render('admin/site/index.html.twig', [
            'sites' => $siteRepository->findAll(),
        ]);
    }
}
