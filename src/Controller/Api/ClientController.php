<?php

namespace App\Controller\Api;

use App\Entity\Client;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/api/client")
 */
class ClientController extends ApiController
{
    /**
     * @Route("/index", name="api_clients_index")
     */
    public function clientIndex(ManagerRegistry $managerRegistry): JsonResponse
    {
        $em = $managerRegistry->getManager();
        $clients = $em->getRepository(Client::class)->clientIndex()->getArrayResult();

        return $this->json(['clients' => $clients]);
    }

    /**
     * @Route("/show/{id}", name="api_client_show")
     */
    public function show(Client $client): JsonResponse
    {
        $serializer = new Serializer(
            [new ObjectNormalizer()],
            [new JsonEncoder()]
        );
        $jsonContent =$serializer->serialize($client, 'json', [
            'circular_reference_limit' => 1,
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);

        return $this->responseObject($jsonContent);
    }
}
