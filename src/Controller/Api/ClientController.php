<?php

namespace App\Controller\Api;

use App\Entity\Client;
use App\Entity\User;
use Doctrine\DBAL\Exception;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
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

    /**
     * @Route("/add", name="api_client_add", methods={"POST"})
     */
    public function new(Request $request, ManagerRegistry $managerRegistry, SerializerInterface $serializer, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $em = $managerRegistry->getManager();
        if ($request->isMethod('POST')) {
            $client = $serializer->deserialize($request->getContent(), Client::class, 'json');
            $em->persist($client);
            try {
                $em->flush();
            } catch (Exception $exception) {
                return $this->json('Error client');
            }

            $user = $serializer->deserialize($request->getContent(), User::class, 'json');
            $user->setClient($em->getRepository(Client::class)->findOneByName($client->getName()));
            $user->setRoles(["ROLE_CLIENT"]);
            $user->setPassword($passwordEncoder->encodePassword($user, json_decode($request->getContent())->password));
            $em->persist($user);

            try {
                $em->flush();
            } catch (Exception $exception) {
                return $this->json('Error user');
            }

        }

        return $this->json('Created');
    }
}
