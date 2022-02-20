<?php

namespace App\Controller\Api;

use App\Entity\Site;
use App\Entity\User;
use Doctrine\DBAL\Exception;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/api/user")
 */
class UserController extends ApiController
{
    /**
     * @Route("/index", name="api_users_index ")
     */
    public function index(ManagerRegistry $managerRegistry): JsonResponse
    {

        $em = $managerRegistry->getManager();
        $users = $em->getRepository(User::class)->allUsersWithSites()->getArrayResult();

        return $this->json($users);
    }

    /**
     * @Route("/show/{id}", name="api_users_show")
     */
    public function getUserInfo(User $user, ObjectNormalizer $objectNormalizer, SerializerInterface$serializer): Response
    {
//        $users = $this->getDoctrine()->getRepository(User::class)->findOneBy(['id' => $user->getId()]);
//        $userInfo = $serializer->serialize($user, 'json', ['groups' => 'user-show']);

//        $users = $this->getDoctrine()->getRepository(User::class)->userInfo($user->getId());
//        dd($users);
        // On spécifie qu'on utilise l'encodeur JSON
//        $encoders = [new JsonEncoder()];

        // On instancie le "normaliseur" pour convertir la collection en tableau
//        $normalizers = [new ObjectNormalizer()];

        // On instancie le convertisseur
//        $serializer = new Serializer($normalizers, $encoders);

        // On convertit en json
        $jsonContent = $serializer->serialize($user, 'json', [
            'circular_reference_limit' => 1,
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);

        return $this->responseObject($jsonContent);
    }

    /**
     * @Route("/add", name="api_user_add", methods={"POST"})
     */
    public function new(Request $request, ManagerRegistry $managerRegistry, SerializerInterface $serializer, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $em = $managerRegistry->getManager();
        if ($request->isMethod('POST')) {

            $user = $serializer->deserialize($request->getContent(), User::class, 'json');
            $user->setRoles([json_decode($request->getContent())->role]);
            $user->setSite($em->getRepository(Site::class)->findOneBy(['id'=>json_decode($request->getContent())->site]));
            $user->setPassword($passwordEncoder->encodePassword($user, json_decode($request->getContent())->password));

            $em->persist($user);
            try {
                $em->flush();
            } catch (Exception $exception) {
                return $this->json('Error');
            }
        }

        return $this->json('Created');
    }

    /**
     * @Route("/edit/{id}", name="api_user_edit")
     */
    public function edit(User $user, ManagerRegistry $managerRegistry, Request $request, SerializerInterface $serializer)
    {
        $em = $managerRegistry->getManager();
        if ($request->isMethod('POST')) {
            $userEdit = $serializer->deserialize($request->getContent(), User::class, 'json', [AbstractNormalizer::OBJECT_TO_POPULATE => $user]);
            $userEdit->setRoles([json_decode($request->getContent())->role]);
            $userEdit->setSite($em->getRepository(Site::class)->findOneBy(['id'=>json_decode($request->getContent())->site]));
            try {
                $em->flush();
            } catch (Exception $exception) {
                return $this->json('Error');
            }
        }
        return $this->json('Edited');
    }

    /**
     * @Route("/roles_list", name="api_users_role_list", methods={"GET"})
     */
    public function getListRole(): JsonResponse
    {
        return $this->json([
            ['name'=>'Utilisateur', 'id'=> User::ROLE_USER],
            ['name'=>'Administrateur', 'id'=> User::ROLE_ADMIN],
            ['name'=>'Client', 'id'=> User::ROLE_CLIENT],
            ]);
    }
}
