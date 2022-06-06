<?php

namespace App\Controller\Api;

use App\Entity\Site;
use App\Repository\SiteRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * @Route("/api/site")
 */
class SiteController extends ApiController
{
    /**
     * @Route("/index", name="api_site_index", methods={"GET"})
     */
    public function index(ManagerRegistry $managerRegistry): JsonResponse
    {
        $em = $managerRegistry->getManager();
        $sites = $em->getRepository(Site::class)->indexSite()->getScalarResult();

        return $this->json(['sites' => $sites]);
    }

    /**
     * @param Site $site
     * @return JsonResponse
     * @Route("/show/{id}", name="api_site_show")
     */
    public function show(Site $site): JsonResponse
    {
        $serializer = new Serializer(
            [new ObjectNormalizer()],
            [new JsonEncoder()]
        );
        $jsonContent =$serializer->serialize($site, 'json', [
            'circular_reference_limit' => 1,
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);

        return $this->responseObject($jsonContent);
    }
}
